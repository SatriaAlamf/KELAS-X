<?php
include 'functions.php';

$categories = getCategories();
$allProducts = getProducts();

// Group products by category
$productsByCategory = [];
foreach ($allProducts as $product) {
    $categoryId = $product['category_id'];
    if (!isset($productsByCategory[$categoryId])) {
        $productsByCategory[$categoryId] = [];
    }
    $productsByCategory[$categoryId][] = $product;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu - Coffee Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        .scroll-spy-active {
            color: #B45309; /* Warna amber-700 */
            border-color: #B45309;
        }

        .category-section {
            scroll-margin-top: 100px;
        }

        .menu-card {
            transition: transform 0.2s;
        }

        .menu-card:hover {
            transform: translateY(-5px);
        }

        .sticky-nav {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    
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
                        <div class="py-2">
                            <a href="profile.php" class="dropdown-item">
                                <i class="fas fa-user-circle w-5 mr-3 text-gray-400"></i>Profile
                            </a>
                            <a href="order_history.php" class="dropdown-item">
                                <i class="fas fa-history w-5 mr-3 text-gray-400"></i>Order History
                            </a>
                            
                            <?php if (in_array($_SESSION['role'], ['admin', 'super_admin'])): ?>
                            <div class="border-t border-gray-100 my-2"></div>
                            <p class="px-4 py-2 text-xs text-gray-500 uppercase">Admin Tools</p>
                            <a href="admin/dashboard.php" class="dropdown-item">
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
                    <a href="register.php" class="bg-white text-amber-700 px-4 py-2 rounded-lg font-medium hover:bg-amber-50 transition-colors">
                        Register
                    </a>
                </div>
                <?php endif; ?>
            </nav>
        </div>
    </div>
</header>

    <main class="container mx-auto px-4 py-8">
        <!-- Hero Section -->
        <div class="relative rounded-2xl overflow-hidden mb-8 h-64">
            <img src="assets/images/menu-banner.jpg" alt="Menu Banner" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                <div class="text-center text-white">
                    <h1 class="text-4xl font-bold mb-2">Our Menu</h1>
                    <p class="text-lg">Discover our carefully crafted selection of coffee and treats</p>
                </div>
            </div>
        </div>

        <!-- Category Navigation -->
        <nav class="sticky top-20 z-40 -mx-4 px-4 py-3 mb-8 sticky-nav" x-data="{ activeCategory: '' }">
            <div class="flex space-x-4 overflow-x-auto pb-2 scrollbar-hide">
                <?php foreach ($categories as $category): ?>
                <a href="#category-<?php echo $category['id']; ?>"
                   class="flex-shrink-0 px-4 py-2 rounded-full border-2 transition-colors duration-200 hover:text-amber-700 hover:border-amber-700"
                   :class="{ 'scroll-spy-active': activeCategory === 'category-<?php echo $category['id']; ?>' }"
                   @click="activeCategory = 'category-<?php echo $category['id']; ?>'">
                    <?php echo htmlspecialchars($category['name']); ?>
                </a>
                <?php endforeach; ?>
            </div>
        </nav>

        <!-- Menu Sections -->
        <?php foreach ($categories as $category): ?>
        <?php if (isset($productsByCategory[$category['id']])): ?>
        <section id="category-<?php echo $category['id']; ?>" class="mb-12 category-section">
            <div class="flex items-center space-x-4 mb-6">
                <h2 class="text-2xl font-bold text-gray-800">
                    <i class="<?php echo $category['icon'] ?? 'fas fa-mug-hot'; ?> mr-2 text-amber-600"></i>
                    <?php echo htmlspecialchars($category['name']); ?>
                </h2>
                <?php if ($category['description']): ?>
                <p class="text-gray-600 text-sm"><?php echo htmlspecialchars($category['description']); ?></p>
                <?php endif; ?>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($productsByCategory[$category['id']] as $product): ?>
                <div class="menu-card bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="relative h-48">
                        <img src="assets/images/products/<?php echo htmlspecialchars($product['image']); ?>" 
                             alt="<?php echo htmlspecialchars($product['name']); ?>"
                             class="w-full h-full object-cover">
                        <?php if ($product['stock'] <= 5 && $product['stock'] > 0): ?>
                        <span class="absolute top-2 right-2 bg-amber-100 text-amber-800 text-xs px-2 py-1 rounded-full">
                            Only <?php echo $product['stock']; ?> left!
                        </span>
                        <?php endif; ?>
                    </div>

                    <div class="p-4">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">
                            <?php echo htmlspecialchars($product['name']); ?>
                        </h3>
                        <p class="text-gray-600 text-sm mb-4">
                            <?php echo htmlspecialchars($product['description']); ?>
                        </p>
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-2xl font-bold text-amber-600">
                                Rp <?php echo number_format($product['price'], 0, ',', '.'); ?>
                            </span>
                            <?php if ($product['stock'] == 0): ?>
                            <span class="text-red-500 text-sm">Out of Stock</span>
                            <?php endif; ?>
                        </div>

                        <form action="cart.php" method="POST" class="flex gap-2">
                            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                            <div class="relative flex-1">
                                <select name="quantity" 
                                        class="w-full pl-3 pr-8 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                                        <?php echo $product['stock'] == 0 ? 'disabled' : ''; ?>>
                                    <?php for ($i = 1; $i <= min(10, $product['stock']); $i++): ?>
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                            <button type="submit" 
                                    class="flex-1 bg-amber-600 text-blue-600 px-4 py-2 rounded-lg font-semibold hover:bg-amber-700 transition-colors <?php echo $product['stock'] == 0 ? 'opacity-50 cursor-not-allowed' : ''; ?>"
                                    <?php echo $product['stock'] == 0 ? 'disabled' : ''; ?>>
                                <i class="fas fa-cart-plus mr-2"></i>
                                <?php echo $product['stock'] == 0 ? 'Out of Stock' : 'Add to Cart'; ?>
                            </button>
                        </form>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </section>
        <?php endif; ?>
        <?php endforeach; ?>
    </main>

    

    <script>
        // Intersection Observer for scroll spy
        const sections = document.querySelectorAll('.category-section');
        const navLinks = document.querySelectorAll('nav a');

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const activeId = entry.target.getAttribute('id');
                    navLinks.forEach(link => {
                        if (link.getAttribute('href') === `#${activeId}`) {
                            link.classList.add('scroll-spy-active');
                        } else {
                            link.classList.remove('scroll-spy-active');
                        }
                    });
                }
            });
        }, { rootMargin: '-20% 0px -80% 0px' });

        sections.forEach(section => observer.observe(section));

        // Smooth scroll
        document.querySelectorAll('nav a').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const targetId = this.getAttribute('href').substring(1);
                const target = document.getElementById(targetId);
                target.scrollIntoView({ behavior: 'smooth' });
            });
        });
    </script>
</body>
</html>