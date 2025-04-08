@extends('admin.layouts.admin')

@section('title', 'Detail Pesanan')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Detail Pesanan #{{ $order->order_number }}</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">Pesanan</a></li>
        <li class="breadcrumb-item active">Detail</li>
    </ol>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="row">
        <!-- Order Information -->
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-info-circle me-1"></i>
                    Informasi Pesanan
                </div>
                <div class="card-body">
                    <table class="table">
                        <tbody>
                            <tr>
                                <th width="40%">Order Number</th>
                                <td>{{ $order->order_number }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Pesanan</th>
                                <td>{{ $order->created_at->format('d M Y, H:i') }}</td>
                            </tr>
                            <tr>
                                <th>Total</th>
                                <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <th>Status Pesanan</th>
                                <td>
                                    <form action="{{ route('admin.orders.status', $order->id) }}" method="POST" class="d-flex">

                                        @csrf
                                        <select name="status" class="form-select form-select-sm me-2">
                                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        </select>
                                        <button type="submit" class="btn btn-sm btn-primary">Update</button>
                                        @method('PUT') <!-- INI WAJIB! -->
                                    </form>
                                </td>
                            </tr>
                            <tr>
                                <th>Status Pembayaran</th>
                                <td>
                                    <form action="{{ route('admin.orders.payment', $order->id) }}" method="POST" class="d-flex">
                                        @csrf
                                        <select name="payment_status" class="form-select form-select-sm me-2">
                                            <option value="pending" {{ $order->payment_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                                            <option value="failed" {{ $order->payment_status == 'failed' ? 'selected' : '' }}>Failed</option>
                                        </select>
                                        <button type="submit" class="btn btn-sm btn-primary">Update</button>
                                        @method('PUT') <!-- INI WAJIB! -->
                                    </form>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Customer Information -->
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-user me-1"></i>
                    Informasi Pelanggan
                </div>
                <div class="card-body">
                    <table class="table">
                        <tbody>
                            <tr>
                                <th width="40%">Nama</th>
                                <td>{{ $order->user->name }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $order->user->email }}</td>
                            </tr>
                            <tr>
                                <th>No. Telepon</th>
                                <td>{{ $order->user->phone ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Alamat</th>
                                <td>{{ $order->user->address ?? '-' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Items -->
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-list me-1"></i>
            Item Pesanan
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Produk</th>
                            <th>Harga</th>
                            <th width="10%">Jumlah</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                {{ $item->product->name }}
                                @if($item->product->image)
                                <img src="{{ Storage::url($item->product->image) }}" alt="{{ $item->product->name }}" class="img-thumbnail ms-2" style="width: 50px;">
                                @endif
                            </td>
                            <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" class="text-end fw-bold">Total</td>
                            <td class="fw-bold">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end mb-4">
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>
@endsection