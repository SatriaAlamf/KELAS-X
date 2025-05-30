@extends('admin.layouts.admin')

@section('title', 'Kategori')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mt-4">Kategori</h1>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Tambah Kategori
        </a>
    </div>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Kategori</li>
    </ol>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Daftar Kategori
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="categoriesTable">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama</th>
                            <th>Slug</th>
                            <th>Deskripsi</th>
                            <th>Status</th>
                            <th>Tanggal Dibuat</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $index => $category)
                        <tr>
                            <td>{{ $index + $categories->firstItem() }}</td>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->slug }}</td>
                            <td>{{ Str::limit($category->description, 50) }}</td>
                            <td>
                                <span class="badge bg-{{ $category->is_active ? 'success' : 'danger' }}">
                                    {{ $category->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </td>
                            <td><td>
                                {{ $category->created_at ? $category->created_at->format('d M Y, H:i') : '-' }}
                              </td>
                              
                            <td>
                                <div class="d-flex">
                                    <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-sm btn-primary me-1">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="delete-form">
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
                            <td colspan="7" class="text-center">Tidak ada data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-end mt-3">
                {{ $categories->links() }}
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
                text: "Kategori yang dihapus tidak dapat dikembalikan!",
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