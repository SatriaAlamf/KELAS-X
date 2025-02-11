<?php
include '../functions.php';

if (!isAdmin()) {
    header('Location: ../index.php');
    exit();
}

$products = getProducts();

if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$_GET['delete']]);
    header('Location: manage_products.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Manage Products</title>
</head>
<body class="bg-gray-100">
    <header class="bg-gray-800 text-white p-4">
        <div class="container mx-auto">
            <h1 class="text-2xl">Manage Products</h1>
        </div>
    </header>

    <main class="container mx-auto mt-10">
        <table class="min-w-full bg-white border border-gray-300">
            <thead>
                <tr>
                    <th class="border px-4 py-2">Product Name</th>
                    <th class="border px-4 py-2">Price</th>
                    <th class="border px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td class="border px-4 py-2"><?php echo $product['name']; ?></td>
                        <td class="border px-4 py-2">Rp <?php echo number_format($product['price'], 2, ',', '.'); ?></td>
                        <td class="border px-4 py-2">
                            <a href="edit_product.php?id=<?php echo $product['id']; ?>" class="text-blue-500">Edit</a>
                            <a href="?delete=<?php echo $product['id']; ?>" class="text-red-500 ml-4">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="add_product.php" class="mt-4 inline-block bg-blue-500 text-white p-2 rounded">Add New Product</a>
    </main>
</body>
</html>