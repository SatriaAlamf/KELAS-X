@extends('layouts.app')

@section('title', 'Crispy Chicken - Delicious Fried Chicken')

@section('styles')
<style>
    /* Custom styles for home page */
    .hero-section {
        background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('{{ asset("images/hero-bg.jpg") }}');
        background-size: cover;
        background-position: center;
        color: white;
        padding: 150px 0;
        position: relative;
        overflow: hidden;
    }
    
    .hero-content {
        position: relative;
        z-index: 2;
    }
    
    .hero-title {
        font-size: 3.5rem;
        font-weight: 700;
        margin-bottom: 20px;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    }
    
    .hero-subtitle {
        font-size: 1.5rem;
        margin-bottom: 30px;
        text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
    }
    
    .hero-btn {
        padding: 12px 30px;
        font-weight: 600;
        text-transform: uppercase;
        transition: all 0.3s ease;
        border-radius: 50px;
    }
    
    .hero-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }
    
    .featured-card {
        border-radius: 15px;
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    
    .featured-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
    }
    
    .featured-img {
        height: 200px;
        object-fit: cover;
    }
    
    .category-card {
        position: relative;
        border-radius: 15px;
        overflow: hidden;
        height: 200px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    
    .category-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: all 0.5s ease;
    }
    
    .category-card:hover .category-img {
        transform: scale(1.1);
    }
    
    .category-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.7));
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: white;
        padding: 20px;
    }
    
    .about-image {
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }
    
    .testimonial-card {
        background: #fff;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        position: relative;
    }
    
    .testimonial-card::before {
        content: '\201C';
        font-size: 80px;
        position: absolute;
        top: -10px;
        left: 20px;
        color: rgba(0, 0, 0, 0.1);
        font-family: serif;
    }
    
    .customer-img {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #f8c146;
    }
    
    .stats-section {
        background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('{{ asset("images/stats-bg.jpg") }}');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        color: white;
        padding: 80px 0;
    }
    
    .stat-item h2 {
        font-size: 3rem;
        font-weight: 700;
        margin-bottom: 15px;
    }
    
    .counter {
        display: inline-block;
    }
    
    .cta-section {
        background: linear-gradient(90deg, #ff7e00, #ff9a56);
        border-radius: 15px;
        padding: 60px 40px;
        color: white;
        box-shadow: 0 10px 30px rgba(255, 126, 0, 0.3);
    }
    
    /* Floating chicken animation */
    .floating-chicken {
        position: absolute;
        width: 150px;
        height: 150px;
        animation: float 6s ease-in-out infinite;
        z-index: 1;
    }
    
    .fc-1 {
        top: 10%;
        right: 10%;
        animation-delay: 0s;
    }
    
    .fc-2 {
        bottom: 10%;
        left: 5%;
        animation-delay: 1s;
    }
    
    .fc-3 {
        top: 20%;
        left: 15%;
        animation-delay: 2s;
        width: 100px;
        height: 100px;
    }
    
    @keyframes float {
        0% {
            transform: translateY(0px) rotate(0deg);
        }
        50% {
            transform: translateY(-20px) rotate(5deg);
        }
        100% {
            transform: translateY(0px) rotate(0deg);
        }
    }
    
    /* Section titles */
    .section-title {
        position: relative;
        padding-bottom: 15px;
        margin-bottom: 30px;
    }
    
    .section-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 3px;
        background: #ff7e00;
    }
    
    /* Mobile responsiveness */
    @media (max-width: 768px) {
        .hero-title {
            font-size: 2.5rem;
        }
        
        .hero-subtitle {
            font-size: 1.2rem;
        }
        
        .floating-chicken {
            width: 100px;
            height: 100px;
        }
        
        .fc-3 {
            width: 70px;
            height: 70px;
        }
    }
