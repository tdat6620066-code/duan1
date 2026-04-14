<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="public/css/style.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50">
    <?php include('./views/components/navbar.php'); ?>
    <div class="pt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-8">Đơn hàng của tôi</h1>

            <?php if (!empty($_SESSION['success'])): ?>
                <div class="mb-6 bg-green-50 border border-green-200 text-green-700 rounded-lg p-4">
                    <?= htmlspecialchars($_SESSION['success']) ?>
                </div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>
            <?php if (!empty($_SESSION['error'])): ?>
                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 rounded-lg p-4">
                    <?= htmlspecialchars($_SESSION['error']) ?>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <?php if (empty($orders)): ?>
                <div class="text-center py-16">
                    <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">Chưa có đơn hàng</h3>
                    <p class="mt-2 text-gray-500">Hãy đặt hàng để xem lịch sử tại đây</p>
                    <a href="?act=products" class="mt-6 inline-block bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors duration-200">
                        Mua sắm ngay
                    </a>
                </div>
            <?php else: ?>
                <div class="space-y-6">
                    <?php foreach ($orders as $order): ?>
                        <div class="bg-white rounded-lg shadow-sm p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">Đơn hàng #<?= $order['id'] ?></h3>
                                    <p class="text-sm text-gray-600">Ngày đặt: <?= date('d/m/Y', strtotime($order['created_at'])) ?></p>
                                </div>
                                <div class="text-right">
                                    <p class="text-lg font-bold text-blue-600">
                                        <?= number_format($order['total_price'], 0, ',', '.') ?>đ
                                    </p>
                                    <span class="inline-block px-3 py-1 text-sm rounded-full 
                                <?php
                                switch ($order['status']) {
                                    case 'chờ xác nhận':
                                        echo 'bg-yellow-100 text-yellow-800';
                                        break;
                                    case 'đã xác nhận':
                                        echo 'bg-blue-100 text-blue-800';
                                        break;
                                    case 'đang giao':
                                        echo 'bg-orange-100 text-orange-800';
                                        break;
                                    case 'đã giao':
                                        echo 'bg-green-100 text-green-800';
                                        break;
                                    case 'đã hủy':
                                        echo 'bg-red-100 text-red-800';
                                        break;
                                }
                                ?>">
                                        <?= $order['status'] ?>
                                    </span>
                                </div>
                            </div>

                            <div class="border-t pt-4">
                                <p class="text-sm text-gray-600">
                                    <strong>Địa chỉ giao hàng:</strong> <?= $order['address'] ?>, <?= $order['city'] ?>
                                </p>
                                <div class="mt-4 flex flex-wrap gap-3 items-center">
                                    <a href="?act=order&id=<?= $order['id'] ?>" class="text-blue-600 hover:text-blue-800 font-medium">
                                        Xem chi tiết →
                                    </a>
                                    <?php if (!in_array(strtolower($order['status']), ['shipped', 'delivered', 'cancelled', 'đang giao', 'đã giao', 'đã hủy'])): ?>
                                        <a href="?act=order_cancel&id=<?= $order['id'] ?>" onclick="return confirm('Bạn có chắc muốn hủy đơn hàng này?');" class="text-red-600 hover:text-red-800 font-medium">
                                            Hủy đơn hàng
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <script src="public/js/script.js"></script>
</body>

</html>