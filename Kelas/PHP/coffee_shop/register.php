<?php
include 'functions.php';
// Di register.php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = isset($_POST['role']) ? $_POST['role'] : 'user'; // Default role adalah user

    if (register($username, $password, $role)) {
        header('Location: login.php');
        exit();
    } else {
        $error = "Registration failed. Username may already be taken.";
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Register</title>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto mt-10">
        <h2 class="text-2xl font-bold mb-4">Register</h2>
        <?php if (isset($error)): ?>
            <p class="text-red-500"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="POST" class="bg-white p-6 rounded shadow-md">
            <input type="text" name="username" placeholder="Username" required class="border p-2 mb-4 w-full">
            <input type="password" name="password" placeholder="Password" required class="border p-2 mb-4 w-full">
            <button type="submit" class="bg-blue-500 text-white p-2 rounded">Register</button>
        </form>
        <p class="mt-4">Already have an account? <a href="login.php" class="text-blue-500">Login here</a></p>
    </div>
</body>
</html>
<script src="assets/js/script.js"></script>