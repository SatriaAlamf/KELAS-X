@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8">
            <h1 class="mb-4">Checkout</h1>
            
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            
            <form action="{{ route('orders.place') }}" method="POST">
                @csrf
                
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Shipping Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Full Name</label>
                            <input type="text" class="form-control" id="name" value="{{ $user->name }}" readonly>
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" value="{{ $user->email }}" readonly>
                        </div>
                        
                        <div class="form-group">
                            <label for="shipping_address">Shipping Address</label>
                            <textarea name="shipping_address" id="shipping_address" rows="3" class="form-control @error('shipping_address') is-invalid @enderror" required>{{ old('shipping_address', $user->address ?? '') }}</textarea>
                            @error('shipping_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Payment Method</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <div class="custom-control custom-radio mb-2">
                                <input type="radio" id="payment_method_cash" name="payment_method" value="cash" class="custom-control-input" checked>
                                <label class="custom-control-label" for="payment_method_cash">Cash on Delivery</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="payment_method_transfer" name="payment_method" value="transfer" class="custom-control-input">
                                <label class="custom-control-label" for="payment_method_transfer">Bank Transfer</label>
                            </div>
                            @error('payment_method')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Additional Notes</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <textarea name="notes" id="notes" rows="3" class="form-control" placeholder="Special instructions for delivery or order (optional)">{{ old('notes') }}</textarea>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('cart.index') }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left"></i> Back to Cart
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-check"></i> Place Order
                    </button>
                </div>
            </form>
        </div>
        
        <div class="col-lg-4 mt-4 mt-lg-0">
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Order Summary</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <tbody>
                                @foreach($cart->items as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <p class="mb-0">{{ $item->product->name }}</p>
                                                <small class="text-muted">{{ $item->quantity }} x Rp {{ number_format($item->product->price, 0, ',', '.') }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-right">
                                        Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="border-top">
                                <tr>
                                    <th>Total</th>
                                    <th class="text-right">Rp {{ number_format($cart->items->sum(function($item) { return $item->product->price * $item->quantity; }), 0, ',', '.') }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection