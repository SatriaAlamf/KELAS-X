@extends('admin.layouts.admin')

@section('title', 'Produk')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mt-4">Produk</h1>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Tambah Produk
        </a>
    </div>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Produk</li>
    </ol>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Daftar Produk
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="productsTable">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="10%">Gambar</th>
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Status</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $index => $product)
                        <tr>
                            <td>{{ $index + $products->firstItem() }}</td>
                            <td>
                                @if($product->image)
                                <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="img-thumbnail" style="max-height: 50px;">
                                @else
                                <span class="badge bg-secondary">No Image</span>
                                @endif
                            </td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->category->name }}</td>
                            <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge bg-{{ $product->stock <= 5 ? 'danger' : ($product->stock <= 10 ? 'warning' : 'success') }}">
                                    {{ $product->stock }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $product->is_active ? 'success' : 'danger' }}">
                                    {{ $product->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                                @if($product->is_featured)
                                <span class="badge bg-info ms-1">Featured</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex">
                                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-primary me-1">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">Tidak ada data produk</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-end mt-3">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('.delete-form').on('submit', function(e) {
            e.preventDefault();
            
            Swal.fire({
                title: 'Anda yakin?',
                text: "Produk yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
    });
</script>
@endpush