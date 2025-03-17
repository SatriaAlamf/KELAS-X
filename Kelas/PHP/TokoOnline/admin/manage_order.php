<?php
include '../functions.php';

if (!isAdmin()) {
    header('Location: ../index.php');
    exit();
}

// Handle order status updates
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['order_id']) && isset($_POST['status'])) {
    $orderId = $_POST['order_id'];
    $status = $_POST['status'];
    
    if ($status === 'processing') {
        // Get order details
        $orderItems = getOrderDetails($orderId);
        
        // Update stock for each item
        $stockUpdateSuccess = true;
        foreach ($orderItems as $item) {
            if (!updateProductStock($item['product_id'], $item['quantity'])) {
                $stockUpdateSuccess = false;
                break;
            }
        }
        
        if ($stockUpdateSuccess) {
            updateOrderStatus($orderId, $status);
            $successMessage = "Order status and stock updated successfully";
        } else {
            $errorMessage = "Failed to update stock. Please check product availability.";
        }
    } else {
        if (updateOrderStatus($orderId, $status)) {
            $successMessage = "Order status updated successfully";
        } else {
            $errorMessage = "Failed to update order status";
        }
    }
}

$orders = getAllOrders();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders - Admin Dashboard</title>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <?php include 'navbar.php'; ?>

    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-2xl font-bold mb-6">Manage Orders</h2>

            <?php if (isset($successMessage)): ?>
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">
                <?php echo $successMessage; ?>
            </div>
            <?php endif; ?>

            <?php if (isset($errorMessage)): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">
                <?php echo $errorMessage; ?>
            </div>
            <?php endif; ?>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Order ID
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Customer
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Total Amount
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Date
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($orders as $order): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                #<?php echo $order['id']; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    <?php echo htmlspecialchars($order['full_name']); ?>
                                </div>
                                <div class="text-sm text-gray-500">
                                    <?php echo htmlspecialchars($order['username']); ?>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                Rp <?php echo number_format($order['total_amount'], 0, ',', '.'); ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    <?php
                                    switch ($order['status']) {
                                        case 'pending':
                                            echo 'bg-yellow-100 text-yellow-800';
                                            break;
                                        case 'processing':
                                            echo 'bg-blue-100 text-blue-800';
                                            break;
                                        case 'completed':
                                            echo 'bg-green-100 text-green-800';
                                            break;
                                        case 'cancelled':
                                            echo 'bg-red-100 text-red-800';
                                            break;
                                    }
                                    ?>">
                                    <?php echo ucfirst($order['status']); ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php echo date('d M Y H:i', strtotime($order['created_at'])); ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button onclick="showOrderDetails(<?php echo $order['id']; ?>)" 
                                        class="text-blue-600 hover:text-blue-900 mr-3">
                                    <i class="fas fa-eye"></i> View
                                </button>
                                <?php if ($order['status'] === 'pending'): ?>
                                <form method="POST" class="inline">
                                    <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                                    <input type="hidden" name="status" value="processing">
                                    <button type="submit" class="text-green-600 hover:text-green-900"
                                            onclick="return confirm('This will update stock levels. Continue?')">
                                        <i class="fas fa-check"></i> Process
                                    </button>
                                </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Order Details Modal -->
    <div id="orderDetailsModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Order Details</h3>
                <div id="orderDetailsContent">
                    <!-- Content will be loaded here -->
                </div>
                <div class="mt-4">
                    <button onclick="closeOrderDetails()" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showOrderDetails(orderId) {
            fetch(`get_order_details.php?order_id=${orderId}`)
                .then(response => response.text())
                .then(html => {
                    document.getElementById('orderDetailsContent').innerHTML = html;
                    document.getElementById('orderDetailsModal').classList.remove('hidden');
                });
        }

        function closeOrderDetails() {
            document.getElementById('orderDetailsModal').classList.add('hidden');
        }
    </script>
</body>
</html>