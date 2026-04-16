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
                                <?php
                                $itemImg = $item['image_url'] ?? $item['product_image_url'] ?? '';
                                if ($itemImg && !preg_match('/^https?:\/\//i', $itemImg)) {
                                    $itemImg = BASE_URL . ltrim($itemImg, '/');
                                }
                                ?>
                                <div class="flex items-center justify-between gap-4">
                                    <div class="flex items-center gap-4">
                                        <div class="w-20 h-20 rounded-lg overflow-hidden bg-gray-100 flex-none">
                                            <img src="<?= htmlspecialchars($itemImg ?: 'https://via.placeholder.com/100x100?text=' . urlencode($item['product_name'])) ?>" alt="<?= htmlspecialchars($item['product_name']) ?>" class="w-full h-full object-cover">
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900"><?= htmlspecialchars($item['product_name']) ?></p>
                                            <p class="text-sm text-gray-600">Size: <?= htmlspecialchars($item['size']) ?> | Số lượng: <?= $item['quantity'] ?></p>
                                        </div>
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