</style>
@endsection

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container hero-content">
        <div class="row align-items-center">
            <div class="col-lg-6" data-aos="fade-right">
                <h1 class="hero-title">Crispy and Delicious Fried Chicken</h1>
                <p class="hero-subtitle">Experience the most delicious and crispy chicken in town with our secret recipe.</p>
                <div class="d-flex gap-3">
                    <a href="{{ route('products.index') }}" class="btn btn-warning hero-btn">
                        <i class="fas fa-drumstick-bite me-2"></i>View Menu
                    </a>
                    <a href="{{ route('contact') }}" class="btn btn-outline-light hero-btn">
                        <i class="fas fa-map-marker-alt me-2"></i>Find Us
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Floating chicken elements -->
    <img src="{{ asset('images/chicken-piece-1.png') }}" alt="Chicken" class="floating-chicken fc-1">
    <img src="{{ asset('images/chicken-piece-2.png') }}" alt="Chicken" class="floating-chicken fc-2">
    <img src="{{ asset('images/chicken-piece-3.png') }}" alt="Chicken" class="floating-chicken fc-3">
</section>

<!-- Featured Products Section -->
<section class="py-5">
    <div class="container">
        <h2 class="text-center section-title" data-aos="fade-up">Featured Menu</h2>
        <div class="row">
            @foreach($featuredProducts as $product)
            <div class="col-md-3 mb-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <div class="card featured-card h-100">
                    <img src="{{ asset('images/products/'.$product->image) }}" alt="{{ $product->name }}" class="card-img-top featured-img">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text text-truncate">{{ $product->description }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold text-danger">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            <a href="{{ route('products.show', $product->slug) }}" class="btn btn-sm btn-outline-warning">
                                <i class="fas fa-eye me-1"></i>View
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-4" data-aos="fade-up">
            <a href="{{ route('products.index') }}" class="btn btn-outline-warning">
                <i class="fas fa-utensils me-2"></i>View All Menu
            </a>
        </div>
    </div>
</section>

<!-- Categories Section -->

