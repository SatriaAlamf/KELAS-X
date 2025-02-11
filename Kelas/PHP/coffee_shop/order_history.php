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
    <title>Order History</title>
</head>
<body class="bg-gray-100">
    <header class="bg-gray-800 text-white p-4">
        <div class="container mx-auto flex justify-between">
            <h1 class="text-2xl">Coffee Shop</h1>
            <nav>
                <a href="index.php" class="mr-4">Home</a>
                <a href="cart.php" class="mr-4">Cart</a>
                <a href="order_history.php" class="mr-4">Order History</a>
                <a href="logout.php">Logout</a>
            </nav>
        </div>
    </header>

    <main class="container mx-auto mt-10">
        <h2 class="text-2xl font-bold mb-4">Your Order History</h2>
        <?php if (empty($orders)): ?>
            <p>You have no orders yet.</p>
        <?php else: ?>
            <table class="min-w-full bg-white border border-gray-300">
                <thead>
                    <tr>
                        <th class="border px-4 py-2">Order ID</th>
                        <th class="border px-4 py-2">Total</th>
                        <th class="border px-4 py-2">Order Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td class="border px-4 py-2"><?php echo $order['id']; ?></td>
                            <td class="border px-4 py-2">Rp <?php echo number_format($order['total'], 2, ',', '.'); ?></td>
                            <td class="border px-4 py-2"><?php echo date('d-m-Y H:i:s', strtotime($order['order_date'])); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </main>
</body>
</html>