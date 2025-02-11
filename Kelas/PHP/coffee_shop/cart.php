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
    unset($_SESSION['cart'][$productId]); // Hapus item dari cart
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
    <title>Cart</title>
</head>
<body class="bg-gray-100">
    <header class="bg-gray-800 text-white p-4">
        <div class="container mx-auto flex justify-between">
            <h1 class="text-2xl">Coffee Shop</h1>
            <nav>
                <a href="index.php" class="mr-4">Home</a>
                <a href="cart.php" class="mr-4">Cart</a>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="logout.php">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="mr-4">Login</a>
                    <a href="register.php">Register</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <main class="container mx-auto mt-10">
        <h2 class="text-2xl font-bold mb-4">Your Cart</h2>
        <?php if (empty($cartItems)): ?>
            <p>Your cart is empty.</p>
        <?php else: ?>
            <table class="min-w-full bg-white border border-gray-300">
                <thead>
                    <tr>
                        <th class="border px-4 py-2">Product</th>
                        <th class="border px-4 py-2">Quantity</th>
                        <th class="border px-4 py-2">Price</th>
                        <th class="border px-4 py-2">Total</th>
                        <th class="border px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total = 0;
                    foreach ($cartItems as $item):
                        $itemTotal = $item['price'] * $item['quantity'];
                        $total += $itemTotal;
                    ?>
                        <tr>
                            <td class="border px-4 py-2"><?php echo $item['name']; ?></td>
                            <td class="border px-4 py-2">
                                <form action="cart.php" method="POST" class="inline">
                                    <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                                    <input type="number" name="quantity" min="1" value="<?php echo $item['quantity']; ?>" class="border p-1 w-16">
                                    <button type="submit" class="bg-blue-500 text-white p-1 rounded">Update</button>
                                </form>
                            </td>
                            <td class="border px-4 py-2">Rp <?php echo number_format($item['price'], 2, ',', '.'); ?></td>
                            <td class="border px-4 py-2">Rp <?php echo number_format($itemTotal, 2, ',', '.'); ?></td>
                            <td class="border px-4 py-2">
                                <a href="?remove=<?php echo $item['id']; ?>" class="text-red-500">Remove</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="mt-4">
                <h3 class="text-xl font-bold">Total: Rp <?php echo number_format($total, 2, ',', '.'); ?></h3> <form action="checkout.php" method="POST" class="mt-4">
                    <button type="submit" class="bg-green-500 text-white p-2 rounded">Checkout</button>
                </form>
            </div>
        <?php endif; ?>
    </main>
</body>
</html>
<script src="assets/js/script.js"></script>