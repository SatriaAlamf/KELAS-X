<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Admin Dashboard">
    <meta name="author" content="Admin">
    <title>@yield('title') - Admin Panel</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom styles -->
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    
    <!-- Additional CSS -->
    @yield('styles')
</head>
<body class="sb-nav-fixed">
    <!-- Top Navigation -->
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand -->
        <a class="navbar-brand ps-3" href="{{ route('admin.dashboard') }}">Admin Panel</a>
        
        <!-- Sidebar Toggle -->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!">
            <i class="fas fa-bars"></i>
        </button>
        
        <!-- Navbar Search -->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <div class="input-group">
                <input class="form-control" type="text" placeholder="Search for..." aria-label="Search" aria-describedby="btnNavbarSearch">
                <button class="btn btn-primary" id="btnNavbarSearch" type="button">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>
        
        <!-- Navbar User Menu -->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-user fa-fw"></i> {{ Auth::user()->name }}
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#!">
                        <i class="fas fa-user-circle me-1"></i> Profile
                    </a></li>
                    <li><a class="dropdown-item" href="#!">
                        <i class="fas fa-cog me-1"></i> Settings
                    </a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="fas fa-sign-out-alt me-1"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
    
    <div id="layoutSidenav">
        <!-- Sidebar Navigation -->
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Core</div>
                        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        
                        <div class="sb-sidenav-menu-heading">Product Management</div>
                        <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-list"></i></div>
                            Categories
                        </a>
                        <a class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-box"></i></div>
                            Products
                        </a>
                        
                        <div class="sb-sidenav-menu-heading">Order Management</div>
                        <a class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-shopping-cart"></i></div>
                            Orders
                        </a>
                        
                        <div class="sb-sidenav-menu-heading">User Management</div>
                        <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                            Users
                        </a>
                        
                        <div class="sb-sidenav-menu-heading">Reports</div>
                        <a class="nav-link" href="#!">
                            <div class="sb-nav-link-icon"><i class="fas fa-chart-bar"></i></div>
                            Sales Report
                        </a>
                        <a class="nav-link" href="#!">
                            <div class="sb-nav-link-icon"><i class="fas fa-chart-line"></i></div>
                            Product Performance
                        </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    {{ Auth::user()->name }} ({{ ucfirst(Auth::user()->role) }})
                </div>
            </nav>
        </div>
        
        <!-- Page Content -->
        <div id="layoutSidenav_content">
            <main>
                @yield('content')
            </main>
            
            <!-- Footer -->
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Your Website {{ date('Y') }}</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    
    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Core Admin JS -->
    <script>
        // Sidebar toggle functionality
        window.addEventListener('DOMContentLoaded', event => {
            // Toggle the side navigation
            const sidebarToggle = document.body.querySelector('#sidebarToggle');
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', event => {
                    event.preventDefault();
                    document.body.classList.toggle('sb-sidenav-toggled');
                    localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
                });
            }
            
            // Apply active state to nav links based on current page
            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('.nav-link');
            
            navLinks.forEach(link => {
                const href = link.getAttribute('href');
                if (href && currentPath.includes(href) && href !== '/admin/dashboard') {
                    link.classList.add('active');
                }
            });
        });
    </script>
    
    <!-- Additional JavaScript -->
    @yield('scripts')
</body>
</html>