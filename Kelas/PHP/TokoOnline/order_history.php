<?php
include 'functions.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$userId = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY order_date DESC");
$stmt->execute([$userId]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <title>Order History - Coffee Shop</title>
</head>
<body class="bg-gradient-to-r from-blue-100 to-purple-100 min-h-screen">
    <!-- Header -->
    <header class="bg-gradient-to-r from-blue-600 to-blue-800 text-white shadow-lg">
        <div class="container mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold flex items-center">
                    <i class="fas fa-coffee mr-2"></i>
                    Coffee Shop
                </h1>
                <nav class="flex items-center space-x-6">
                    <a href="index.php" class="hover:text-blue-200 transition-colors flex items-center">
                        <i class="fas fa-home mr-1"></i> Home
                    </a>
                    <a href="cart.php" class="hover:text-blue-200 transition-colors flex items-center">
                        <i class="fas fa-shopping-cart mr-1"></i> Cart
                    </a>
                    <a href="order_history.php" class="hover:text-blue-200 transition-colors flex items-center">
                        <i class="fas fa-history mr-1"></i> Order History
                    </a>
                    <a href="logout.php" class="hover:text-blue-200 transition-colors flex items-center">
                        <i class="fas fa-sign-out-alt mr-1"></i> Logout
                    </a>
                </nav>
            </div>
        </div>
    </header>

    <main class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-2xl shadow-2xl p-8">
            <h2 class="text-3xl font-bold text-gray-800 mb-8 flex items-center">
                <i class="fas fa-history text-blue-500 mr-3"></i>
                Your Order History
            </h2>

            <?php if (empty($orders)): ?>
                <div class="text-center py-8">
                    <i class="fas fa-receipt text-6xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500 text-xl">You have no orders yet.</p>
                    <a href="index.php" class="inline-block mt-4 bg-gradient-to-r from-blue-500 to-blue-600 text-white px-6 py-2 rounded-lg font-semibold hover:from-blue-600 hover:to-blue-700 transition-colors">
                        Start Shopping
                    </a>
                </div>
            <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white rounded-lg overflow-hidden">
                        <thead class="bg-gradient-to-r from-blue-600 to-blue-800 text-white">
                            <tr>
                                <th class="px-6 py-4 text-left">Order ID</th>
                                <th class="px-6 py-4 text-left">Total</th>
                                <th class="px-6 py-4 text-left">Order Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <?php foreach ($orders as $order): ?>
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4">
                                        <span class="font-medium text-blue-600">#<?php echo $order['id']; ?></span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="font-semibold">
                                            Rp <?php echo number_format($order['total'], 2, ',', '.'); ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-gray-600">
                                            <?php echo date('d M Y H:i', strtotime($order['order_date'])); ?>
                                        </span>
                                    </td>
                                    <!-- <td class="px-6 py-4">
                                        <span class="px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                                            Completed
                                        </span>
                                    </td> -->
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <!-- Footer -->
    <footer class="text-center p-4 text-gray-600 text-sm">
        © 2025 Coffee Shop. All rights reserved.
    </footer>
</body>
</html>