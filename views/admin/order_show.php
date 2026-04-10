<?php
include './views/components/admin_navbar.php';
?>

<div class="flex pt-16">
    <div class="w-1/5 bg-gray-900 text-white p-6 min-h-screen">
        <div class="mb-12">
            <h2 class="text-sm font-semibold text-gray-400 mb-6">MENU CHÍNH</h2>
            <a href="<?php echo BASE_URL; ?>?act=admin" class="flex items-center gap-3 px-4 py-3 rounded hover:bg-gray-800 transition">
                <i class="fas fa-chart-line"></i> Dashboard
            </a>
            <a href="<?php echo BASE_URL; ?>" class="flex items-center gap-3 px-4 py-3 rounded hover:bg-gray-800 transition">
                <i class="fas fa-home"></i> Trang chủ
            </a>
        </div>

        <div>
            <h2 class="text-sm font-semibold text-gray-400 mb-6">QUẢN LÝ</h2>
            <a href="<?php echo BASE_URL; ?>?act=admin_products" class="flex items-center gap-3 px-4 py-3 rounded hover:bg-gray-800 transition">
                <i class="fas fa-box"></i> Sản phẩm
            </a>
            <a href="<?php echo BASE_URL; ?>?act=admin_categories" class="flex items-center gap-3 px-4 py-3 rounded hover:bg-gray-800 transition">
                <i class="fas fa-tag"></i> Danh mục
            </a>
            <a href="<?php echo BASE_URL; ?>?act=admin_users" class="flex items-center gap-3 px-4 py-3 rounded hover:bg-gray-800 transition">
                <i class="fas fa-users"></i> Người dùng
            </a>
            <a href="<?php echo BASE_URL; ?>?act=admin_orders" class="flex items-center gap-3 px-4 py-3 rounded bg-blue-600">
                <i class="fas fa-shopping-cart"></i> Đơn hàng
            </a>
        </div>
    </div>

    <div class="w-4/5 p-8">
        <div class="mb-8">
            <a href="<?php echo BASE_URL; ?>?act=admin_orders" class="text-blue-600 hover:text-blue-800 flex items-center gap-2">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>

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

        <div class="space-y-6">
            <!-- Order Header -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h1 class="text-3xl font-bold mb-2">Đơn hàng #<?php echo $order['id']; ?></h1>
                        <p class="text-gray-600">Ngày đặt: <?php echo date('d/m/Y H:i', strtotime($order['created_at'])); ?></p>
                    </div>
                    <span class="px-4 py-2 rounded-full text-sm font-semibold
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
                </div>

                <!-- Update Status Form -->
                <form method="POST" action="<?php echo BASE_URL; ?>?act=admin_order_update_status" class="mb-4">
                    <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                    <div class="flex gap-3 items-end">
                        <div class="flex-1">
                            <label class="block text-sm font-semibold mb-2">Cập nhật trạng thái</label>
                            <select name="status" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                                <option value="chờ xác nhận" <?php echo $order['status'] === 'chờ xác nhận' ? 'selected' : ''; ?>>Chờ xác nhận</option>
                                <option value="đã xác nhận" <?php echo $order['status'] === 'đã xác nhận' ? 'selected' : ''; ?>>Đã xác nhận</option>
                                <option value="đang giao" <?php echo $order['status'] === 'đang giao' ? 'selected' : ''; ?>>Đang giao</option>
                                <option value="đã giao" <?php echo $order['status'] === 'đã giao' ? 'selected' : ''; ?>>Đã giao</option>
                                <option value="đã hủy" <?php echo $order['status'] === 'đã hủy' ? 'selected' : ''; ?>>Đã hủy</option>
                            </select>
                        </div>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition">
                            Cập nhật
                        </button>
                    </div>
                </form>
            </div>

            <!-- Customer Info -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold mb-4">Thông tin khách hàng</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm text-gray-600">Tên</label>
                        <p class="text-lg font-semibold"><?php echo $order['user_name']; ?></p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-600">Email</label>
                        <p class="text-lg font-semibold"><?php echo $order['user_email']; ?></p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-600">Điện thoại</label>
                        <p class="text-lg font-semibold"><?php echo $order['user_phone'] ?? 'N/A'; ?></p>
                    </div>
                </div>
            </div>

            <!-- Shipping Address -->
            <?php if ($shipping_address): ?>
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold mb-4">Địa chỉ giao hàng</h2>
                <div class="space-y-2">
                    <p><strong>Địa chỉ:</strong> <?php echo $shipping_address['address']; ?></p>
                    <p><strong>Thành phố:</strong> <?php echo $shipping_address['city']; ?></p>
                </div>
            </div>
            <?php endif; ?>

            <!-- Order Items -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold mb-4">Chi tiết đơn hàng</h2>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-100 border-b">
                                <th class="px-4 py-3 text-left text-sm font-semibold">Sản phẩm</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold">Size</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold">Số lượng</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold">Giá</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold">Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($order_items as $item): ?>
                            <tr class="border-b">
                                <td class="px-4 py-3 text-sm"><?php echo $item['product_name']; ?></td>
                                <td class="px-4 py-3 text-sm"><?php echo $item['size']; ?></td>
                                <td class="px-4 py-3 text-sm text-center"><?php echo $item['quantity']; ?></td>
                                <td class="px-4 py-3 text-sm">₫<?php echo number_format($item['price'], 0); ?></td>
                                <td class="px-4 py-3 text-sm font-semibold">₫<?php echo number_format($item['price'] * $item['quantity'], 0); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold mb-4">Tóm tắt</h2>
                <div class="space-y-3 border-t pt-4">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Tạm tính:</span>
                        <span class="font-semibold">₫<?php echo number_format($order['total_price'] - 30000, 0); ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Vận chuyển:</span>
                        <span class="font-semibold">₫30.000</span>
                    </div>
                    <div class="flex justify-between text-lg border-t pt-4 font-bold">
                        <span>Tổng cộng:</span>
                        <span class="text-blue-600">₫<?php echo number_format($order['total_price'], 0); ?></span>
                    </div>
                </div>
            </div>

            <!-- Payment Info -->
            <?php if ($payment): ?>
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold mb-4">Thanh toán</h2>
                <div class="space-y-2">
                    <p><strong>Phương thức:</strong> <?php echo ucfirst($payment['method']); ?></p>
                    <p><strong>Trạng thái:</strong> 
                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                            <?php echo $payment['status'] === 'completed' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700'; ?>">
                            <?php echo $payment['status'] === 'completed' ? 'Đã thanh toán' : 'Chưa thanh toán'; ?>
                        </span>
                    </p>
                    <p><strong>Ngày thanh toán:</strong> <?php echo !empty($payment['paid_at']) ? date('d/m/Y H:i', strtotime($payment['paid_at'])) : 'N/A'; ?></p>
                </div>
            </div>
            <?php endif; ?>

            <!-- Delete Button -->
            <div class="flex justify-end">
                <a href="<?php echo BASE_URL; ?>?act=admin_order_delete&id=<?php echo $order['id']; ?>" 
                   onclick="return confirm('Bạn chắc chắn muốn xóa đơn hàng này?')"
                   class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg transition">
                    Xóa đơn hàng
                </a>
            </div>
        </div>
    </div>
</div>