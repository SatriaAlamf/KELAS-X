@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <!-- Hero Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-dark text-white">
                <div class="card-body p-5" style="background: linear-gradient(to right, #FFD700, #FFA500);">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h1 class="display-4 fw-bold text-dark">Our Menu</h1>
                            <p class="lead text-dark">Discover our delicious products made with the finest ingredients</p>
                        </div>
                        <div class="col-md-4 text-end">
                            <img src="{{ asset('images/menu-hero.png') }}" alt="Menu" class="img-fluid rounded" style="max-height: 200px;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="row mb-4">
        <div class="col-md-8">
            <form action="{{ route('products.index') }}" method="GET" class="d-flex">
                <input type="text" name="search" class="form-control me-2" placeholder="Search products..." value="{{ request()->search }}">
                <button type="submit" class="btn btn-dark">Search</button>
            </form>
        </div>
        <div class="col-md-4">
            <div class="dropdown">
                <button class="btn btn-outline-dark dropdown-toggle w-100" type="button" id="categoryDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    {{ request()->has('category') ? $categories->where('id', request()->category)->first()->name : 'All Categories' }}
                </button>
                <ul class="dropdown-menu w-100" aria-labelledby="categoryDropdown">
                    <li><a class="dropdown-item" href="{{ route('products.index') }}">All Categories</a></li>
                    @foreach($categories as $category)
                    <li><a class="dropdown-item" href="{{ route('products.index', ['category' => $category->id]) }}">{{ $category->name }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="row">
        @forelse($products as $product)
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="position-relative">
                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                    @if($product->is_new)
                    <span class="position-absolute top-0 end-0 badge" style="background-color: #FFA500;">New</span>
                    @endif
                    @if($product->is_featured)
                    <span class="position-absolute top-0 start-0 badge bg-dark">Featured</span>
                    @endif
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text text-muted">{{ Str::limit($product->description, 100) }}</p>
                </div>
                <div class="card-footer bg-white d-flex justify-content-between align-items-center" style="border-top: none;">
                    <span class="fw-bold" style="color: #FFA500;">${{ number_format($product->price, 2) }}</span>
                    <a href="{{ route('products.show', $product->slug) }}" class="btn btn-sm btn-dark">View Details</a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <div class="py-5">
                <i class="bi bi-search" style="font-size: 3rem; color: #FFA500;"></i>
                <h3 class="mt-3">No products found</h3>
                <p class="text-muted">Try adjusting your search or filter to find what you're looking for.</p>
                <a href="{{ route('products.index') }}" class="btn btn-outline-dark mt-3">Clear Filters</a>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="row mt-4">
        <div class="col-12 d-flex justify-content-center">
            {{ $products->links() }}
        </div>
    </div>

    <!-- Featured Categories Section -->
    <div class="row mt-5">
        <div class="col-12">
            <h2 class="border-start border-5 ps-3 mb-4" style="border-color: #FFA500 !important;">Browse by Category</h2>
        </div>
        @foreach($categories->take(4) as $category)
        <div class="col-md-3 mb-4">
            <a href="{{ route('products.index', ['category' => $category->id]) }}" class="text-decoration-none">
                <div class="card bg-dark text-white h-100">
                    <div class="card-body text-center" style="background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('{{ asset($category->image ?? 'images/default-category.jpg') }}'); background-size: cover; background-position: center; height: 150px; display: flex; align-items: center; justify-content: center;">
                        <h4>{{ $category->name }}</h4>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>
@endsection

@section('styles')
<style>
    .pagination {
        --bs-pagination-active-bg: #FFA500;
        --bs-pagination-active-border-color: #FFA500;
    }
    .btn-dark:hover {
        background-color: #FFA500;
        border-color: #FFA500;
    }
    .card:hover {
        transform: translateY(-5px);
        transition: transform 0.3s ease;
    }
    .dropdown-item:hover {
        background-color: #FFA500;
        color: white;
    }
</style>
@endsection