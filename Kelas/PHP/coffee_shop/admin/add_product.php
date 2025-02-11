<?php
include '../functions.php';

if (!isAdmin()) {
    header('Location: ../index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image = $_FILES['image']['name'];
    $target = "../assets/images/" . basename($image);

    // Upload image
    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        $stmt = $pdo->prepare("INSERT INTO products (name, description, price, image) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $description, $price, $image]);
        echo "<script>alert('Product added successfully!'); window.location.href='manage_products.php';</script>";
    } else {
        echo "<script>alert('Failed to upload image.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Add Product</title>
</head>
<body class="bg-gray-100">
    <header class="bg-gray-800 text-white p-4">
        <div class="container mx-auto">
            <h1 class="text-2xl">Add Product</h1>
        </div>
    </header>

    <main class="container mx-auto mt-10">
        <form method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow-md">
            <input type="text" name="name" placeholder="Product Name" required class="border p-2 mb-4 w-full">
            <textarea name="description" placeholder="Description" required class="border p-2 mb-4 w-full"></textarea>
            <input type="number" name="price" placeholder="Price" required class="border p-2 mb-4 w-full">
            <input type="file" name="image" required class="border p-2 mb-4 w-full">
            <button type="submit" class="bg-blue-500 text-white p-2 rounded">Add Product</button>
        </form>
    </main>
</body>
</html>
<script src="assets/js/script.js"></script>