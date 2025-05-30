@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">Your Shopping Cart</h1>
            
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            
            @if($cart->items->isEmpty())
                <div class="alert alert-info">
                    Your cart is empty. <a href="{{ route('products.index') }}">Continue shopping</a>
                </div>
            @else
                <form action="{{ route('cart.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="bg-light">
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th width="150">Quantity</th>
                                    <th>Subtotal</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cart->items as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($item->product->image)
                                                <img src="{{ asset('storage/'.$item->product->image) }}" alt="{{ $item->product->name }}" class="img-thumbnail mr-3" style="width: 80px;">
                                            @endif
                                            <div>
                                                <h5>{{ $item->product->name }}</h5>
                                                <small class="text-muted">{{ $item->product->category->name }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Rp {{ number_format($item->product->price, 0, ',', '.') }}</td>
                                    <td>
                                        <input type="hidden" name="items[{{ $loop->index }}][id]" value="{{ $item->id }}">
                                        <input type="number" name="items[{{ $loop->index }}][quantity]" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}" class="form-control" required>
                                        <small class="text-muted">Available: {{ $item->product->stock }}</small>
                                    </td>
                                    <td>Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</td>
                                    <td>
                                        <form action="{{ route('cart.remove', $item->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to remove this item?')">
                                                <i class="fa fa-trash"></i> Remove
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-right"><strong>Total:</strong></td>
                                    <td colspan="2"><strong>Rp {{ number_format($cart->items->sum(function($item) { return $item->product->price * $item->quantity; }), 0, ',', '.') }}</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('products.index') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left"></i> Continue Shopping
                        </a>
                        <div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-refresh"></i> Update Cart
                            </button>
                            <a href="{{ route('checkout') }}" class="btn btn-success ml-2">
                                <i class="fa fa-shopping-cart"></i> Proceed to Checkout
                            </a>
                        </div>
                    </div>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection