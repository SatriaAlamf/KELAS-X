@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none text-dark">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}" class="text-decoration-none text-dark">Menu</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
        </ol>
    </nav>

    <!-- Product Details -->
    <div class="card border-0 shadow-sm mb-5">
        <div class="row g-0">
            <div class="col-md-5">
                <div class="position-relative h-100">
                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="img-fluid rounded-start h-100 w-100" style="object-fit: cover;">
                    @if($product->discount > 0)
                    <div class="position-absolute top-0 start-0 bg-dark text-white px-3 py-2 m-3 rounded">
                        {{ $product->discount }}% OFF
                    </div>
                    @endif
                </div>
            </div>
            <div class="col-md-7">
                <div class="card-body p-4 p-md-5">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h1 class="card-title fw-bold">{{ $product->name }}</h1>
                        <span class="badge" style="background-color: #FFA500;">{{ $product->category->name }}</span>
                    </div>
                    
                    <div class="mb-4 d-flex align-items-center">
                        @if($product->old_price)
                        <h3 class="text-muted me-2"><s>${{ number_format($product->old_price, 2) }}</s></h3>
                        @endif
                        <h3 class="fw-bold" style="color: #FFA500;">${{ number_format($product->price, 2) }}</h3>
                    </div>

                    <div class="mb-4">
                        <p class="card-text fs-5">{{ $product->description }}</p>
                    </div>

                    <div class="mb-4">
                        @if($product->stock > 0)
                        <span class="badge bg-success mb-3">In Stock ({{ $product->stock }} remaining)</span>
                        @else
                        <span class="badge bg-danger mb-3">Out of Stock</span>
                        @endif

                        @if($product->ingredients)
                        <div class="mt-3">
                            <h5 class="border-start border-3 ps-2 mb-3" style="border-color: #FFA500 !important;">Ingredients</h5>
                            <p>{{ $product->ingredients }}</p>
                        </div>
                        @endif

                        @if($product->nutritional_info)
                        <div class="mt-3">
                            <h5 class="border-start border-3 ps-2 mb-3" style="border-color: #FFA500 !important;">Nutritional Information</h5>
                            <p>{{ $product->nutritional_info }}</p>
                        </div>
                        @endif
                    </div>

                    <div class="mt-4">
                        @if($product->stock > 0)
                        <form action="{{ route('cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <div class="row g-2">
                                <div class="col-md-3">
                                    <div class="input-group">
                                        <button type="button" class="btn btn-outline-dark quantity-btn" data-action="decrease">-</button>
                                        <input type="number" name="quantity" class="form-control text-center" value="1" min="1" max="{{ $product->stock }}">
                                        <button type="button" class="btn btn-outline-dark quantity-btn" data-action="increase">+</button>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <button type="submit" class="btn btn-dark w-100">
                                        <i class="bi bi-cart-plus me-2"></i> Add to Cart
                                    </button>
                                </div>
                            </div>
                        </form>
                        @else
                        <button class="btn btn-secondary w-100" disabled>Out of Stock</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
    <div class="row mt-5">
        <div class="col-12">
            <h2 class="border-start border-5 ps-3 mb-4" style="border-color: #FFA500 !important;">You May Also Like</h2>
        </div>
        
        @foreach($relatedProducts as $relatedProduct)
        <div class="col-md-3 mb-4">
            <div class="card h-100 shadow-sm border-0">
                <img src="{{ asset($relatedProduct->image) }}" alt="{{ $relatedProduct->name }}" class="card-img-top" style="height: 180px; object-fit: cover;">
                <div class="card-body">
                    <h5 class="card-title">{{ $relatedProduct->name }}</h5>
                    <p class="card-text text-muted">{{ Str::limit($relatedProduct->description, 60) }}</p>
                </div>
                <div class="card-footer bg-white d-flex justify-content-between align-items-center" style="border-top: none;">
                    <span class="fw-bold" style="color: #FFA500;">${{ number_format($relatedProduct->price, 2) }}</span>
                    <a href="{{ route('products.show', $relatedProduct->slug) }}" class="btn btn-sm btn-outline-dark">View</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const quantityInput = document.querySelector('input[name="quantity"]');
        const quantityBtns = document.querySelectorAll('.quantity-btn');
        
        quantityBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                let currentValue = parseInt(quantityInput.value);
                let maxValue = parseInt(quantityInput.getAttribute('max'));
                
                if (this.dataset.action === 'increase' && currentValue < maxValue) {
                    quantityInput.value = currentValue + 1;
                } else if (this.dataset.action === 'decrease' && currentValue > 1) {
                    quantityInput.value = currentValue - 1;
                }
            });
        });
    });
</script>
@endsection

@section('styles')
<style>
    .btn-dark:hover {
        background-color: #FFA500;
        border-color: #FFA500;
    }
    .btn-outline-dark:hover {
        background-color: #FFA500;
        border-color: #FFA500;
        color: white;
    }
    .card:hover {
        transform: translateY(-5px);
        transition: transform 0.3s ease;
    }
</style>
@endsection