<!-- About Us Section -->
<section class="py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0" data-aos="fade-right">
                <div class="about-image">
                    <img src="{{ asset('images/about-us.jpg') }}" alt="About Crispy Chicken" class="img-fluid rounded">
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <h2 class="section-title text-start">Our Story</h2>
                <p class="mb-4">Founded in 2010, Crispy Chicken has been serving the most delicious and crispy chicken in town. Our secret recipe has been passed down through generations, bringing the authentic taste of perfectly fried chicken to our customers.</p>
                <p class="mb-4">We take pride in using only the freshest ingredients and high-quality chicken. Every piece is carefully prepared and fried to perfection to ensure that satisfying crunch with every bite.</p>
                <div class="row mt-4">
                    <div class="col-md-6 mb-3">
                        <div class="d-flex align-items-center">
                            <div class="me-3 text-warning">
                                <i class="fas fa-check-circle fa-2x"></i>
                            </div>
                            <div>
                                <h5 class="mb-1">Quality Ingredients</h5>
                                <p class="mb-0 text-muted small">We use only the freshest ingredients</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="d-flex align-items-center">
                            <div class="me-3 text-warning">
                                <i class="fas fa-fire fa-2x"></i>
                            </div>
                            <div>
                                <h5 class="mb-1">Secret Recipe</h5>
                                <p class="mb-0 text-muted small">Unique blend of herbs and spices</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="d-flex align-items-center">
                            <div class="me-3 text-warning">
                                <i class="fas fa-shipping-fast fa-2x"></i>
                            </div>
                            <div>
                                <h5 class="mb-1">Fast Delivery</h5>
                                <p class="mb-0 text-muted small">Hot and fresh to your doorstep</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="d-flex align-items-center">
                            <div class="me-3 text-warning">
                                <i class="fas fa-smile fa-2x"></i>
                            </div>
                            <div>
                                <h5 class="mb-1">Customer Satisfaction</h5>
                                <p class="mb-0 text-muted small">Your happiness is our priority</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="stats-section">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-3 mb-4 mb-md-0" data-aos="fade-up">
                <div class="stat-item">
                    <i class="fas fa-drumstick-bite fa-3x mb-3"></i>
                    <h2><span class="counter">500</span>K+</h2>
                    <p>Chickens Served</p>
                </div>
            </div>
            <div class="col-md-3 mb-4 mb-md-0" data-aos="fade-up" data-aos-delay="100">
                <div class="stat-item">
                    <i class="fas fa-users fa-3x mb-3"></i>
                    <h2><span class="counter">100</span>K+</h2>
                    <p>Happy Customers</p>
                </div>
            </div>
            <div class="col-md-3 mb-4 mb-md-0" data-aos="fade-up" data-aos-delay="200">
                <div class="stat-item">
                    <i class="fas fa-store fa-3x mb-3"></i>
                    <h2><span class="counter">15</span>+</h2>
                    <p>Branches</p>
                </div>
            </div>
            <div class="col-md-3" data-aos="fade-up" data-aos-delay="300">
                <div class="stat-item">
                    <i class="fas fa-award fa-3x mb-3"></i>
                    <h2><span class="counter">10</span>+</h2>
                    <p>Awards Won</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="py-5">
    <div class="container">
        <h2 class="text-center section-title" data-aos="fade-up">What Our Customers Say</h2>
        <div class="row">
            <div class="col-md-4 mb-4" data-aos="fade-up">
                <div class="testimonial-card h-100">
                    <div class="mb-4">
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                    </div>
                    <p class="mb-4">"The chicken is incredibly crispy on the outside and juicy on the inside. Definitely the best fried chicken I've ever had! The service is also excellent."</p>
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('images/customer-1.jpg') }}" alt="Customer" class="customer-img me-3">
                        <div>
                            <h6 class="mb-0">Sarah Johnson</h6>
                            <p class="text-muted small mb-0">Regular Customer</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="testimonial-card h-100">
                    <div class="mb-4">
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                    </div>
                    <p class="mb-4">"I order from Crispy Chicken at least once a week. Their chicken is consistently delicious, and the delivery is always on time. My family's favorite!"</p>
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('images/customer-2.jpg') }}" alt="Customer" class="customer-img me-3">
                        <div>
                            <h6 class="mb-0">Michael Brown</h6>
                            <p class="text-muted small mb-0">Foodie</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="testimonial-card h-100">
                    <div class="mb-4">
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star-half-alt text-warning"></i>
                    </div>
                    <p class="mb-4">"The spicy chicken is my favorite! It has the perfect level of heat that doesn't overpower the flavor. Their sides are also amazing, especially the mashed potatoes."</p>
<div class="d-flex align-items-center">
    <img src="{{ asset('images/customer-3.jpg') }}" alt="Customer" class="customer-img me-3">
    <div>
        <h6 class="mb-0">Jessica Lee</h6>
        <p class="text-muted small mb-0">Food Blogger</p>
    </div>
</div>
</div>
</div>
</div>
</div>
</section>

<!-- Call to Action Section -->
<section class="py-5">
<div class="container" data-aos="fade-up">
<div class="cta-section">
<div class="row align-items-center">
<div class="col-lg-8 mb-4 mb-lg-0">
<h2 class="mb-3">Ready to taste the best chicken in town?</h2>
<p class="mb-0">Order now and get 10% off on your first order. Use code: CRISPY10</p>
</div>
<div class="col-lg-4 text-lg-end">
<a href="{{ route('products.index') }}" class="btn btn-light btn-lg hero-btn">
    <i class="fas fa-shopping-cart me-2"></i>Order Now
</a>
</div>
</div>
</div>
</div>
</section>

<!-- Special Offers Section -->
<section class="py-5 bg-light">
<div class="container">
<h2 class="text-center section-title" data-aos="fade-up">Special Offers</h2>
<div class="row">
<div class="col-md-6 mb-4" data-aos="fade-right">
<div class="card border-0 shadow-sm overflow-hidden">
<div class="row g-0">
    <div class="col-5">
        <img src="{{ asset('images/special-offer-1.jpg') }}" alt="Family Bucket" class="img-fluid h-100 w-100 object-fit-cover">
    </div>
    <div class="col-7">
        <div class="card-body">
            <div class="badge bg-danger mb-2">LIMITED TIME</div>
            <h4 class="card-title">Family Bucket Special</h4>
            <p class="card-text">Get our signature family bucket with 10 pieces of chicken, 4 sides, and 4 drinks.</p>
            <div class="d-flex align-items-center mb-3">
                <span class="text-decoration-line-through text-muted me-2">Rp 250.000</span>
                <span class="fs-4 fw-bold text-danger">Rp 199.000</span>
            </div>
            <a href="{{ route('products.index') }}" class="btn btn-warning btn-sm">Order Now</a>
        </div>
    </div>
</div>
</div>
</div>
<div class="col-md-6 mb-4" data-aos="fade-left">
<div class="card border-0 shadow-sm overflow-hidden">
<div class="row g-0">
    <div class="col-5">
        <img src="{{ asset('images/special-offer-2.jpg') }}" alt="Combo Meal" class="img-fluid h-100 w-100 object-fit-cover">
    </div>
    <div class="col-7">
        <div class="card-body">
            <div class="badge bg-primary mb-2">WEEKDAY SPECIAL</div>
            <h4 class="card-title">Combo Meal Deal</h4>
            <p class="card-text">2 pieces of crispy chicken, regular fries, coleslaw, and a drink of your choice.</p>
            <div class="d-flex align-items-center mb-3">
                <span class="text-decoration-line-through text-muted me-2">Rp 75.000</span>
                <span class="fs-4 fw-bold text-danger">Rp 59.000</span>
            </div>
            <a href="{{ route('products.index') }}" class="btn btn-warning btn-sm">Order Now</a>
        </div>
    </div>
</div>
</div>
</div>
</div>
</div>
</section>

<!-- Instagram Feed Section -->
<section class="py-5">
<div class="container">
<h2 class="text-center section-title" data-aos="fade-up">Follow Us on Instagram</h2>
<p class="text-center mb-4" data-aos="fade-up">Share your Crispy Chicken moments with us using #CrispyChickenLovers</p>
<div class="row g-3">
@for ($i = 1; $i <= 6; $i++)
<div class="col-6 col-md-4 col-lg-2" data-aos="zoom-in" data-aos-delay="{{ ($i-1) * 100 }}">
<a href="#" class="instagram-item d-block position-relative">
<img src="{{ asset('images/insta-'.$i.'.jpg') }}" alt="Instagram Post" class="img-fluid rounded">
<div class="instagram-overlay rounded position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center">
    <i class="fab fa-instagram text-white fa-2x"></i>
</div>
</a>
</div>
@endfor
</div>
</div>
</section>

<!-- Location Map Section -->
<section class="py-5 bg-light">
<div class="container">
<h2 class="text-center section-title" data-aos="fade-up">Find Us</h2>
<div class="row">
<div class="col-lg-6 mb-4 mb-lg-0" data-aos="fade-right">
<div class="card h-100 border-0 shadow-sm">
<div class="card-header bg-white border-0 pt-4">
    <h5 class="mb-0"><i class="fas fa-map-marker-alt text-danger me-2"></i>Our Main Location</h5>
</div>
<div class="card-body">
    <div class="ratio ratio-16x9 mb-3">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15830.440538022!2d106.82296605!3d-6.175392649999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f5d2e764b12d%3A0x3d2ad6e1e0e9bcc8!2sMonumen%20Nasional!5e0!3m2!1sen!2sid!4v1628303999096!5m2!1sen!2sid" class="border-0 w-100" allowfullscreen="" loading="lazy"></iframe>
    </div>
    <ul class="list-unstyled mb-0">
        <li class="d-flex mb-3">
            <i class="fas fa-map-marker-alt text-danger me-3 mt-1"></i>
            <div>
                <h6 class="mb-1">Address</h6>
                <p class="mb-0 text-muted">123 Chicken Street, Food City, Jakarta</p>
            </div>
        </li>
        <li class="d-flex mb-3">
            <i class="fas fa-clock text-danger me-3 mt-1"></i>
            <div>
                <h6 class="mb-1">Opening Hours</h6>
                <p class="mb-0 text-muted">10:00 AM - 10:00 PM (Mon-Sun)</p>
            </div>
        </li>
        <li class="d-flex">
            <i class="fas fa-phone text-danger me-3 mt-1"></i>
            <div>
                <h6 class="mb-1">Phone</h6>
                <p class="mb-0 text-muted">+62 123 4567 890</p>
            </div>
        </li>
    </ul>
</div>
</div>
</div>
<div class="col-lg-6" data-aos="fade-left">
<div class="card h-100 border-0 shadow-sm">
<div class="card-header bg-white border-0 pt-4">
    <h5 class="mb-0"><i class="fas fa-envelope text-danger me-2"></i>Send Us a Message</h5>
</div>
<div class="card-body">
    <form action="{{ route('contact.send') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="name" class="form-label">Your Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
        </div>
        <div class="mb-3">
            <label for="subject" class="form-label">Subject</label>
            <input type="text" class="form-control" id="subject" name="subject" required>
        </div>
        <div class="mb-3">
            <label for="message" class="form-label">Message</label>
            <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
        </div>
        <button type="submit" class="btn btn-warning">
            <i class="fas fa-paper-plane me-2"></i>Send Message
        </button>
    </form>
</div>
</div>
</div>
</div>
</div>
</section>

<!-- Newsletter Section -->
<section class="py-5">
<div class="container">
<div class="card border-0 shadow-sm p-4 p-md-5 bg-warning bg-opacity-10" data-aos="fade-up">
<div class="row align-items-center">
<div class="col-lg-6 mb-4 mb-lg-0">
<h3 class="mb-3">Subscribe to Our Newsletter</h3>
<p class="mb-0">Stay updated with our latest offers, promotions, and new menu items. Subscribe now and get a 15% discount coupon for your next order.</p>
</div>
<div class="col-lg-6">
<form class="d-flex">
    <input type="email" class="form-control me-2" placeholder="Enter your email address" required>
    <button type="submit" class="btn btn-warning">Subscribe</button>
</form>
</div>
</div>
</div>
</div>
</section>
@endsection

@section('scripts')
<script>
// Counter animation for stats section
const counterAnimation = () => {
const counters = document.querySelectorAll('.counter');

counters.forEach(counter => {
const updateCount = () => {
const target = +counter.getAttribute('data-target') || +counter.innerText;
const count = +counter.innerText;
const increment = target / 200;

if (count < target) {
counter.innerText = Math.ceil(count + increment);
setTimeout(updateCount, 10);
} else {
counter.innerText = target;
}
};

// Set data-target attribute if not already set
if (!counter.getAttribute('data-target')) {
counter.setAttribute('data-target', counter.innerText);
}

observer = new IntersectionObserver((entries) => {
entries.forEach(entry => {
if (entry.isIntersecting) {
    updateCount();
    observer.unobserve(entry.target);
}
});
}, { threshold: 0.5 });

observer.observe(counter);
});
};

// Initialize counter animation when page loads
$(document).ready(function() {
counterAnimation();

// Additional animation for featured products
$('.featured-card').hover(
function() {
$(this).find('.card-img-top').css('transform', 'scale(1.1)');
},
function() {
$(this).find('.card-img-top').css('transform', 'scale(1)');
}
);

// Instagram hover effect
$('.instagram-item').hover(
function() {
$(this).find('.instagram-overlay').css('opacity', '1');
},
function() {
$(this).find('.instagram-overlay').css('opacity', '0');
}
);
});
</script>
@endsection