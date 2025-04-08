<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('orders.index', compact('orders'));
    }
    
    public function show($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->where('user_id', Auth::id())
            ->firstOrFail();
            
        return view('orders.show', compact('order'));
    }
    
    public function checkout()
    {
        $cart = Cart::with(['items.product'])->where('user_id', Auth::id())->firstOrFail();
        
        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong.');
        }
        
        // Check stock
        foreach ($cart->items as $item) {
            if ($item->product->stock < $item->quantity) {
                return redirect()->route('cart.index')
                    ->with('error', "Stock untuk {$item->product->name} tidak mencukupi.");
            }
        }
        
        $user = Auth::user();
        
        return view('orders.checkout', compact('cart', 'user'));
    }
    
    public function place(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string',
            'payment_method' => 'required|in:cash,transfer',
            'notes' => 'nullable|string',
        ]);
        
        $cart = Cart::with(['items.product'])->where('user_id', Auth::id())->firstOrFail();
        
        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong.');
        }
        
        // Process order inside a transaction
        DB::beginTransaction();
        
        try {
            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => Order::generateOrderNumber(),
                'total_amount' => $cart->total,
                'status' => 'pending',
                'payment_method' => $request->payment_method,
                'payment_status' => 'pending',
                'shipping_address' => $request->shipping_address,
                'notes' => $request->notes,
            ]);
            
            // Create order items and reduce stock
            foreach ($cart->items as $item) {
                if ($item->product->stock < $item->quantity) {
                    throw new \Exception("Stock untuk {$item->product->name} tidak mencukupi.");
                }
                
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);
                
                // Reduce stock
                $item->product->decreaseStock($item->quantity);
            }
            
            // Clear cart
            $cart->items()->delete();
            
            DB::commit();
            
            return redirect()->route('orders.show', $order->order_number)
                ->with('success', 'Pesanan berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
}