<?php
include '../functions.php';

if (!isAdmin() || !isset($_GET['order_id'])) {
    exit('Unauthorized');
}

$orderId = $_GET['order_id'];
$orderItems = getOrderDetails($orderId);

if (empty($orderItems)) {
    echo '<p class="text-gray-500">No items found for this order.</p>';
    exit;
}
?>

<div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Quantity</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Subtotal</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            <?php foreach ($orderItems as $item): ?>
            <tr>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                        <img src="../assets/images/products/<?php echo htmlspecialchars($item['image']); ?>" 
                             alt="<?php echo htmlspecialchars($item['product_name']); ?>"
                             class="w-10 h-10 rounded object-cover">
                        <span class="ml-3"><?php echo htmlspecialchars($item['product_name']); ?></span>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    Rp <?php echo number_format($item['price'], 0, ',', '.'); ?>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <?php echo $item['quantity']; ?>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    Rp <?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>