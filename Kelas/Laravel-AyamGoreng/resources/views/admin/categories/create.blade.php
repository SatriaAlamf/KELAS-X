@extends('admin.layouts.admin')

@section('title', 'Tambah Kategori')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Tambah Kategori</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">Kategori</a></li>
        <li class="breadcrumb-item active">Tambah</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-plus me-1"></i>
            Form Tambah Kategori
        </div>
        <div class="card-body">
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Kategori <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" {{ old('is_active') ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">Aktif</label>
                </div>
                
                <div class="d-flex justify-content-end">
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection