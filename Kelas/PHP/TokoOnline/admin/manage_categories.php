<?php
include '../functions.php';

// Check admin authorization
if (!isAdmin()) {
    header('Location: ../index.php');
    exit();
}

// Handle category operations
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $category_id = $_POST['category_id'] ?? null;
    
    // Handle image upload
    $image = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $target_dir = "../assets/images/categories/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        $image = time() . '_' . basename($_FILES['image']['name']);
        $target_file = $target_dir . $image;
        
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            // Image uploaded successfully
            if ($category_id) {
                // Delete old image if updating
                $oldCategory = getCategoryById($category_id);
                if ($oldCategory && $oldCategory['image']) {
                    $old_file = $target_dir . $oldCategory['image'];
                    if (file_exists($old_file)) {
                        unlink($old_file);
                    }
                }
            }
        } else {
            $image = null;
        }
    }

    if ($category_id) {
        // Update existing category
        if (updateCategory($category_id, $name, $description, $image)) {
            header('Location: manage_categories.php?success=Category updated successfully');
            exit();
        }
    } else {
        // Add new category
        if (addCategory($name, $description, $image)) {
            header('Location: manage_categories.php?success=Category added successfully');
            exit();
        }
    }
    header('Location: manage_categories.php?error=Operation failed');
    exit();
}

// Get all categories
$categories = getCategories();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Categories</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
<nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <!-- Logo -->
                    <div class="flex-shrink-0 flex items-center">
                        <a href="index.php" class="text-xl font-bold text-gray-800">
                            <i class="fas fa-coffee mr-2"></i>
                            Coffee Shop Admin
                        </a>
                    </div>

                    <!-- Navigation Links -->
                    <div class="hidden md:ml-6 md:flex md:space-x-8">
                        <a href="index.php" class="border-b-2 border-blue-500 text-gray-900 inline-flex items-center px-1 pt-1 text-sm font-medium">
                            <i class="fas fa-chart-line mr-2"></i>
                            Dashboard
                        </a>
                        <a href="manage_products.php" class="border-b-2 border-transparent hover:border-gray-300 text-gray-500 hover:text-gray-700 inline-flex items-center px-1 pt-1 text-sm font-medium">
                            <i class="fas fa-box-open mr-2"></i>
                            Products
                        </a>
                        <a href="manage_categories.php" class="border-b-2 border-transparent hover:border-gray-300 text-gray-500 hover:text-gray-700 inline-flex items-center px-1 pt-1 text-sm font-medium">
                            <i class="fas fa-tags mr-2"></i>
                            Categories
                        </a>
                        <a href="manage_users.php" class="border-b-2 border-transparent hover:border-gray-300 text-gray-500 hover:text-gray-700 inline-flex items-center px-1 pt-1 text-sm font-medium">
                            <i class="fas fa-users mr-2"></i>
                            Users
                        </a>
                    </div>
                </div>

                <!-- User Menu -->
                <div class="flex items-center">
                    <div class="ml-3 relative">
                        <div class="flex items-center">
                            <span class="hidden md:block mr-3 text-gray-700">
                                Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>
                            </span>
                            <button type="button" class="bg-gray-800 flex text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white" id="user-menu-button">
                                <img class="h-8 w-8 rounded-full" src="<?php echo isset($_SESSION['profile_picture']) ? '../assets/images/profiles/' . $_SESSION['profile_picture'] : '../assets/images/default-avatar.png'; ?>" alt="">
                            </button>
                        </div>
                        <!-- Dropdown Menu -->
                        <div class="hidden origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5" id="user-menu">
                            <a href="profile.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-user mr-2"></i>
                                Profile
                            </a>
                            <a href="settings.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-cog mr-2"></i>
                                Settings
                            </a>
                            <a href="../logout.php" class="block px-4 py-2 text-sm text-red-700 hover:bg-gray-100">
                                <i class="fas fa-sign-out-alt mr-2"></i>
                                Logout
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8">
        <!-- ...existing dashboard content... -->
    </div>
    <div class="container mx-auto px-4 py-8">
        <!-- Messages -->
        <?php if (isset($_GET['success'])): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                <?php echo htmlspecialchars($_GET['success']); ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_GET['error'])): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                <?php echo htmlspecialchars($_GET['error']); ?>
            </div>
        <?php endif; ?>

        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Manage Categories</h1>
            <button onclick="openModal()" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                <i class="fas fa-plus mr-2"></i>Add Category
            </button>
        </div>

        <!-- Categories Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Products</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($categories as $category): ?>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <?php if ($category['image']): ?>
                                <img src="../assets/images/categories/<?php echo htmlspecialchars($category['image']); ?>" 
                                     alt="<?php echo htmlspecialchars($category['name']); ?>" 
                                     class="h-12 w-12 object-cover rounded">
                            <?php else: ?>
                                <div class="h-12 w-12 bg-gray-200 rounded flex items-center justify-center">
                                    <i class="fas fa-image text-gray-400"></i>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4"><?php echo htmlspecialchars($category['name']); ?></td>
                        <td class="px-6 py-4"><?php echo htmlspecialchars($category['description']); ?></td>
                        <td class="px-6 py-4">
                            <?php 
                            $productCount = countProductsInCategory($category['id']);
                            echo $productCount . ' product' . ($productCount != 1 ? 's' : '');
                            ?>
                        </td>
                        <td class="px-6 py-4 space-x-2">
                            <button onclick="editCategory(<?php echo htmlspecialchars(json_encode($category)); ?>)" 
                                    class="text-blue-600 hover:text-blue-900">
                                <i class="fas fa-edit"></i>
                            </button>
                            <?php if ($productCount == 0): ?>
                                <button onclick="confirmDelete(<?php echo $category['id']; ?>)"
                                        class="text-red-600 hover:text-red-900">
                                    <i class="fas fa-trash"></i>
                                </button>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div id="categoryModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900" id="modalTitle">Add Category</h3>
                <form id="categoryForm" method="POST" enctype="multipart/form-data" class="mt-4">
                    <input type="hidden" name="category_id" id="category_id">
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Name</label>
                        <input type="text" name="name" id="name" required
                               class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                        <textarea name="description" id="description" rows="3"
                                class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Image</label>
                        <input type="file" name="image" accept="image/*"
                               class="w-full px-3 py-2 border rounded">
                    </div>

                    <div class="flex justify-end space-x-4">
                        <button type="button" onclick="closeModal()"
                                class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">Cancel</button>
                        <button type="submit"
                                class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
    function openModal(isEdit = false) {
        document.getElementById('categoryModal').classList.remove('hidden');
        document.getElementById('modalTitle').innerText = isEdit ? 'Edit Category' : 'Add Category';
        if (!isEdit) {
            document.getElementById('categoryForm').reset();
            document.getElementById('category_id').value = '';
        }
    }

    function closeModal() {
        document.getElementById('categoryModal').classList.add('hidden');
        document.getElementById('categoryForm').reset();
    }

    function editCategory(category) {
        openModal(true);
        document.getElementById('category_id').value = category.id;
        document.getElementById('name').value = category.name;
        document.getElementById('description').value = category.description || '';
    }

    function confirmDelete(categoryId) {
        if (confirm('Are you sure you want to delete this category?')) {
            window.location.href = `delete_category.php?id=${categoryId}`;
        }
    }
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