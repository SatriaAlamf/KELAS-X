<?php
include '../functions.php';

// Check admin authorization
if (!isAdmin()) {
    header('Location: ../index.php');
    exit();
}

// Get statistics
$totalProducts = getTotalProducts();
$totalUsers = getTotalUsers();
$totalCategories = getTotalCategories();

// Get latest records
$latestProducts = getLatestProducts(5);
$latestUsers = getLatestUsers(5);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        
    <?php include 'navbar.php'; ?>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8">
        <!-- ...existing dashboard content... -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Products Card -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                        <i class="fas fa-box-open text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-gray-600">Total Products</h2>
                        <p class="text-2xl font-semibold"><?php echo $totalProducts; ?></p>
                    </div>
                </div>
            </div>

            <!-- Users Card -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-600">
                        <i class="fas fa-users text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-gray-600">Total Users</h2>
                        <p class="text-2xl font-semibold"><?php echo $totalUsers; ?></p>
                    </div>
                </div>
            </div>

            <!-- Categories Card -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                        <i class="fas fa-tags text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-gray-600">Total Categories</h2>
                        <p class="text-2xl font-semibold"><?php echo $totalCategories; ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Latest Products -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold mb-4">Latest Products</h2>
                <div class="divide-y">
                    <?php foreach ($latestProducts as $product): ?>
                    <div class="py-3">
                        <div class="flex items-center">
                            <img src="../assets/images/products/<?php echo htmlspecialchars($product['image']); ?>" 
                                 alt="<?php echo htmlspecialchars($product['name']); ?>"
                                 class="w-10 h-10 rounded object-cover">
                            <div class="ml-4">
                                <p class="font-semibold"><?php echo htmlspecialchars($product['name']); ?></p>
                                <p class="text-sm text-gray-600">
                                    <?php echo htmlspecialchars($product['category_name']); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Latest Users -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold mb-4">Latest Users</h2>
                <div class="divide-y">
                    <?php foreach ($latestUsers as $user): ?>
                    <div class="py-3">
                        <div class="flex items-center">
                            <div class="p-2 rounded-full bg-gray-100">
                                <i class="fas fa-user text-gray-500"></i>
                            </div>
                            <div class="ml-4">
                                <p class="font-semibold"><?php echo htmlspecialchars($user['full_name']); ?></p>
                                <p class="text-sm text-gray-600"><?php echo htmlspecialchars($user['email']); ?></p>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script>
        // Toggle User Menu
        const userMenuButton = document.getElementById('user-menu-button');
        const userMenu = document.getElementById('user-menu');

        userMenuButton.addEventListener('click', () => {
            userMenu.classList.toggle('hidden');
        });

        // Close menu when clicking outside
        document.addEventListener('click', (event) => {
            if (!userMenuButton.contains(event.target) && !userMenu.contains(event.target)) {
                userMenu.classList.add('hidden');
            }
        });
    </script>

        <!-- Statistics Cards -->
       
</body>
</html>