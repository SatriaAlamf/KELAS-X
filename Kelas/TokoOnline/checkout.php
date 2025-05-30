<?php
include 'functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_SESSION['user_id']) && !empty($_SESSION['cart'])) {
        global $pdo;
        $userId = $_SESSION['user_id'];
        $total = 0;

        // Insert order
        $stmt = $pdo->prepare("INSERT INTO orders (user_id, total) VALUES (?, ?)");
        $stmt->execute([$userId, $total]);
        $orderId = $pdo->lastInsertId();

        // Insert order items
        foreach ($_SESSION['cart'] as $productId => $quantity) {
            $stmt = $pdo->prepare("SELECT price FROM products WHERE id = ?");
            $stmt->execute([$productId]);
            $product = $stmt->fetch(PDO::FETCH_ASSOC);
            $itemTotal = $product['price'] * $quantity;
            $total += $itemTotal;

            $stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity) VALUES (?, ?, ?)");
            $stmt->execute([$orderId, $productId, $quantity]);
        }

        // Update order total
        $stmt = $pdo->prepare("UPDATE orders SET total = ? WHERE id = ?");
        $stmt->execute([$total, $orderId]);

        // Clear cart
        unset($_SESSION['cart']);
        echo "<script>alert('Checkout successful!'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Your cart is empty or you are not logged in.'); window.location.href='index.php';</script>";
    }
}
if (empty($_SESSION['cart'])) {
    echo "<script>alert('Your cart is empty.'); window.location.href='index.php';</script>";
    exit();
}
?>
<script src="assets/js/script.js"></script>