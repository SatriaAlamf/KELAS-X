@extends('admin.layouts.admin')

@section('title', 'Tambah Produk')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Tambah Produk</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Produk</a></li>
        <li class="breadcrumb-item active">Tambah</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-plus me-1"></i>
            Form Tambah Produk
        </div>
        <div class="card-body">
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Nama Produk <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label for="category_id" class="form-label">Kategori <span class="text-danger">*</span></label>
                        <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="price" class="form-label">Harga <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price') }}" min="0" step="1000" required>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <label for="stock" class="form-label">Stok <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('stock') is-invalid @enderror" id="stock" name="stock" value="{{ old('stock') }}" min="0" required>
                        @error('stock')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="image" class="form-label">Gambar Produk</label>
                    <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                    <div class="form-text">Format: JPG, JPEG, PNG, GIF. Maks: 2MB</div>
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    
                    <div class="mt-2" id="imagePreview" style="display: none;">
                        <img src="" alt="Preview" class="img-thumbnail" style="max-height: 200px;">
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_featured">Jadikan Featured</label>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">Aktif</label>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-end">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Image preview
        $('#image').change(function() {
            const file = this.files[0];
            if (file) {
                let reader = new FileReader();
                reader.onload = function(event) {
                    $('#imagePreview img').attr('src', event.target.result);
                    $('#imagePreview').show();
                }
                reader.readAsDataURL(file);
            } else {
                $('#imagePreview').hide();
            }
        });
        
        // WYSIWYG editor for description
        if (typeof(CKEDITOR) !== 'undefined') {
            CKEDITOR.replace('description');
        }
    });
</script>
@endpush