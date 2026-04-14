<?php
include './views/components/admin_navbar.php';
?>

<div class="flex pt-16">
    <?php include './views/admin/admin_sidebar.php'; ?>

    <div class="w-4/5 p-8">
        <h1 class="text-3xl font-bold mb-8">Quản lý đơn hàng</h1>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <div class="bg-white rounded-lg shadow overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-100 border-b">
                        <th class="px-6 py-3 text-left text-sm font-semibold">ID</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Khách hàng</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Email</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Tổng tiền</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Trạng thái</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Ngày đặt</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm font-semibold">#<?php echo $order['id']; ?></td>
                            <td class="px-6 py-4 text-sm"><?php echo $order['user_name']; ?></td>
                            <td class="px-6 py-4 text-sm text-gray-600"><?php echo $order['user_email']; ?></td>
                            <td class="px-6 py-4 text-sm font-semibold">₫<?php echo number_format($order['total_price'], 0); ?></td>
                            <td class="px-6 py-4 text-sm">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                    <?php 
                                        if ($order['status'] === 'chờ xác nhận') {
                                            echo 'bg-yellow-100 text-yellow-700';
                                        } elseif ($order['status'] === 'đã xác nhận') {
                                            echo 'bg-blue-100 text-blue-700';
                                        } elseif ($order['status'] === 'đang giao') {
                                            echo 'bg-purple-100 text-purple-700';
                                        } elseif ($order['status'] === 'đã giao') {
                                            echo 'bg-green-100 text-green-700';
                                        } elseif ($order['status'] === 'đã hủy') {
                                            echo 'bg-red-100 text-red-700';
                                        }
                                    ?>">
                                    <?php 
                                        $status_map = [
                                            'chờ xác nhận' => 'Chờ xác nhận',
                                            'đã xác nhận' => 'Đã xác nhận',
                                            'đang giao' => 'Đang giao',
                                            'đã giao' => 'Đã giao',
                                            'đã hủy' => 'Đã hủy'
                                        ];
                                        echo $status_map[$order['status']] ?? $order['status'];
                                    ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm"><?php echo date('d/m/Y H:i', strtotime($order['created_at'])); ?></td>
                            <td class="px-6 py-4 text-sm flex gap-2">
                                <a href="<?php echo BASE_URL; ?>?act=admin_order_show&id=<?php echo $order['id']; ?>" 
                                   class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs transition">
                                    Xem
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
