<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }
    
    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        return view('admin.products.create', compact('categories'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_featured' => 'sometimes|boolean',
            'is_active' => 'sometimes|boolean',
        ]);
        
        $product = new Product();
        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->category_id = $request->category_id;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->is_featured = $request->has('is_featured');
        $product->is_active = $request->has('is_active');
        
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/products', $imageName);
            $product->image = 'products/' . $imageName;
        }
        
        $product->save();
        
        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }
    
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::where('is_active', true)->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_featured' => 'sometimes|boolean',
            'is_active' => 'sometimes|boolean',
        ]);
        
        $product = Product::findOrFail($id);
        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->category_id = $request->category_id;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->is_featured = $request->has('is_featured');
        $product->is_active = $request->has('is_active');
        
        if ($request->hasFile('image')) {
            // Delete old image
            if ($product->image) {
                Storage::delete('public/' . $product->image);
            }
            
            // Upload new image
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/products', $imageName);
            $product->image = 'products/' . $imageName;
        }
        
        $product->save();
        
        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }
    
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        
        // Delete product image
        if ($product->image) {
            Storage::delete('public/' . $product->image);
        }
        
        $product->delete();
        
        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }
}