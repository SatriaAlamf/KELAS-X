<?php
include 'functions.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$userId = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>User Profile</title>
</head>
<body class="bg-gray-100">
    <header class="bg-gray-800 text-white p-4">
        <div class="container mx-auto flex justify-between">
            <h1 class="text-2xl">User  Profile</h1>
            <nav>
                <a href="index.php" class="mr-4">Home</a>
                <a href="cart.php" class="mr-4">Cart</a>
                <a href="order_history.php" class="mr-4">Order History</a>
                <a href="profile.php" class="mr-4">Profile</a>
                <a href="logout.php">Logout</a>
            </nav>
        </div>
    </header>

    <main class="container mx-auto mt-10">
        <h2 class="text-2xl font-bold mb-4">Profile Information</h2>
        <div class="bg-white p-6 rounded shadow-md">
            <p><strong>Username:</strong> <?php echo $user['username']; ?></p>
            <p><strong>Role:</strong> <?php echo $user['role']; ?></p>
            <p><strong>Member Since:</strong> <?php echo date('d-m-Y', strtotime($user['created_at'])); ?></p>
        </div>
    </main>
</body>
</html>
<script src="assets/js/script.js"></script>