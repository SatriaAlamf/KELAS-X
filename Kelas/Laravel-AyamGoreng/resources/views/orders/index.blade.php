@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">My Orders</h1>
            
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            
            @if($orders->isEmpty())
                <div class="alert alert-info">
                    You don't have any orders yet. <a href="{{ route('products.index') }}">Start shopping</a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="bg-light">
                            <tr>
                                <th>Order Number</th>
                                <th>Date</th>
                                <th>Total Amount</th>
                                <th>Status</th>
                                <th>Payment</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                            <tr>
                                <td>{{ $order->order_number }}</td>
                                <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                                <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                <td>
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
                                </td>
                                <td>
                                    @if($order->payment_status == 'pending')
                                        <span class="badge badge-warning">Pending</span>
                                    @elseif($order->payment_status == 'paid')
                                        <span class="badge badge-success">Paid</span>
                                    @elseif($order->payment_status == 'failed')
                                        <span class="badge badge-danger">Failed</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('orders.show', $order->order_number) }}" class="btn btn-sm btn-primary">
                                        <i class="fa fa-eye"></i> View Details
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-4">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection