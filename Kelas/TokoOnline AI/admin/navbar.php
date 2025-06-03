<?php
if (!isset($_SESSION)) {
    session_start();
}

// Get current page name
$current_page = basename($_SERVER['PHP_SELF'], '.php');
?>

<nav class="bg-white shadow-lg mb-8">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="index.php" class="text-xl font-bold text-gray-800">
                        <i class="fas fa-coffee mr-2"></i>
                        Coffee Shop Admin
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden md:ml-6 md:flex md:space-x-8">
                    <?php
                    $nav_items = [
                        'index' => ['icon' => 'fas fa-chart-line', 'text' => 'Dashboard'],
                        'manage_products' => ['icon' => 'fas fa-box-open', 'text' => 'Products'],
                        'manage_categories' => ['icon' => 'fas fa-tags', 'text' => 'Categories'],
                        'manage_users' => ['icon' => 'fas fa-users', 'text' => 'Users'],
                        'manage_order' => ['icon' => 'fas fa-shopping-cart', 'text' => 'Orders']
                    ];

                    foreach ($nav_items as $page => $item): 
                        $is_active = $current_page === $page;
                    ?>
                    <a href="<?php echo $page; ?>.php" 
                       class="border-b-2 <?php echo $is_active ? 'border-blue-500 text-gray-900' : 'border-transparent hover:border-gray-300 text-gray-500 hover:text-gray-700'; ?> inline-flex items-center px-1 pt-1 text-sm font-medium">
                        <i class="<?php echo $item['icon']; ?> mr-2"></i>
                        <?php echo $item['text']; ?>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Mobile Menu Button -->
            <div class="md:hidden flex items-center">
                <button type="button" class="mobile-menu-button inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100">
                    <i class="fas fa-bars"></i>
                </button>
            </div>

            <!-- User Menu -->
            <div class="hidden md:flex items-center">
                <div class="ml-3 relative" x-data="{ open: false }">
                    <div class="flex items-center">
                        <span class="hidden md:block mr-3 text-gray-700">
                            Welcome, <?php echo htmlspecialchars($_SESSION['username'] ?? 'Guest'); ?>
                        </span>
                        <button type="button" 
                                @click="open = !open"
                                class="bg-gray-800 flex text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white">
                            <img class="h-8 w-8 rounded-full" 
                                 src="<?php echo isset($_SESSION['profile_picture']) ? '../assets/images/profiles/' . $_SESSION['profile_picture'] : '../assets/images/default-avatar.png'; ?>" 
                                 alt="Profile">
                        </button>
                    </div>

                    <!-- Dropdown Menu -->
                    <div x-show="open"
                         @click.away="open = false"
                         class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5"
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95">
                        <a href="profile.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-user mr-2"></i>Profile
                        </a>
                        <a href="settings.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-cog mr-2"></i>Settings
                        </a>
                        <div class="border-t border-gray-100"></div>
                        <a href="../logout.php" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                            <i class="fas fa-sign-out-alt mr-2"></i>Logout
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div class="hidden md:hidden mobile-menu">
        <div class="px-2 pt-2 pb-3 space-y-1">
            <?php foreach ($nav_items as $page => $item): ?>
            <a href="<?php echo $page; ?>.php" 
               class="<?php echo $current_page === $page ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50'; ?> block px-3 py-2 rounded-md text-base font-medium">
                <i class="<?php echo $item['icon']; ?> mr-2"></i>
                <?php echo $item['text']; ?>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</nav>

<script>
    // Mobile menu toggle
    const mobileMenuButton = document.querySelector('.mobile-menu-button');
    const mobileMenu = document.querySelector('.mobile-menu');

    mobileMenuButton.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
    });
</script>