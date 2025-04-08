<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('user');
        
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        
        if ($request->has('search')) {
            $query->where('order_number', 'like', '%' . $request->search . '%')
                ->orWhereHas('user', function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
                });
        }
        
        $orders = $query->latest()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }
    
    public function show($id)
    {
        $order = Order::with(['items.product', 'user'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }
    
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
        ]);
        
        $order = Order::findOrFail($id);
        
        // If order is cancelled and previously was not cancelled, restore product stock
        if ($request->status == 'cancelled' && $order->status != 'cancelled') {
            foreach ($order->items as $item) {
                $item->product->increaseStock($item->quantity);
            }
        }
        
        // If order was cancelled and now is not, decrease stock again
        if ($order->status == 'cancelled' && $request->status != 'cancelled') {
            foreach ($order->items as $item) {
                $item->product->decreaseStock($item->quantity);
            }
        }
        
        $order->status = $request->status;
        $order->save();
        
        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }
    
    public function updatePaymentStatus(Request $request, $id)
    {
        $request->validate([
            'payment_status' => 'required|in:pending,paid,failed',
        ]);
        
        $order = Order::findOrFail($id);
        $order->payment_status = $request->payment_status;
        $order->save();
        
        return back()->with('success', 'Status pembayaran berhasil diperbarui.');
    }
}