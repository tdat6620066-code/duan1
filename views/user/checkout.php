<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShoeStore - Thanh toán</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="public/css/style.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <?php include('./views/components/navbar.php'); ?>

    <div class="pt-20">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-8">Thanh toán</h1>

            <form method="POST" class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <?php if (!empty($error)): ?>
                <div class="lg:col-span-2 bg-red-50 border border-red-200 text-red-700 rounded-lg p-4">
                    <?= htmlspecialchars($error) ?>
                </div>
                <?php endif; ?>

                <!-- Shipping Information -->
                <div class="space-y-6">
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Thông tin giao hàng</h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Địa chỉ giao hàng</label>
                                <select name="address_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Chọn địa chỉ</option>
                                    <?php foreach ($addresses as $address): ?>
                                    <option value="<?= $address['id'] ?>" <?= isset($selectedAddressId) && $selectedAddressId == $address['id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($address['address']) ?>, <?= htmlspecialchars($address['city']) ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                                <p class="mt-2 text-sm text-gray-500">Nếu chưa có địa chỉ, vui lòng nhập địa chỉ mới bên dưới.</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Địa chỉ mới</label>
                                <input type="text" name="new_address" value="<?= htmlspecialchars($newAddress ?? '') ?>" placeholder="Ví dụ: 123 Đường A" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Thành phố</label>
                                <input type="text" name="new_city" value="<?= htmlspecialchars($newCity ?? '') ?>" placeholder="Ví dụ: Hà Nội" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Phương thức thanh toán</h3>
                        <div class="space-y-3">
                            <label class="flex items-center">
                                <input type="radio" name="payment_method" value="cod" <?= (!isset($selectedPaymentMethod) || $selectedPaymentMethod === 'cod') ? 'checked' : '' ?> class="text-blue-600 focus:ring-blue-500">
                                <span class="ml-3">Thanh toán khi nhận hàng</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="payment_method" value="bank" <?= isset($selectedPaymentMethod) && $selectedPaymentMethod === 'bank' ? 'checked' : '' ?> class="text-blue-600 focus:ring-blue-500">
                                <span class="ml-3">Chuyển khoản ngân hàng</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="bg-white rounded-lg shadow-sm p-6 h-fit">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Tóm tắt đơn hàng</h3>
                    
                    <div class="space-y-4 mb-6">
                        <?php foreach ($cartItems as $item): ?>
                        <?php
                            $imgUrl = $item['image_url'] ?? '';
                            if ($imgUrl && !preg_match('/^https?:\/\//i', $imgUrl)) {
                                $imgUrl = BASE_URL . ltrim($imgUrl, '/');
                            }
                        ?>
                        <div class="flex items-center gap-4 bg-gray-50 rounded-2xl p-4 border border-gray-200">
                            <img src="<?= $imgUrl ?: 'https://via.placeholder.com/96x96?text=' . urlencode($item['name']) ?>" 
                                 alt="<?= htmlspecialchars($item['name']) ?>" 
                                 class="w-24 h-24 rounded-xl object-cover flex-shrink-0 border border-gray-200">
                            <div class="min-w-0 flex-1">
                                <h4 class="text-sm font-semibold text-gray-900 truncate"><?= htmlspecialchars($item['name']) ?></h4>
                                <p class="text-sm text-gray-500 mt-1">Size: <?= $item['size'] ?> | SL: <?= $item['quantity'] ?></p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-semibold text-gray-900">
                                    <?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?>đ
                                </p>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="border-t pt-4 space-y-2">
                        <div class="flex justify-between">
                            <span>Tạm tính</span>
                            <span><?= number_format($subtotal, 0, ',', '.') ?>đ</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Phí giao hàng</span>
                            <span><?= number_format($shippingCost, 0, ',', '.') ?>đ</span>
                        </div>
                        <div class="flex justify-between text-lg font-semibold border-t pt-2">
                            <span>Tổng cộng</span>
                            <span class="text-blue-600"><?= number_format($total, 0, ',', '.') ?>đ</span>
                        </div>
                    </div>

                    <button type="submit"
                            class="w-full mt-6 bg-blue-600 text-white py-3 px-4 rounded-lg font-semibold hover:bg-blue-700 transition-colors duration-200">
                        Đặt hàng
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="public/js/script.js"></script>
</body>
</html>