@extends('admin.layouts.admin')
@section('title', 'Dashboard')
@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
    
    <!-- Stats Cards Row -->
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-0">Rp {{ number_format($totalSales, 0, ',', '.') }}</h5>
                            <div class="small">Total Penjualan</div>
                        </div>
                        <div>
                            <i class="fas fa-money-bill-wave fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{ route('admin.orders.index') }}">Lihat Detail</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-0">{{ $totalOrders }}</h5>
                            <div class="small">Total Pesanan</div>
                        </div>
                        <div>
                            <i class="fas fa-shopping-cart fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{ route('admin.orders.index') }}">Lihat Detail</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-0">{{ $totalProducts }}</h5>
                            <div class="small">Total Produk</div>
                        </div>
                        <div>
                            <i class="fas fa-box fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{ route('admin.products.index') }}">Lihat Detail</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-danger text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-0">{{ $totalCustomers }}</h5>
                            <div class="small">Total Pelanggan</div>
                        </div>
                        <div>
                            <i class="fas fa-users fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{ route('admin.users.index', ['role' => 'customer']) }}">Lihat Detail</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Charts Row -->
    
    
    <!-- Tables Row -->
    <div class="row">
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-clock me-1"></i>
                    Pesanan Terbaru
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>No. Pesanan</th>
                                    <th>Pelanggan</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Waktu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentOrders as $order)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.orders.show', $order->id) }}" class="text-decoration-none">
                                            #{{ $order->order_number }}
                                        </a>
                                    </td>
                                    <td>{{ $order->user->name }}</td>
                                    <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                    <td>
                                        @if($order->status == 'pending')
                                        <span class="badge bg-warning">Pending</span>
                                        @elseif($order->status == 'processing')
                                        <span class="badge bg-info">Processing</span>
                                        @elseif($order->status == 'completed')
                                        <span class="badge bg-success">Completed</span>
                                        @elseif($order->status == 'cancelled')
                                        <span class="badge bg-danger">Cancelled</span>
                                        @endif
                                    </td>
                                    <td>{{ $order->created_at->diffForHumans() }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada pesanan terbaru</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-primary">
                        Lihat Semua Pesanan
                    </a>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-exclamation-triangle me-1"></i>
                    Produk Stok Menipis
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th>Kategori</th>
                                    <th>Harga</th>
                                    <th>Stok</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($lowStockProducts as $product)
                                <tr>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->category->name }}</td>
                                    <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                    <td>
                                        <span class="badge bg-danger">{{ $product->stock }}</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada produk dengan stok menipis</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-primary">
                        Kelola Semua Produk
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
<script>
    // Sales Chart - Example data (replace with actual data from backend)
    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    const salesData = [5000000, 7500000, 8000000, 9000000, 11000000, 8500000, 10000000, 12000000, 9500000, 13000000, 11500000, 15000000];
    
    // Setup sales chart
    const salesCtx = document.getElementById('salesChart');
    new Chart(salesCtx, {
        type: 'line',
        data: {
            labels: months,
            datasets: [{
                label: 'Total Penjualan (Rp)',
                data: salesData,
                fill: false,
                borderColor: 'rgba(0, 123, 255, 1)',
                backgroundColor: 'rgba(0, 123, 255, 0.1)',
                tension: 0.4,
                pointBackgroundColor: 'rgba(0, 123, 255, 1)',
                pointRadius: 4,
                pointHoverRadius: 6,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + (value / 1000000) + 'M';
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
    
    // Order Status Chart - Example data (replace with actual data from backend)
    const orderLabels = ['Pending', 'Processing', 'Completed', 'Cancelled'];
    const orderData = [12, 19, 45, 5];
    const orderColors = ['#ffc107', '#0dcaf0', '#198754', '#dc3545'];
    
    // Setup order status chart
    const orderCtx = document.getElementById('orderStatusChart');
    new Chart(orderCtx, {
        type: 'pie',
        data: {
            labels: orderLabels,
            datasets: [{
                data: orderData,
                backgroundColor: orderColors,
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right'
                }
            }
        }
    });
</script>
@endsection