<?php
include '../functions.php';

if (!isAdmin()) {
    header('Location: ../index.php');
    exit();
}

// Handle Edit Modal Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_product'])) {
    $productId = $_POST['product_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category_id = $_POST['category_id'];
    $stock = $_POST['stock'];
    
    // Handle image upload
    $image = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $image = time() . '_' . $_FILES['image']['name'];
        $target = "../assets/images/products/" . $image;
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
    }
    
    if (updateProduct($productId, $name, $description, $price, $category_id, $stock, $image)) {
        $success = "Product updated successfully!";
    } else {
        $error = "Failed to update product.";
    }
}

// Get products with filters
$search = isset($_GET['search']) ? $_GET['search'] : '';
$category = isset($_GET['category']) ? $_GET['category'] : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'name_asc';
$products = getFilteredProducts($search, $category, $sort);
$categories = getCategories();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <title>Manage Products - Coffee Shop Admin</title>
    <style>
        .modal {
            transition: opacity 0.25s ease;
        }
        body.modal-active {
            overflow-x: hidden;
            overflow-y: visible !important;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">
<?php include 'navbar.php'; ?>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8">
     
    

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        <!-- Filters and Search -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Search Input -->
                <div class="relative">
                    <input type="text" 
                           name="search" 
                           value="<?php echo htmlspecialchars($search); ?>"
                           placeholder="Search products..."
                           class="w-full pl-10 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-brown-500">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>

                <!-- Category Filter -->
                <div>
                    <select name="category" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-brown-500">
                        <option value="">All Categories</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?php echo $cat['id']; ?>" 
                                    <?php echo $category == $cat['id'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($cat['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Sort Options -->
                <div>
                    <select name="sort" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-brown-500">
                        <option value="name_asc" <?php echo $sort == 'name_asc' ? 'selected' : ''; ?>>Name (A-Z)</option>
                        <option value="name_desc" <?php echo $sort == 'name_desc' ? 'selected' : ''; ?>>Name (Z-A)</option>
                        <option value="price_asc" <?php echo $sort == 'price_asc' ? 'selected' : ''; ?>>Price (Low-High)</option>
                        <option value="price_desc" <?php echo $sort == 'price_desc' ? 'selected' : ''; ?>>Price (High-Low)</option>
                        <option value="stock_asc" <?php echo $sort == 'stock_asc' ? 'selected' : ''; ?>>Stock (Low-High)</option>
                        <option value="stock_desc" <?php echo $sort == 'stock_desc' ? 'selected' : ''; ?>>Stock (High-Low)</option>
                    </select>
                </div>

                <!-- Apply Button -->
                <button type="submit" 
                        class="bg-brown-500 hover:bg-brown-600 text-white px-6 py-2 rounded-lg transition-colors">
                    <i class="fas fa-filter mr-2"></i>
                    Apply Filters
                </button>
            </form>
        </div>

        <!-- Products Table -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($products as $product): ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <img class="h-10 w-10 rounded-lg object-cover" 
                                     src="../assets/images/products/<?php echo htmlspecialchars($product['image']); ?>" 
                                     alt="<?php echo htmlspecialchars($product['name']); ?>">
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        <?php echo htmlspecialchars($product['name']); ?>
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        <?php echo substr(htmlspecialchars($product['description']), 0, 50) . '...'; ?>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                <?php echo htmlspecialchars($product['category_name']); ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                Rp <?php echo number_format($product['price'], 0, ',', '.'); ?>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="<?php echo $product['stock'] > 0 ? 'text-green-600' : 'text-red-600'; ?> font-medium">
                                    <?php echo $product['stock']; ?>
                                </span>
                                <button onclick="quickUpdateStock(<?php echo $product['id']; ?>)"
                                        class="ml-2 text-gray-400 hover:text-gray-600">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <button onclick="toggleAvailability(<?php echo $product['id']; ?>)"
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                           <?php echo $product['is_available'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>">
                                <?php echo $product['is_available'] ? 'Available' : 'Unavailable'; ?>
                            </button>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                            <button onclick="editProduct(<?php echo htmlspecialchars(json_encode($product)); ?>)"
                                    class="text-blue-600 hover:text-blue-900">
                                <i class="fas fa-edit"></i>
                            </button>
                           
                            <button onclick="deleteProduct(<?php echo $product['id']; ?>)"
                                    class="text-red-600 hover:text-red-900">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>

    <!-- Edit Product Modal -->
    <div id="editProductModal" class="modal fixed w-full h-full top-0 left-0 flex items-center justify-center hidden">
        <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>
        
        <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">
            <!-- Modal Content -->
            <div class="modal-content py-4 text-left px-6">
                <!-- Title -->
                <div class="flex justify-between items-center pb-3">
                    <p class="text-2xl font-bold">Edit Product</p>
                    <div class="modal-close cursor-pointer z-50">
                        <i class="fas fa-times"></i>
                    </div>
                </div>

                <!-- Form -->
                <form id="editProductForm" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="edit_product" value="1">
                    <input type="hidden" name="product_id" id="edit_product_id">
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Product Name</label>
                        <input type="text" name="name" id="edit_name" required
                               class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                        <textarea name="description" id="edit_description" rows="3"
                                class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Price</label>
                        <input type="number" name="price" id="edit_price" required min="0"
                               class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Category</label>
                        <select name="category_id" id="edit_category_id" required
                                class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                            <?php foreach ($categories as $category): ?>
                                <option value="<?php echo $category['id']; ?>">
                                    <?php echo htmlspecialchars($category['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Stock</label>
                        <input type="number" name="stock" id="edit_stock" required min="0"
                               class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">New Image (optional)</label>
                        <input type="file" name="image" accept="image/*"
                               class="w-full px-3 py-2 border rounded-lg">
                    </div>

                    <div class="flex justify-end space-x-4">
                        <button type="button" 
                                class="modal-close px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
                            Cancel
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Modal functions
        function toggleModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.toggle('hidden');
            document.body.classList.toggle('modal-active');
        }

        // Edit product
        function editProduct(product) {
            document.getElementById('edit_product_id').value = product.id;
            document.getElementById('edit_name').value = product.name;
            document.getElementById('edit_description').value = product.description;
            document.getElementById('edit_price').value = product.price;
            document.getElementById('edit_category_id').value = product.category_id;
            document.getElementById('edit_stock').value = product.stock;
            toggleModal('editProductModal');
        }

        // Quick stock update
        function quickUpdateStock(productId) {
            const newStock = prompt('Enter new stock quantity:');
            if (newStock !== null) {
                window.location.href = `?update_stock=${productId}&stock=${newStock}`;
            }
        }

        // Toggle availability
        function toggleAvailability(productId) {
            if (confirm('Are you sure you want to toggle this product\'s availability?')) {
                window.location.href = `?toggle_availability=${productId}`;
            }
        }

        // Delete product
        function deleteProduct(productId) {
            if (confirm('Are you sure you want to delete this product?')) {
                window.location.href = `?delete=${productId}`;
            }
        }

        // Close modal handlers
        document.querySelectorAll('.modal-close').forEach(button => {
            button.addEventListener('click', () => {
                document.querySelectorAll('.modal').forEach(modal => {
                    modal.classList.add('hidden');
                });
                document.body.classList.remove('modal-active');
            });
        });
    </script>
     <script>
        // Toggle User Menu
        const userMenuButton = document.getElementById('user-menu-button');
        const userMenu = document.getElementById('user-menu');

        userMenuButton.addEventListener('click', () => {
            userMenu.classList.toggle('hidden');
        });

        // Close menu when clicking outside
        document.addEventListener('click', (event) => {
            if (!userMenuButton.contains(event.target) && !userMenu.contains(event.target)) {
                userMenu.classList.add('hidden');
            }
        });
    </script>
</body>
</html>