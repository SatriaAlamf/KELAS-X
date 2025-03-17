<?php
include 'functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product_id'])) {
    $productId = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    addToCart($productId, $quantity);
    header('Location: cart.php');
}

if (isset($_GET['remove'])) {
    $productId = $_GET['remove'];
    unset($_SESSION['cart'][$productId]);
    header('Location: cart.php');
}

$cartItems = getCartItems();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <title>Shopping Cart - Coffee Shop</title>
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
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="logout.php" class="hover:text-blue-200 transition-colors flex items-center">
                            <i class="fas fa-sign-out-alt mr-1"></i> Logout
                        </a>
                    <?php else: ?>
                        <a href="login.php" class="hover:text-blue-200 transition-colors flex items-center">
                            <i class="fas fa-sign-in-alt mr-1"></i> Login
                        </a>
                        <a href="register.php" class="hover:text-blue-200 transition-colors flex items-center">
                            <i class="fas fa-user-plus mr-1"></i> Register
                        </a>
                    <?php endif; ?>
                </nav>
            </div>
        </div>
    </header>

    <main class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-2xl shadow-2xl p-8 transition-transform duration-300">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-3xl font-bold text-gray-800 flex items-center">
                    <i class="fas fa-shopping-cart mr-3 text-blue-500"></i>
                    Your Shopping Cart
                </h2>
            </div>

            <?php if (empty($cartItems)): ?>
                <div class="text-center py-8">
                    <i class="fas fa-shopping-cart text-6xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500 text-xl">Your cart is empty</p>
                    <a href="index.php" class="mt-4 inline-block bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition-colors">
                        Continue Shopping
                    </a>
                </div>
            <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white rounded-lg overflow-hidden">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-gray-600">Product</th>
                                <th class="px-6 py-3 text-left text-gray-600">Quantity</th>
                                <th class="px-6 py-3 text-left text-gray-600">Price</th>
                                <th class="px-6 py-3 text-left text-gray-600">Total</th>
                                <th class="px-6 py-3 text-left text-gray-600">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <?php
                            $total = 0;
                            foreach ($cartItems as $item):
                                $itemTotal = $item['price'] * $item['quantity'];
                                $total += $itemTotal;
                            ?>
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <i class="fas fa-coffee text-gray-400 mr-3"></i>
                                            <?php echo $item['name']; ?>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <form action="cart.php" method="POST" class="flex items-center space-x-2">
                                            <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                                            <input type="number" name="quantity" min="1" value="<?php echo $item['quantity']; ?>" 
                                                class="w-20 px-3 py-1 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded-lg hover:bg-blue-600 transition-colors">
                                                <i class="fas fa-sync-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                    <td class="px-6 py-4">
                                        Rp <?php echo number_format($item['price'], 2, ',', '.'); ?>
                                    </td>
                                    <td class="px-6 py-4 font-medium">
                                        Rp <?php echo number_format($itemTotal, 2, ',', '.'); ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="?remove=<?php echo $item['id']; ?>" 
                                        class="text-red-500 hover:text-red-600 transition-colors">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="mt-8 space-y-4">
                    <div class="flex justify-between items-center px-6 py-4 bg-gray-50 rounded-lg">
                        <h3 class="text-2xl font-bold text-gray-800">Total:</h3>
                        <span class="text-2xl font-bold text-blue-600">
                            Rp <?php echo number_format($total, 2, ',', '.'); ?>
                        </span>
                    </div>
                    
                    <div class="flex justify-end space-x-4">
                        <a href="index.php" class="px-6 py-3 text-gray-600 hover:text-gray-800 transition-colors">
                            Continue Shopping
                        </a>
                        <form action="checkout.php" method="POST">
                            <button type="submit" class="bg-gradient-to-r from-green-500 to-green-600 text-white px-8 py-3 rounded-lg font-semibold hover:from-green-600 hover:to-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transform hover:-translate-y-0.5 transition-all">
                                <i class="fas fa-credit-card mr-2"></i>
                                Proceed to Checkout
                            </button>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <!-- Footer -->
    <footer class="text-center p-4 text-gray-600 text-sm">
        © 2025 Coffee Shop. All rights reserved.
    </footer>

    <script src="assets/js/script.js"></script>
</body>
</html>