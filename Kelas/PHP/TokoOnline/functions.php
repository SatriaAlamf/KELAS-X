<?php
session_start();
include 'db.php';

function searchProducts($searchTerm) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM products WHERE name LIKE ? ORDER BY name");
    $stmt->execute(['%' . $searchTerm . '%']);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function isAdmin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}



function addToCart($productId, $quantity) {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    if (isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId] += $quantity;
    } else {
        $_SESSION['cart'][$productId] = $quantity;
    }
}

// function register($username, $password, $role = 'user') {
//     global $pdo;
//     $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
//     $stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
//     return $stmt->execute([$username, $hashedPassword, $role]);
// }

// function login($username, $password) {
//     global $pdo;
//     $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
//     $stmt->execute([$username]);
//     $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
//     if ($user && password_verify($password, $user['password'])) {
//         $_SESSION['user_id'] = $user['id'];
//         $_SESSION['role'] = $user['role']; // Pastikan ini di-set dengan benar
//         return true;
//     }
//     return false;
// }

function getCartItems() {
    global $pdo;
    $items = [];
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $productId => $quantity) {
            $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
            $stmt->execute([$productId]);
            $product = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($product) {
                $product['quantity'] = $quantity;
                $items[] = $product;
            }
        }
    }
    return $items;
}
// Add these functions after the existing code

function getCategories() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM product_categories WHERE is_active = 1 ORDER BY name");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function addCategory($name, $description, $image = null) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO product_categories (name, description, image) VALUES (?, ?, ?)");
    return $stmt->execute([$name, $description, $image]);
}

