@extends('admin.layouts.admin')

@section('title', 'Pesanan')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Pesanan</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Pesanan</li>
    </ol>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-filter me-1"></i>
            Filter
        </div>
        <div class="card-body">
            <form action="{{ route('admin.orders.index') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="search" class="form-label">Cari</label>
                    <input type="text" class="form-control" id="search" name="search" placeholder="No. Pesanan, Nama, atau Email" value="{{ request('search') }}">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-shopping-cart me-1"></i>
            Daftar Pesanan
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="ordersTable">
                    <thead>
                        <tr>
                            <th>Order #</th>
                            <th>Pelanggan</th>
                            <th>Total</th>
                            <th>Status Pesanan</th>
                            <th>Status Pembayaran</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td>{{ $order->order_number }}</td>
                            <td>{{ $order->user->name }}</td>
                            <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge bg-{{ 
                                    $order->status == 'completed' ? 'success' : 
                                    ($order->status == 'processing' ? 'info' : 
                                    ($order->status == 'cancelled' ? 'danger' : 'warning')) 
                                }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-{{ 
                                    $order->payment_status == 'paid' ? 'success' : 
                                    ($order->payment_status == 'pending' ? 'warning' : 'danger') 
                                }}">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                            </td>
                            <td>{{ $order->created_at->format('d M Y, H:i') }}</td>
                            <td>
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data pesanan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-end mt-3">
                {{ $orders->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Add any orders table specific scripts here
    });
</script>
@endpush