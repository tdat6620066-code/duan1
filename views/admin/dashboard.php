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
        <?php include './views/admin/admin_sidebar.php'; ?>

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

            <!-- Charts Row -->
            <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mb-8">
                <div class="bg-white rounded-3xl shadow-lg p-6 border border-gray-100">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">Doanh thu tuần</h2>
                            <p class="text-sm text-gray-500">Tổng doanh thu trong 7 ngày gần nhất</p>
                        </div>
                        <div class="text-right">
                            <div class="text-2xl font-semibold text-gray-900"><?= number_format($stats['total_revenue'], 0, ',', '.') ?>đ</div>
                            <div class="text-sm text-gray-500">Tổng doanh thu</div>
                        </div>
                    </div>
                    <div class="h-72">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>

                <div class="bg-white rounded-3xl shadow-lg p-6 border border-gray-100">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">Trạng thái đơn hàng</h2>
                            <p class="text-sm text-gray-500">Số lượng đơn hàng theo trạng thái hiện tại</p>
                        </div>
                        <div class="text-right">
                            <div class="text-2xl font-semibold text-gray-900"><?= $stats['total_orders'] ?></div>
                            <div class="text-sm text-gray-500">Tổng đơn hàng</div>
                        </div>
                    </div>
                    <div class="h-72">
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Top Selling Products -->
            <div class="bg-white rounded-3xl shadow-lg p-6 mb-8 border border-gray-100">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">Sản phẩm bán chạy</h2>
                        <p class="text-sm text-gray-500">Danh sách 5 sản phẩm có doanh thu cao nhất</p>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50 border-b">
                            <tr>
                                <th class="px-4 py-3 text-sm font-semibold text-gray-900">Sản phẩm</th>
                                <th class="px-4 py-3 text-sm font-semibold text-gray-900">Số lượng bán</th>
                                <th class="px-4 py-3 text-sm font-semibold text-gray-900">Doanh thu</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            <?php foreach ($stats['top_products'] as $product): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-sm text-gray-900"><?= htmlspecialchars($product['name']) ?></td>
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
            <div class="bg-white rounded-3xl shadow-lg p-6 border border-gray-100">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">Đơn hàng gần đây</h2>
                        <p class="text-sm text-gray-500">10 đơn hàng mới nhất</p>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50 border-b">
                            <tr>
                                <th class="px-4 py-3 text-sm font-semibold text-gray-900">Đơn hàng</th>
                                <th class="px-4 py-3 text-sm font-semibold text-gray-900">Khách hàng</th>
                                <th class="px-4 py-3 text-sm font-semibold text-gray-900">Trạng thái</th>
                                <th class="px-4 py-3 text-sm font-semibold text-gray-900">Tổng tiền</th>
                                <th class="px-4 py-3 text-sm font-semibold text-gray-900">Ngày đặt</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            <?php foreach ($stats['recent_orders'] as $order): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-sm text-gray-900">#<?= $order['id'] ?></td>
                                <td class="px-4 py-3 text-sm text-gray-600"><?= htmlspecialchars($order['user_name']) ?></td>
                                <td class="px-4 py-3 text-sm">
                                    <span class="px-3 py-1 text-xs rounded-full font-medium <?php switch($order['status']) {
                                        case 'chờ xác nhận': echo 'bg-yellow-100 text-yellow-800'; break;
                                        case 'đã xác nhận': echo 'bg-blue-100 text-blue-800'; break;
                                        case 'đang giao': echo 'bg-orange-100 text-orange-800'; break;
                                        case 'đã giao': echo 'bg-green-100 text-green-800'; break;
                                        case 'đã hủy': echo 'bg-red-100 text-red-800'; break;
                                        default: echo 'bg-gray-100 text-gray-800';
                                    } ?>">
                                        <?= htmlspecialchars($order['status']) ?>
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

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const revenueCtx = document.getElementById('revenueChart');
        const statusCtx = document.getElementById('statusChart');

        if (revenueCtx) {
            new Chart(revenueCtx, {
                type: 'line',
                data: {
                    labels: <?= json_encode(array_column($stats['revenue_history'], 'date')) ?>,
                    datasets: [{
                        label: 'Doanh thu (đ)',
                        data: <?= json_encode(array_column($stats['revenue_history'], 'revenue')) ?>,
                        fill: true,
                        borderColor: '#2563eb',
                        backgroundColor: 'rgba(59, 130, 246, 0.15)',
                        tension: 0.35,
                        pointRadius: 4,
                        pointBackgroundColor: '#2563eb'
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false },
                        tooltip: { mode: 'index', intersect: false }
                    },
                    scales: {
                        x: { grid: { display: false }, ticks: { color: '#6b7280' } },
                        y: { ticks: { color: '#6b7280' }, grid: { color: '#e5e7eb' } }
                    }
                }
            });
        }

        if (statusCtx) {
            const statusLabels = <?= json_encode(array_keys($stats['order_status_counts'])) ?>;
            const statusValues = <?= json_encode(array_values($stats['order_status_counts'])) ?>;
            new Chart(statusCtx, {
                type: 'bar',
                data: {
                    labels: statusLabels,
                    datasets: [{
                        label: 'Số đơn hàng',
                        data: statusValues,
                        backgroundColor: ['#fbbf24', '#3b82f6', '#f97316', '#10b981', '#ef4444'],
                        borderRadius: 10,
                        maxBarThickness: 40
                    }]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { display: false } },
                    scales: {
                        x: { grid: { display: false }, ticks: { color: '#6b7280' } },
                        y: { beginAtZero: true, ticks: { color: '#6b7280' }, grid: { color: '#e5e7eb' } }
                    }
                }
            });
        }
    </script>
    <script src="public/js/script.js"></script>
</body>
</html>
