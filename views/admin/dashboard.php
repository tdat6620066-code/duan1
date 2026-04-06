<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - ShoeStore</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="public/css/style.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <!-- Admin Navbar -->
    <nav class="bg-gray-900 text-white shadow-lg fixed top-0 w-full z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex-shrink-0">
                    <a href="?act=admin" class="text-2xl font-bold">
                        ShoeStore Admin
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <span><?= $_SESSION['user']['name'] ?></span>
                    <a href="?act=logout" class="bg-red-600 px-4 py-2 rounded hover:bg-red-700 transition-colors">
                        Đăng xuất
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="flex pt-16">
        <!-- Sidebar -->
        <div class="w-64 bg-gray-800 text-white min-h-screen shadow-lg">
            <div class="p-6 space-y-6">
                <div>
                    <h3 class="text-xs font-semibold uppercase text-gray-400 mb-3">Menu chính</h3>
                    <ul class="space-y-2">
                        <li>
                            <a href="?act=admin" class="block px-4 py-2 rounded hover:bg-gray-700 transition-colors">
                                📊 Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo BASE_URL; ?>" class="block px-4 py-2 rounded hover:bg-gray-700 transition-colors">
                                🏠 Trang chủ
                            </a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-xs font-semibold uppercase text-gray-400 mb-3">Quản lý</h3>
                    <ul class="space-y-2">
                        <li>
                            <a href="?act=admin_products" class="block px-4 py-2 rounded hover:bg-gray-700 transition-colors">
                                👟 Sản phẩm
                            </a>
                        </li>
                        <li>
                            <a href="?act=admin_categories" class="block px-4 py-2 rounded hover:bg-gray-700 transition-colors">
                                🏷️ Danh mục
                            </a>
                        </li>
                        <li>
                            <a href="?act=admin_users" class="block px-4 py-2 rounded hover:bg-gray-700 transition-colors">
                                👥 Người dùng
                            </a>
                        </li>
                        <li>
                            <a href="?act=admin_orders" class="block px-4 py-2 rounded hover:bg-gray-700 transition-colors">
                                📦 Đơn hàng
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-8">Dashboard</h1>

            <!-- Statistics Grid -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="text-gray-500 text-sm font-medium mb-2">Tổng doanh thu</div>
                    <div class="text-3xl font-bold text-gray-900">
                        <?= number_format($stats['total_revenue'], 0, ',', '.') ?>đ
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="text-gray-500 text-sm font-medium mb-2">Tổng đơn hàng</div>
                    <div class="text-3xl font-bold text-gray-900"><?= $stats['total_orders'] ?></div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="text-gray-500 text-sm font-medium mb-2">Sản phẩm</div>
                    <div class="text-3xl font-bold text-gray-900"><?= $stats['total_products'] ?></div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="text-gray-500 text-sm font-medium mb-2">Người dùng</div>
                    <div class="text-3xl font-bold text-gray-900"><?= $stats['total_users'] ?></div>
                </div>
            </div>

            <!-- Top Selling Products -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Sản phẩm bán chạy</h2>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b">
                            <tr>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-900">Sản phẩm</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-900">Số lượng bán</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-900">Doanh thu</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            <?php foreach ($stats['top_products'] as $product): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-sm text-gray-900"><?= $product['name'] ?></td>
                                <td class="px-4 py-3 text-sm text-gray-600"><?= $product['quantity_sold'] ?? 0 ?></td>
                                <td class="px-4 py-3 text-sm text-gray-900 font-semibold">
                                    <?= number_format($product['revenue'] ?? 0, 0, ',', '.') ?>đ
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                        </table>
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Đơn hàng gần đây</h2>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b">
                            <tr>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-900">Đơn hàng</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-900">Khách hàng</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-900">Trạng thái</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-900">Tổng tiền</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-900">Ngày đặt</th>
                            </tr>
                            </thead>
                        <tbody class="divide-y">
                            <?php foreach ($stats['recent_orders'] as $order): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-sm text-gray-900">#<?= $order['id'] ?></td>
                                <td class="px-4 py-3 text-sm text-gray-600"><?= $order['user_name'] ?></td>
                                <td class="px-4 py-3 text-sm">
                                    <span class="px-3 py-1 text-xs rounded-full font-medium
                                        <?php 
                                        switch($order['status']) {
                                            case 'chờ xác nhận': echo 'bg-yellow-100 text-yellow-800'; break;
                                            case 'đã xác nhận': echo 'bg-blue-100 text-blue-800'; break;
                                            case 'đang giao': echo 'bg-orange-100 text-orange-800'; break;
                                            case 'đã giao': echo 'bg-green-100 text-green-800'; break;
                                            case 'đã hủy': echo 'bg-red-100 text-red-800'; break;
                                        }
                                        ?>">
                                        <?= $order['status'] ?>
                                    </span>
                                    </td>
                                <td class="px-4 py-3 text-sm text-gray-900 font-semibold">
                                    <?= number_format($order['total_price'], 0, ',', '.') ?>đ
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600">
                                    <?= date('d/m/Y', strtotime($order['created_at'])) ?>
                                </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="public/js/script.js"></script>
</body>
</html>