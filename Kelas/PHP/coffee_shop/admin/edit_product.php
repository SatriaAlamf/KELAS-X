<?php
include '../functions.php';

if (!isAdmin()) {
    header('Location: ../index.php');
    exit();
}

if (isset($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image = $_FILES['image']['name'];
    $target = "../assets/images/" . basename($image);

    // Update product
    if (!empty($image)) {
        // If a new image is uploaded, update the image
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
        $stmt = $pdo->prepare("UPDATE products SET name = ?, description = ?, price = ?, image = ? WHERE id = ?");
        $stmt->execute([$name, $description, $price, $image, $_GET['id']]);
    } else {
        // If no new image is uploaded, keep the old image
        $stmt = $pdo->prepare("UPDATE products SET name = ?, description = ?, price = ? WHERE id = ?");
        $stmt->execute([$name, $description, $price, $_GET['id']]);
    }

    echo "<script>alert('Product updated successfully!'); window.location.href='manage_products.php';</script>";
}

// Validasi file gambar
if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    if (in_array($_FILES['image']['type'], $allowedTypes)) {
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
        // Lanjutkan dengan update produk
    } else {
        echo "<script>alert('Invalid image type.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Edit Product</title>
</head>
<body class="bg-gray-100">
    <header class="bg-gray-800 text-white p-4">
        <div class="container mx-auto">
            <h1 class="text-2xl">Edit Product</h1>
        </div>
    </header>

    <main class="container mx-auto mt-10">
        <form method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow-md">
            <input type="text" name="name" value="<?php echo $product['name']; ?>" required class="border p-2 mb-4 w-full">
            <textarea name="description" required class="border p-2 mb-4 w-full"><?php echo $product['description']; ?></textarea>
            <input type="number" name="price" value="<?php echo $product['price']; ?>" required class="border p-2 mb-4 w-full">
            <img src="../assets/images/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" class="mb-4 w-32 h-32 object-cover">
            <input type="file" name="image" class="border p-2 mb-4 w-full">
            <button type="submit" class="bg-blue-500 text-white p-2 rounded">Update Product</button>
        </form>
    </main>
</body>
</html>
<script src="assets/js/script.js"></script>