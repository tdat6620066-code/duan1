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
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <a href="?act=orders" class="inline-block text-blue-600 hover:text-blue-800 mb-6">← Quay lại đơn hàng</a>
            <div class="bg-white rounded-lg shadow-sm p-8">
                <div class="flex flex-col lg:flex-row justify-between gap-6 mb-6">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Đơn hàng #<?= $order['id'] ?></h1>
                        <p class="text-sm text-gray-500">Ngày đặt: <?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></p>
                    </div>
                    <div class="text-right">
                        <p class="text-xl font-semibold text-blue-600"><?= number_format($order['total_price'], 0, ',', '.') ?>đ</p>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-gray-100 text-gray-800">
                            <?= htmlspecialchars($order['status']) ?>
                        </span>
                    </div>
                </div>
                <?php if (!in_array(strtolower($order['status']), ['shipped', 'delivered', 'cancelled', 'đang giao', 'đã giao', 'đã hủy'])): ?>
                    <div class="mb-6">
                        <a href="?act=order_cancel&id=<?= $order['id'] ?>" onclick="return confirm('Bạn có chắc muốn hủy đơn hàng này?');" class="inline-block bg-red-600 text-white px-5 py-2 rounded-lg hover:bg-red-700 transition-colors duration-200">
                            Hủy đơn hàng
                        </a>
                    </div>
                <?php endif; ?>

                <div class="grid gap-6 lg:grid-cols-3 mb-8">
                    <div class="bg-gray-50 rounded-lg p-5">
                        <h2 class="text-lg font-semibold mb-3">Địa chỉ giao hàng</h2>
                        <p class="text-sm text-gray-700"><?= htmlspecialchars($order['address']) ?></p>
                        <p class="text-sm text-gray-700"><?= htmlspecialchars($order['city']) ?></p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-5 lg:col-span-2">
                        <h2 class="text-lg font-semibold mb-3">Chi tiết sản phẩm</h2>
                        <div class="space-y-4">
                            <?php foreach ($orderItems as $item): ?>
                                <div class="flex items-center justify-between gap-4">
                                    <div>
                                        <p class="font-medium text-gray-900"><?= htmlspecialchars($item['product_name']) ?></p>
                                        <p class="text-sm text-gray-600">Size: <?= htmlspecialchars($item['size']) ?> | Số lượng: <?= $item['quantity'] ?></p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-semibold text-gray-900"><?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?>đ</p>
                                        <p class="text-sm text-gray-500">Giá mỗi chiếc: <?= number_format($item['price'], 0, ',', '.') ?>đ</p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="public/js/script.js"></script>
</body>

</html>