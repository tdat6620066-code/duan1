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
            <h1 class="text-3xl font-bold text-gray-900 mb-8">Giỏ hàng của bạn</h1>

            <?php
            $cartSubtotal = 0;
            foreach ($cartItems as $item) {
                $cartSubtotal += $item['price'] * $item['quantity'];
            }
            ?>

            <?php if (empty($cartItems)): ?>
                <div class="text-center py-16">
                    <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">Giỏ hàng trống</h3>
                    <p class="mt-2 text-gray-500">Hãy thêm sản phẩm vào giỏ hàng của bạn</p>
                    <a href="?act=products" class="mt-6 inline-block bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors duration-200">
                        Mua sắm ngay
                    </a>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="lg:col-span-2 space-y-4">
                        <?php foreach ($cartItems as $item): ?>
                            <div class="bg-white rounded-lg shadow-sm p-6 cart-item-row">
                                <div class="flex items-center space-x-4">
                                    <?php
                                    $imgUrl = $item['image_url'] ?? '';
                                    if ($imgUrl && !preg_match('/^https?:\/\//i', $imgUrl)) {
                                        $imgUrl = BASE_URL . $imgUrl;
                                    }
                                    ?>
                                    <img src="<?= $imgUrl ?: 'https://via.placeholder.com/100x100?text=' . urlencode($item['name']) ?>"
                                        alt="<?= $item['name'] ?>"
                                        class="w-20 h-20 object-cover rounded-lg">
                                    <div class="flex-1">
                                        <h3 class="text-lg font-semibold text-gray-900"><?= $item['name'] ?></h3>
                                        <p class="text-gray-600">Size: <?= $item['size'] ?></p>
                                        <p class="text-lg font-bold text-blue-600">
                                            <?= number_format($item['price'], 0, ',', '.') ?>đ
                                        </p>
                                        <p class="text-sm text-gray-500" data-item-total="<?= $item['product_variant_id'] ?>">
                                            <?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?>đ
                                        </p>
                                    </div>
                                    <div class="flex items-center space-x-4">
                                        <input type="number" value="<?= $item['quantity'] ?>" min="1"
                                            class="w-16 text-center border border-gray-300 rounded px-2 py-1 cart-quantity-input"
                                            data-variant-id="<?= $item['product_variant_id'] ?>"
                                            data-price="<?= $item['price'] ?>">
                                        <button type="button" class="text-red-600 hover:text-red-800 cart-remove-btn" data-variant-id="<?= $item['product_variant_id'] ?>">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="bg-white rounded-lg shadow-sm p-6 h-fit">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Tóm tắt đơn hàng</h3>
                        <div class="space-y-2 mb-4">
                            <div class="flex justify-between">
                                <span>Tạm tính</span>
                                <span id="cart-subtotal"><?= number_format($cartSubtotal, 0, ',', '.') ?>đ</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Phí giao hàng</span>
                                <span id="cart-shipping">Miễn phí</span>
                            </div>
                        </div>
                        <div class="border-t pt-4">
                            <div class="flex justify-between text-lg font-semibold">
                                <span>Tổng cộng</span>
                                <span id="cart-total" class="text-blue-600"><?= number_format($cartSubtotal, 0, ',', '.') ?>đ</span>
                            </div>
                        </div>
                        <a href="?act=checkout"
                            class="w-full mt-6 bg-blue-600 text-white py-3 px-4 rounded-lg font-semibold hover:bg-blue-700 transition-colors duration-200 block text-center">
                            Thanh toán
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <script src="public/js/script.js"></script>
</body>

</html>