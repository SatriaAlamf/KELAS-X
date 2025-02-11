<?php
include 'functions.php';

$products = getProducts();

if (isset($_GET['search'])) {
    $searchTerm = $_GET['search'];
    $products = searchProducts($searchTerm);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Coffee Shop</title>
</head>
<body class="bg-gray-100">
    <header class="bg-gray-800 text-white p-4">
        <div class="container mx-auto flex justify-between">
            <h1 class="text-2xl">Coffee Shop</h1>
            <nav>
                <a href="index.php" class="mr-4">Home</a>
                <a href="cart.php" class="mr-4">Cart</a>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="order_history.php" class="mr-4">Order History</a>
                    <a href="profile.php" class="mr-4 flex items-center">
                        <img src="assets/images/user-icon.png" alt="User  Icon" class="w-6 h-6 mr-1">
                        <?php echo $_SESSION['username']; ?>
                    </a>
                    <a href="logout.php">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="mr-4">Login</a>
                    <a href="register.php">Register</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <main class="container mx-auto mt-10">
        <h2 class="text-2xl font-bold mb-4">Menu</h2>
        
        <!-- Form Pencarian -->
        <form method="GET" class="mb-4">
            <input type="text" name="search" placeholder="Search for products..." class="border p-2 w-full md:w-1/3">
            <button type="submit" class="bg-blue-500 text-white p-2 rounded">Search</button>
        </form>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php if (empty($products)): ?>
                <p>No products found.</p>
            <?php else: ?>
                <?php foreach ($products as $product): ?>
                    <div class="bg-white p-4 rounded shadow">
                        <img src="assets/images/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" class="w-full h-48 object-cover rounded">
                        <h3 class="text-lg font-semibold mt-2"><?php echo $product['name']; ?></h3>
                        <p class="text-gray-600"><?php echo $product['description']; ?></p>
                        <p class="text-xl font-bold mt-2">Rp <?php echo number_format($product['price'], 2, ',', '.'); ?></p>
                        <form action="cart.php" method="POST" class="mt-4">
                            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                            <input type="number" name="quantity" min="1" value="1" class="border p-1 w-16">
                            <button type="submit" class="bg-blue-500 text-white p-2 rounded">Add to Cart</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

    </main>
</body>
</html>
<script src="assets/js/script.js"></script>