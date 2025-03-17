<?php
include 'functions.php';

$categories = getCategories();
$categoryId = isset($_GET['category']) ? $_GET['category'] : null;
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

if ($categoryId) {
    $products = getProductsByCategory($categoryId);
} elseif ($searchTerm) {
    $products = searchProducts($searchTerm);
} else {
    $products = getProducts();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <title>Coffee Shop</title>
</head>
<body class="bg-gradient-to-r from-blue-100 to-purple-100 min-h-screen">
    <!-- Header -->
    <!-- Header -->
<header class="bg-gradient-to-r from-blue-700 to-blue-900 text-white shadow-lg sticky top-0 z-50">
    <div class="container mx-auto px-4 py-3">
        <div class="flex justify-between items-center">
            <!-- Logo -->
            <a href="index.php" class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center">
                    <i class="fas fa-coffee text-2xl text-amber-700"></i>
                </div>
                <span class="text-2xl font-bold">Coffee Shop</span>
            </a>

            <!-- Navigation -->
            <nav class="flex items-center space-x-8">
                <a href="index.php" class="nav-link">
                    <i class="fas fa-home mr-2"></i>Home
                </a>
                <a href="menu.php" class="nav-link">
                    <i class="fas fa-book-open mr-2"></i>Menu
                </a>
                <a href="cart.php" class="nav-link relative">
                    <i class="fas fa-shopping-cart mr-2"></i>Cart
                    <?php if(isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
                    <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                        <?php echo count($_SESSION['cart']); ?>
                    </span>
                    <?php endif; ?>
                </a>

                <?php if (isset($_SESSION['user_id'])): ?>
                <!-- User Dropdown -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center space-x-3 hover:opacity-80 transition-opacity focus:outline-none">
                        <img src="<?php echo $_SESSION['profile_picture'] ? 'assets/images/profiles/' . $_SESSION['profile_picture'] : 'assets/images/default-avatar.png'; ?>" 
                             alt="Profile" 
                             class="w-10 h-10 rounded-full border-2 border-white object-cover">
                        <div class="text-left hidden md:block">
                            <p class="text-sm font-medium"><?php echo htmlspecialchars($_SESSION['username']); ?></p>
                            <p class="text-xs opacity-75"><?php echo ucfirst($_SESSION['role']); ?></p>
                        </div>
                        <i class="fas fa-chevron-down text-xs transition-transform" :class="{ 'rotate-180': open }"></i>
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="open" 
                         @click.away="open = false"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute right-0 mt-3 w-64 bg-white rounded-xl shadow-xl py-2 z-50">
                        
                        <!-- User Info -->
                        <div class="px-4 py-3 border-b border-gray-100">
                            <p class="text-xs text-gray-500 uppercase">Signed in as</p>
                            <p class="text-sm font-medium text-gray-900 mt-1"><?php echo htmlspecialchars($_SESSION['full_name']); ?></p>
                            <div class="flex items-center mt-2">
                                <span class="inline-block w-2 h-2 rounded-full <?php echo $_SESSION['role'] === 'admin' ? 'bg-green-500' : 'bg-blue-500'; ?> mr-2"></span>
                                <span class="text-xs text-gray-600"><?php echo ucfirst($_SESSION['role']); ?></span>
                            </div>
                        </div>

                        <!-- Menu Items -->
                        <div class="py-2 space-y-1 ml-2">
                            <a href="profile.php" class="dropdown-item">
                                <i class="fas fa-user-circle w-5 mr-3 text-gray-400"></i>Profile
                            </a>
                            <a href="order_history.php" class="dropdown-item">
                                <i class="fas fa-history w-5 mr-3 text-gray-400"></i>Order History
                            </a>
                            
                            <?php if (in_array($_SESSION['role'], ['admin', 'super_admin'])): ?>
                            <div class="border-t border-gray-100 my-2"></div>
                            <p class="px-4 py-2 text-xs text-gray-600 uppercase">Admin Tools</p>
                            <a href="admin/index.php" class="dropdown-item">
                                <i class="fas fa-tachometer-alt w-5 mr-3 text-gray-400"></i>Dashboard
                            </a>
                            <a href="admin/users.php" class="dropdown-item">
                                <i class="fas fa-users-cog w-5 mr-3 text-gray-400"></i>Manage Users
                            </a>
                            <a href="admin/products.php" class="dropdown-item">
                                <i class="fas fa-box w-5 mr-3 text-gray-400"></i>Manage Products
                            </a>
                            <?php endif; ?>

                            <div class="border-t border-gray-100 mt-2">
                                <a href="logout.php" class="dropdown-item text-red-600 hover:bg-red-50">
                                    <i class="fas fa-sign-out-alt w-5 mr-3"></i>Logout
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php else: ?>
                <div class="flex items-center space-x-4">
                    <a href="login.php" class="nav-link">
                        <i class="fas fa-sign-in-alt mr-2"></i>Login
                    </a>
                    <a href="register.php" class="bg-white text-blue-600 px-4 py-2 rounded-lg font-medium hover:bg-amber-50 transition-colors">
                        Register
                    </a>
                </div>
                <?php endif; ?>
            </nav>
        </div>
    </div>
</header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        <!-- Search Bar -->
        <section class="bg-white rounded-xl shadow-lg p-4 mb-8">
            <form method="GET" class="flex relative items-center gap-4">
                <div class="relative flex-1">
                    <span class=" left-3 top-3 text-gray-400">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" name="search" placeholder="Search for your favorite coffee..." 
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                </div>
                <button type="submit" 
                        class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-6 py-2 rounded-lg font-semibold hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transform hover:-translate-y-0.5 transition-all">
                    Search
                </button>
            </form>
        </section>

        <!-- Category Filters -->
        <!-- Category Section -->
<section class="mb-12">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-2xl font-bold text-gray-800 flex items-center">
            <i class="fas fa-tags mr-3 text-amber-600"></i>
            Browse Categories
        </h3>
        <a href="#" class="text-amber-600 hover:text-amber-700 flex items-center">
            View All <i class="fas fa-arrow-right ml-2"></i>
        </a>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6">
        <!-- All Products Category -->
        <a href="index.php" class="category-card group">
            <div class="category-overlay"></div>
            <div class="relative p-6 flex flex-col items-center justify-center h-40">
                <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mb-3">
                    <i class="fas fa-coffee text-2xl text-white"></i>
                </div>
                <span class="text-white font-medium text-lg">All Products</span>
                <span class="text-white/80 text-sm mt-2">
                    <?php echo count($products); ?> items
                </span>
            </div>
        </a>

        <!-- Dynamic Categories -->
        <?php foreach ($categories as $category): ?>
        <a href="?category=<?php echo $category['id']; ?>" 
           class="category-card group <?php echo $categoryId == $category['id'] ? 'ring-2 ring-amber-500' : ''; ?>">
            <?php if ($category['image']): ?>
            <img src="assets/images/categories/<?php echo htmlspecialchars($category['image']); ?>" 
                 alt="<?php echo htmlspecialchars($category['name']); ?>"
                 class="absolute inset-0 w-full h-full object-cover">
            <?php endif; ?>
            <div class="category-overlay"></div>
            <div class="relative p-6 flex flex-col items-center justify-center h-40">
                <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mb-3">
                    <i class="<?php echo $category['icon'] ?? 'fas fa-mug-hot'; ?> text-2xl text-white"></i>
                </div>
                <span class="text-blue-900 font-medium text-lg text-center">
                    <?php echo htmlspecialchars($category['name']); ?>
                </span>
                <span class="text-white/80 text-sm mt-2">
                    <?php 
                    $count = count(getProductsByCategory($category['id']));
                    echo $count . ' ' . ($count == 1 ? 'item' : 'items');
                    ?>
                </span>
            </div>
        </a>
        <?php endforeach; ?>
    </div>
</section>

        <!-- Carousel Banner -->
        <section class="relative w-full overflow-hidden rounded-2xl shadow-xl mb-10 group">
            <div class="carousel flex transition-transform duration-700 ease-in-out">
                <div class="carousel-item min-w-full h-80 bg-cover bg-center relative" style="background-image: url('assets/images/banner1.jpg');">
                    <div class="absolute inset-0 bg-black bg-opacity-30">
                        <div class="flex items-center justify-center h-full text-white">
                            <div class="text-center">
                                <h2 class="text-4xl font-bold mb-2">Welcome to Coffee Shop</h2>
                                <p class="text-xl">Discover our amazing coffee selection</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item min-w-full h-80 bg-cover bg-center relative" style="background-image: url('assets/images/banner2.jpg');">
                    <div class="absolute inset-0 bg-black bg-opacity-30">
                        <div class="flex items-center justify-center h-full text-white">
                            <div class="text-center">
                                <h2 class="text-4xl font-bold mb-2">Special Offers</h2>
                                <p class="text-xl">Check out our daily specials</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item min-w-full h-80 bg-cover bg-center relative" style="background-image: url('assets/images/banner1.jpg');">
                    <div class="absolute inset-0 bg-black bg-opacity-30">
                        <div class="flex items-center justify-center h-full text-white">
                            <div class="text-center">
                                <h2 class="text-4xl font-bold mb-2">Premium Quality</h2>
                                <p class="text-xl">Experience the finest coffee beans</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Navigation Buttons -->
            <button id="prevButton" class="absolute top-1/2 left-4 transform -translate-y-1/2 bg-black bg-opacity-30 text-white w-10 h-10 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 hover:bg-opacity-50 transition-all duration-300">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button id="nextButton" class="absolute top-1/2 right-4 transform -translate-y-1/2 bg-black bg-opacity-30 text-white w-10 h-10 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 hover:bg-opacity-50 transition-all duration-300">
                <i class="fas fa-chevron-right"></i>
            </button>

            <!-- Dots Navigation -->
            <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
                <button class="carousel-dot w-3 h-3 rounded-full bg-white bg-opacity-50 hover:bg-opacity-100 transition-all duration-300"></button>
                <button class="carousel-dot w-3 h-3 rounded-full bg-white bg-opacity-50 hover:bg-opacity-100 transition-all duration-300"></button>
                <button class="carousel-dot w-3 h-3 rounded-full bg-white bg-opacity-50 hover:bg-opacity-100 transition-all duration-300"></button>
            </div>
        </section>

        <!-- Products Section -->
        <section class="bg-white rounded-2xl shadow-2xl p-8">
            <h2 class="text-3xl font-bold text-gray-800 mb-8 flex items-center justify-between">
                <span class="flex items-center">
                    <i class="fas fa-mug-hot text-blue-500 mr-3"></i>
                    <?php
                    if ($categoryId) {
                        foreach ($categories as $cat) {
                            if ($cat['id'] == $categoryId) {
                                echo htmlspecialchars($cat['name']);
                                break;
                            }
                        }
                    } else {
                        echo 'Our Menu';
                    }
                    ?>
                </span>
                <?php if ($searchTerm): ?>
                    <span class="text-lg text-gray-600">
                        Search results for: "<?php echo htmlspecialchars($searchTerm); ?>"
                    </span>
                <?php endif; ?>
            </h2>

            <?php if (empty($products)): ?>
                <div class="text-center py-8">
                    <i class="fas fa-coffee text-6xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500 text-xl">No products found</p>
                    <?php if ($searchTerm): ?>
                        <a href="index.php" class="text-blue-500 hover:text-blue-600 mt-4 inline-block">
                            Clear search and show all products
                        </a>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach ($products as $product): ?>
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden transform hover:scale-105 transition-transform duration-300">
                            <img src="assets/images/<?php echo htmlspecialchars($product['image']); ?>" 
                                 alt="<?php echo htmlspecialchars($product['name']); ?>" 
                                 class="w-full h-48 object-cover">
                            <div class="p-6">
                                <div class="flex justify-between items-start mb-2">
                                    <h3 class="text-xl font-bold text-gray-800"><?php echo htmlspecialchars($product['name']); ?></h3>
                                    <span class="text-sm text-gray-500 bg-gray-100 px-2 py-1 rounded">
                                        <?php echo htmlspecialchars($category['name']); ?>
                                    </span>
                                </div>
                                <p class="text-gray-600 mb-4"><?php echo htmlspecialchars($product['description']); ?></p>
                                <div class="flex justify-between items-center mb-4">
                                    <p class="text-2xl font-bold text-blue-600">
                                        Rp <?php echo number_format($product['price'], 2, ',', '.'); ?>
                                    </p>
                                    <?php if ($product['stock'] <= 5): ?>
                                        <span class="text-sm text-orange-500">
                                            Only <?php echo $product['stock']; ?> left!
                                        </span>
                                    <?php endif; ?>
                                </div>
                                <form action="cart.php" method="POST" class="flex items-center gap-2">
                                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                    <div class="relative flex-1">
                                        <input type="number" name="quantity" min="1" max="<?php echo $product['stock']; ?>" value="1" 
                                               class="w-20 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                    <button type="submit" 
                                            class="flex-1 bg-gradient-to-r from-blue-500 to-blue-600 text-white                                            px-4 py-2 rounded-lg font-semibold hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors 
                                            <?php echo $product['stock'] == 0 ? 'opacity-50 cursor-not-allowed' : ''; ?>"
                                            <?php echo $product['stock'] == 0 ? 'disabled' : ''; ?>>
                                        <i class="fas fa-cart-plus mr-2"></i>
                                        <?php echo $product['stock'] == 0 ? 'Out of Stock' : 'Add to Cart'; ?>
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>
    </main>

    <!-- Footer -->
    <footer class="text-center p-4 text-gray-600 text-sm">
        © 2025 Coffee Shop. All rights reserved.
    </footer>

    <!-- Carousel Script -->
    <script>
        const carousel = document.querySelector('.carousel');
        const items = document.querySelectorAll('.carousel-item');
        const prevButton = document.getElementById('prevButton');
        const nextButton = document.getElementById('nextButton');
        const dots = document.querySelectorAll('.carousel-dot');

        let currentIndex = 0;
        let isTransitioning = false;
        let autoPlayInterval;

        // Update carousel display
        function updateCarousel(newIndex) {
            if (isTransitioning) return;
            isTransitioning = true;

            // Update slide position
            const offset = -newIndex * 100;
            carousel.style.transform = `translateX(${offset}%)`;
            
            // Update dots
            dots.forEach((dot, index) => {
                dot.classList.toggle('bg-opacity-100', index === newIndex);
                dot.classList.toggle('bg-opacity-50', index !== newIndex);
            });

            currentIndex = newIndex;

            // Reset transition lock after animation
            setTimeout(() => {
                isTransitioning = false;
            }, 700); // Match duration-700 from Tailwind
        }

        // Previous slide
        prevButton.addEventListener('click', () => {
            const newIndex = (currentIndex > 0) ? currentIndex - 1 : items.length - 1;
            updateCarousel(newIndex);
            resetAutoPlay();
        });

        // Next slide
        nextButton.addEventListener('click', () => {
            const newIndex = (currentIndex < items.length - 1) ? currentIndex + 1 : 0;
            updateCarousel(newIndex);
            resetAutoPlay();
        });

        // Dot navigation
        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                updateCarousel(index);
                resetAutoPlay();
            });
        });

        // Auto-play functionality
        function startAutoPlay() {
            autoPlayInterval = setInterval(() => {
                const newIndex = (currentIndex < items.length - 1) ? currentIndex + 1 : 0;
                updateCarousel(newIndex);
            }, 5000);
        }

        function resetAutoPlay() {
            clearInterval(autoPlayInterval);
            startAutoPlay();
        }

        // Touch support for mobile devices
        let touchStartX = 0;
        let touchEndX = 0;

        carousel.addEventListener('touchstart', e => {
            touchStartX = e.changedTouches[0].screenX;
        });

        carousel.addEventListener('touchend', e => {
            touchEndX = e.changedTouches[0].screenX;
            handleSwipe();
        });

        function handleSwipe() {
            const swipeThreshold = 50;
            const difference = touchStartX - touchEndX;

            if (Math.abs(difference) > swipeThreshold) {
                if (difference > 0) {
                    // Swipe left - next slide
                    const newIndex = (currentIndex < items.length - 1) ? currentIndex + 1 : 0;
                    updateCarousel(newIndex);
                } else {
                    // Swipe right - previous slide
                    const newIndex = (currentIndex > 0) ? currentIndex - 1 : items.length - 1;
                    updateCarousel(newIndex);
                }
                resetAutoPlay();
            }
        }

        // Initialize
        updateCarousel(0);
        startAutoPlay();
        const profileDropdown = document.getElementById('profileDropdown');
    const profileButton = document.querySelector('.group button');

    profileButton.addEventListener('click', (e) => {
        e.stopPropagation();
        profileDropdown.classList.toggle('hidden');
    });

    profileDropdown.addEventListener('click', (e) => {
        e.stopPropagation();
    });

    document.addEventListener('click', () => {
        profileDropdown.classList.add('hidden');
    </script>
</body>
</html>