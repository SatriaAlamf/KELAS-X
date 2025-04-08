@extends('layouts.app')

@section('title', 'Order Details')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Order Details</h1>
                <a href="{{ route('orders.index') }}" class="btn btn-secondary">
                    <i class="fa fa-arrow-left"></i> Back to Orders
                </a>
            </div>
            
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Order #{{ $order->order_number }}</h5>
                        <span class="text-muted">{{ $order->created_at->format('d M Y H:i') }}</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted">Order Status</h6>
                            @if($order->status == 'pending')
                                <span class="badge badge-warning">Pending</span>
                            @elseif($order->status == 'processing')
                                <span class="badge badge-info">Processing</span>
                            @elseif($order->status == 'shipped')
                                <span class="badge badge-primary">Shipped</span>
                            @elseif($order->status == 'delivered')
                                <span class="badge badge-success">Delivered</span>
                            @elseif($order->status == 'cancelled')
                                <span class="badge badge-danger">Cancelled</span>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Payment Status</h6>
                            @if($order->payment_status == 'pending')
                                <span class="badge badge-warning">Pending</span>
                            @elseif($order->payment_status == 'paid')
                                <span class="badge badge-success">Paid</span>
                            @elseif($order->payment_status == 'failed')
                                <span class="badge badge-danger">Failed</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted">Payment Method</h6>
                            <p>
                                @if($order->payment_method == 'cash')
                                    Cash on Delivery
                                @elseif($order->payment_method == 'transfer')
                                    Bank Transfer
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Shipping Address</h6>
                            <p>{{ $order->shipping_address }}</p>
                        </div>
                    </div>
                    
                    @if($order->notes)
                    <div class="row mb-4">
                        <div class="col-12">
                            <h6 class="text-muted">Notes</h6>
                            <p>{{ $order->notes }}</p>
                        </div>
                    </div>
                    @endif
                    
                    <h6 class="text-muted mb-3">Order Items</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="bg-light">
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($item->product && $item->product->image)
                                                <img src="{{ asset('storage/'.$item->product->image) }}" alt="{{ $item->product ? $item->product->name : 'Product' }}" class="img-thumbnail mr-3" style="width: 60px;">
                                            @endif
                                            <div>
                                                <h6 class="mb-0">{{ $item->product ? $item->product->name : 'Product Unavailable' }}</h6>
                                                @if($item->product)
                                                    <small class="text-muted">{{ $item->product->category->name }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-right"><strong>Total:</strong></td>
                                    <td><strong>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            
            @if($order->payment_method == 'transfer' && $order->payment_status == 'pending')
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Payment Instructions</h5>
                </div>
                <div class="card-body">
                    <p>Please transfer the total amount to one of the following bank accounts:</p>
                    <div class="mb-3">
                        <h6>Bank BCA</h6>
                        <p class="mb-0">Account Number: 1234567890</p>
                        <p class="mb-0">Account Name: Your Store Name</p>
                    </div>
                    <div class="mb-3">
                        <h6>Bank Mandiri</h6>
                        <p class="mb-0">Account Number: 0987654321</p>
                        <p class="mb-0">Account Name: Your Store Name</p>
                    </div>
                    <div class="alert alert-info mt-3">
                        <p class="mb-0">Please include your order number <strong>{{ $order->order_number }}</strong> in the transfer description.</p>
                    </div>
                </div>
            </div>
            @endif
            
            @if($order->status == 'shipped')
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Tracking Information</h5>
                </div>
                <div class="card-body">
                    <p>Your order has been shipped with the following details:</p>
                    <p><strong>Courier:</strong> JNE</p>
                    <p><strong>Tracking Number:</strong> {{ strtoupper(substr(md5($order->order_number), 0, 12)) }}</p>
                    <p>You can track your package using the tracking number above on the courier's website.</p>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection