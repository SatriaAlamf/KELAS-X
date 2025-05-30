<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crispy Chicken - @yield('title', 'Home')</title>
    <!-- Bootstrap CSS -->
    <link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ asset('fontawesome/css/all.min.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <!-- AOS Animation CSS -->
    <link href="{{ asset('aos/aos.css') }}" rel="stylesheet">
    <!-- Custom Favicon -->
    <link rel="icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">
    @yield('styles')
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                <img src="{{ asset('images/logo.png') }}" alt="Crispy Chicken Logo" class="logo-img me-2">
                <span class="brand-text">Crispy Chicken</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" 
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                            <i class="fas fa-home"></i> Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('products*') ? 'active' : '' }}" href="{{ route('products.index') }}">
                            <i class="fas fa-drumstick-bite"></i> Menu
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">
                            <i class="fas fa-envelope"></i> Contact
                        </a>
                    </li>
                    
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt"></i> Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">
                                <i class="fas fa-user-plus"></i> Register
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('cart.index') ? 'active' : '' }}" href="{{ route('cart.index') }}">
                                <i class="fas fa-shopping-cart"></i> Cart
                                <span class="cart-count" id="cartCount">0</span>
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" 
                               data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user-circle"></i> {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end animate slideIn" aria-labelledby="navbarDropdown">
                                <li>
                                    <a class="dropdown-item" href="{{ route('profile.index') }}">
                                        <i class="fas fa-user"></i> My Profile
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('orders.index') }}">
                                        <i class="fas fa-clipboard-list"></i> My Orders
                                    </a>
                                </li>
                                @if(Auth::user()->isAdmin())
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                        <i class="fas fa-tachometer-alt"></i> Admin Dashboard
                                    </a>
                                </li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt"></i> Logout
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer mt-5">
        <div class="container py-5">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <div class="footer-logo d-flex align-items-center mb-3">
                        <img src="{{ asset('images/logo.png') }}" alt="Crispy Chicken Logo" class="footer-logo-img me-2">
                        <h5 class="m-0">Crispy Chicken</h5>
                    </div>
                    <p>Serving the most delicious and crispy chicken since 2010. Our mission is to provide high-quality food with excellent service.</p>
                    <div class="social-links mt-3">
                        <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-tiktok"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h6 class="footer-heading">Quick Links</h6>
                    <ul class="footer-links">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ route('products.index') }}">Menu</a></li>
                        <li><a href="{{ route('contact') }}">Contact</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <h6 class="footer-heading">Opening Hours</h6>
                    <ul class="footer-links opening-hours">
                        <li>Monday - Friday: 10:00 - 22:00</li>
                        <li>Saturday: 10:00 - 23:00</li>
                        <li>Sunday: 12:00 - 22:00</li>
                    </ul>
                </div>
                <div class="col-lg-3 mb-4">
                    <h6 class="footer-heading">Contact Us</h6>
                    <ul class="footer-links contact-info">
                        <li><i class="fas fa-map-marker-alt"></i> 123 Chicken Street, Food City</li>
                        <li><i class="fas fa-phone"></i> +1234 5678 900</li>
                        <li><i class="fas fa-envelope"></i> info@crispychicken.com</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="copyright">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <p>&copy; {{ date('Y') }} Crispy Chicken. All Rights Reserved.</p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <p>Designed with <i class="fas fa-heart text-danger"></i> by Crispy Team</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- jQuery -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <!-- AOS Animation JS -->
    <script src="{{ asset('aos/aos.js') }}"></script>
    <!-- Custom JS -->
    <script src="{{ asset('js/script.js') }}"></script>
    
    <script>
        // Initialize AOS animations
        AOS.init({
            duration: 800,
            easing: 'ease-in-out'
        });
        
        // Change navbar background on scroll
        $(window).scroll(function() {
            if ($(this).scrollTop() > 50) {
                $('#mainNav').addClass('navbar-scrolled');
            } else {
                $('#mainNav').removeClass('navbar-scrolled');
            }
        });
        
        // Update cart count (this would be updated with AJAX in a real app)
        function updateCartCount() {
            // This would typically be an AJAX call to get the actual cart count
            // For now, just a placeholder
            $.get('/cart/count', function(data) {
                $('#cartCount').text(data.count);
            }).fail(function() {
                console.log('Error fetching cart count');
            });
        }
        
        $(document).ready(function() {
            // Initial cart count update
            // updateCartCount();
            
            // For demo purposes, set a random number
            $('#cartCount').text(Math.floor(Math.random() * 5));
        });
    </script>
    
    @yield('scripts')
</body>
</html>