function getProductsByCategory($categoryId) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM products WHERE category_id = ? AND is_available = 1");
    $stmt->execute([$categoryId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Modify the existing getProducts function
function getProducts() {
    global $pdo;
    $stmt = $pdo->query("SELECT p.*, c.name as category_name 
                         FROM products p 
                         LEFT JOIN product_categories c ON p.category_id = c.id 
                         WHERE p.is_available = 1");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
// Add this to your existing functions.php
function register($username, $password, $email, $full_name, $profile_picture = null) {
    global $pdo;
    
    try {
        // Check if username already exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$username]);
        if ($stmt->rowCount() > 0) {
            return false;
        }

        // Check if email already exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->rowCount() > 0) {
            return false;
        }
        
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        $stmt = $pdo->prepare("INSERT INTO users (username, password, email, full_name, profile_picture, role, status) 
                              VALUES (?, ?, ?, ?, ?, 'user', 'active')");
        
        return $stmt->execute([
            $username,
            $hashedPassword,
            $email,
            $full_name,
            $profile_picture
        ]);
    } catch (PDOException $e) {
        error_log($e->getMessage());
        return false;
    }
}

function login($username, $password) {
    global $pdo;
    
    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE (username = ? OR email = ?) AND status = 'active'");
        $stmt->execute([$username, $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['full_name'] = $user['full_name'];
            $_SESSION['profile_picture'] = $user['profile_picture'];
            return true;
        }
        return false;
    } catch (PDOException $e) {
        error_log($e->getMessage());
        return false;
    }
}

function getUserById($userId) {
    global $pdo;
    
    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log($e->getMessage());
        return false;
    }
}

function updateUserProfile($userId, $data) {
    global $pdo;
    
    try {
        $fields = [];
        $values = [];
        
        foreach ($data as $key => $value) {
            if ($key !== 'id') {
                $fields[] = "$key = ?";
                $values[] = $value;
            }
        }
        
        $values[] = $userId;
        
        $sql = "UPDATE users SET " . implode(', ', $fields) . " WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        
        return $stmt->execute($values);
    } catch (PDOException $e) {
        error_log($e->getMessage());
        return false;
    }
}

function getAllUsers() {
    global $pdo;
    
    try {
        $stmt = $pdo->query("SELECT * FROM users ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log($e->getMessage());
        return [];
    }
}

function updateUserStatus($userId, $status) {
    global $pdo;
    
    try {
        $stmt = $pdo->prepare("UPDATE users SET status = ? WHERE id = ?");
        return $stmt->execute([$status, $userId]);
    } catch (PDOException $e) {
        error_log($e->getMessage());
        return false;
    }
}

// Add these helper functions to functions.php

function getRoleColor($role) {
    switch ($role) {
        case 'super_admin':
            return 'bg-red-100 text-red-800';
        case 'admin':
            return 'bg-purple-100 text-purple-800';
        case 'staff':
            return 'bg-green-100 text-green-800';
        default:
            return 'bg-blue-100 text-blue-800';
    }
}

function getStatusColor($status) {
    switch ($status) {
        case 'active':
            return 'bg-green-100 text-green-800';
        case 'inactive':
            return 'bg-yellow-100 text-yellow-800';
        case 'banned':
            return 'bg-red-100 text-red-800';
        default:
            return 'bg-gray-100 text-gray-800';
    }
}

function updateUserRole($userId, $role) {
    global $pdo;
    
    try {
        $stmt = $pdo->prepare("UPDATE users SET role = ? WHERE id = ?");
        return $stmt->execute([$role, $userId]);
    } catch (PDOException $e) {
        error_log($e->getMessage());
        return false;
    }
}
function getFilteredProducts($search = '', $category = '', $sort = 'name_asc') {
    global $pdo;
    
    $sql = "SELECT p.*, pc.name as category_name 
            FROM products p 
            LEFT JOIN product_categories pc ON p.category_id = pc.id 
            WHERE 1=1";
    $params = [];
    
    if ($search) {
        $sql .= " AND (p.name LIKE ? OR p.description LIKE ?)";
        $params[] = "%$search%";
        $params[] = "%$search%";
    }
    
    if ($category) {
        $sql .= " AND p.category_id = ?";
        $params[] = $category;
    }
    
    // Add sorting
    switch ($sort) {
        case 'name_desc':
            $sql .= " ORDER BY p.name DESC";
            break;
        case 'price_asc':
            $sql .= " ORDER BY p.price ASC";
            break;
        case 'price_desc':
            $sql .= " ORDER BY p.price DESC";
            break;
        case 'stock_asc':
            $sql .= " ORDER BY p.stock ASC";
            break;
        case 'stock_desc': 
            $sql .= " ORDER BY p.stock DESC";
            break;
        default:
            $sql .= " ORDER BY p.name ASC";
    }
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



function toggleProductAvailability($productId) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE products SET is_available = NOT is_available WHERE id = ?");
    return $stmt->execute([$productId]);
}
function updateProduct($productId, $name, $description, $price, $categoryId, $stock, $image = null) {
    global $pdo;
    
    try {
        if ($image) {
            $sql = "UPDATE products SET name = ?, description = ?, price = ?, category_id = ?, stock = ?, image = ? WHERE id = ?";
            $params = [$name, $description, $price, $categoryId, $stock, $image, $productId];
        } else {
            $sql = "UPDATE products SET name = ?, description = ?, price = ?, category_id = ?, stock = ? WHERE id = ?";
            $params = [$name, $description, $price, $categoryId, $stock, $productId];
        }
        
        $stmt = $pdo->prepare($sql);
        return $stmt->execute($params);
    } catch (PDOException $e) {
        error_log($e->getMessage());
        return false;
    }
}
function countProductsInCategory($categoryId) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM products WHERE category_id = ?");
    $stmt->execute([$categoryId]);
    return $stmt->fetchColumn();
}


function toggleCategoryStatus($categoryId) {
    global $pdo;
    
    try {
        $stmt = $pdo->prepare("UPDATE product_categories SET is_active = NOT is_active WHERE id = ?");
        return $stmt->execute([$categoryId]);
    } catch (PDOException $e) {
        error_log($e->getMessage());
        return false;
    }
}

function deleteCategory($categoryId) {
    global $pdo;
    
    try {
        // First check if there are any products in this category
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM products WHERE category_id = ?");
        $stmt->execute([$categoryId]);
        if ($stmt->fetchColumn() > 0) {
            return false; // Cannot delete category with products
        }
        
        $stmt = $pdo->prepare("DELETE FROM product_categories WHERE id = ?");
        return $stmt->execute([$categoryId]);
    } catch (PDOException $e) {
        error_log($e->getMessage());
        return false;
    }
}

// Add these functions to your existing functions.php file

function getAllCategories() {
    global $conn;
    $sql = "SELECT * FROM categories ORDER BY name " ;
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function getCategoryById($id) {
    global $conn;
    $id = mysqli_real_escape_string($conn, $id);
    $sql = "SELECT * FROM categories WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result);
}

function updateCategory($id, $name, $description, $image) {
    global $conn;
    $id = mysqli_real_escape_string($conn, $id);
    $name = mysqli_real_escape_string($conn, $name);
    $description = mysqli_real_escape_string($conn, $description);
    $image = mysqli_real_escape_string($conn, $image);
    
    $sql = "UPDATE categories SET name='$name', description='$description', image='$image' WHERE id='$id'";
    return mysqli_query($conn, $sql);
}

// Replace the existing counting functions with these PDO versions
function getTotalProducts() {
    global $pdo;
    try {
        $stmt = $pdo->query("SELECT COUNT(*) FROM products");
        return $stmt->fetchColumn();
    } catch (PDOException $e) {
        error_log($e->getMessage());
        return 0;
    }
}

function getTotalUsers() {
    global $pdo;
    try {
        $stmt = $pdo->query("SELECT COUNT(*) FROM users");
        return $stmt->fetchColumn();
    } catch (PDOException $e) {
        error_log($e->getMessage());
        return 0;
    }
}

function getTotalCategories() {
    global $pdo;
    try {
        $stmt = $pdo->query("SELECT COUNT(*) FROM product_categories");
        return $stmt->fetchColumn();
    } catch (PDOException $e) {
        error_log($e->getMessage());
        return 0;
    }
}

function getLatestProducts($limit = 5) {
    global $pdo;
    
   
    try {
        $stmt = $pdo->prepare("SELECT p.*, c.name as category_name 
                              FROM products p 
                              LEFT JOIN product_categories c ON p.category_id = c.id 
                              ORDER BY p.created_at DESC 
                              LIMIT :limit");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log($e->getMessage());
        return [];
    }
}

function getLatestUsers($limit = 5) {
    global $pdo;
    try {
        $stmt = $pdo->prepare("SELECT id, full_name, email, created_at 
                              FROM users 
                              ORDER BY created_at DESC 
                              LIMIT :limit");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log($e->getMessage());
        return [];
    }
}


function getOrderDetails($orderId) {
    global $pdo;
    try {
        $stmt = $pdo->prepare("
            SELECT 
                order_items.*,
                products.name as product_name,
                products.price,
                products.image
            FROM order_items 
            JOIN products ON order_items.product_id = products.id
            WHERE order_items.order_id = ?
        ");
        $stmt->execute([$orderId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log($e->getMessage());
        return [];
    }
}

function updateOrderStatus($orderId, $status) {
    global $pdo;
    try {
        $stmt = $pdo->prepare("UPDATE orders SET status = ? WHERE id = ?");
        return $stmt->execute([$status, $orderId]);
    } catch (PDOException $e) {
        error_log($e->getMessage());
        return false;
    }
}

function updateProductStock($productId, $quantity) {
    global $pdo;
    try {
        $stmt = $pdo->prepare("
            UPDATE products 
            SET stock = stock - ? 
            WHERE id = ? AND stock >= ?
        ");
        return $stmt->execute([$quantity, $productId, $quantity]);
    } catch (PDOException $e) {
        error_log($e->getMessage());
        return false;
    }
}
// Add after existing functions
function calculateOrderTotal($orderId) {
    global $pdo;
    try {
        $stmt = $pdo->prepare("
            SELECT SUM(oi.quantity * p.price) as total
            FROM order_items oi
            JOIN products p ON oi.product_id = p.id
            WHERE oi.order_id = ?
        ");
        $stmt->execute([$orderId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    } catch (PDOException $e) {
        error_log($e->getMessage());
        return 0;
    }
}

// Modify the getAllOrders function to include total amount
function getAllOrders() {
    global $pdo;
    try {
        $stmt = $pdo->prepare("
            SELECT 
                o.*,
                u.username,
                u.full_name,
                (SELECT SUM(oi.quantity * p.price) 
                 FROM order_items oi 
                 JOIN products p ON oi.product_id = p.id 
                 WHERE oi.order_id = o.id) as total_amount
            FROM orders o
            JOIN users u ON o.user_id = u.id 
            ORDER BY o.created_at DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log($e->getMessage());
        return [];
    }
}

// Add function to create order
function createOrder($userId, $items) {
    global $pdo;
    try {
        $pdo->beginTransaction();

        // Create order
        $stmt = $pdo->prepare("
            INSERT INTO orders (user_id, status, created_at) 
            VALUES (?, 'pending', NOW())
        ");
        $stmt->execute([$userId]);
        $orderId = $pdo->lastInsertId();

        // Insert order items
        $stmt = $pdo->prepare("
            INSERT INTO order_items (order_id, product_id, quantity) 
            VALUES (?, ?, ?)
        ");

        foreach ($items as $item) {
            $stmt->execute([
                $orderId,
                $item['product_id'],
                $item['quantity']
            ]);
        }

        // Calculate and update total amount
        $totalAmount = calculateOrderTotal($orderId);
        $stmt = $pdo->prepare("
            UPDATE orders 
            SET total_amount = ? 
            WHERE id = ?
        ");
        $stmt->execute([$totalAmount, $orderId]);

        $pdo->commit();
        return $orderId;
    } catch (PDOException $e) {
        $pdo->rollBack();
        error_log($e->getMessage());
        return false;
    }
}
?>