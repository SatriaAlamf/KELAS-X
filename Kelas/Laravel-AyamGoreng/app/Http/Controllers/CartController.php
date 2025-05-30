<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cart = $this->getOrCreateCart();
        return view('cart.index', compact('cart'));
    }
    
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);
        
        $product = Product::findOrFail($request->product_id);
        
        if ($product->stock < $request->quantity) {
            return back()->with('error', 'Stock tidak mencukupi.');
        }
        
        $cart = $this->getOrCreateCart();
        
        $existingItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $request->product_id)
            ->first();
            
        if ($existingItem) {
            $newQuantity = $existingItem->quantity + $request->quantity;
            
            if ($product->stock < $newQuantity) {
                return back()->with('error', 'Stock tidak mencukupi.');
            }
            
            $existingItem->quantity = $newQuantity;
            $existingItem->save();
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);
        }
        
        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }
    
    public function updateCart(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:cart_items,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);
        
        foreach ($request->items as $item) {
            $cartItem = CartItem::findOrFail($item['id']);
            $product = Product::findOrFail($cartItem->product_id);
            
            if ($product->stock < $item['quantity']) {
                return back()->with('error', "Stock untuk {$product->name} tidak mencukupi.");
            }
            
            $cartItem->quantity = $item['quantity'];
            $cartItem->save();
        }
        
        return back()->with('success', 'Keranjang berhasil diperbarui.');
    }
    
    public function removeFromCart($id)
    {
        $cartItem = CartItem::findOrFail($id);
        $cartItem->delete();
        
        return back()->with('success', 'Item berhasil dihapus dari keranjang.');
    }
    
    private function getOrCreateCart()
    {
        $user = Auth::user();
        $cart = Cart::firstOrCreate(['user_id' => $user->id]);
        
        return Cart::with(['items.product'])->find($cart->id);
    }
}