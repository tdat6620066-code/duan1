<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body class="bg-gray-50">
    <?php include('./views/components/navbar.php'); ?>
    <div class="pt-20">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-8">Thanh toán</h1>

            <form method="POST" class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="space-y-6">
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Thông tin giao hàng</h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Địa chỉ giao hàng</label>
                                <select name="address_id" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Chọn địa chỉ</option>
                                    <?php foreach ($addresses as $address): ?>
                                        <option value="<?= $address['id'] ?>">
                                            <?= $address['address'] ?>, <?= $address['city'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Phương thức thanh toán</h3>
                        <div class="space-y-3">
                            <label class="flex items-center">
                                <input type="radio" name="payment_method" value="cod" checked class="text-blue-600 focus:ring-blue-500">
                                <span class="ml-3">Thanh toán khi nhận hàng</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="payment_method" value="bank" class="text-blue-600 focus:ring-blue-500">
                                <span class="ml-3">Chuyển khoản ngân hàng</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-sm p-6 h-fit">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Tóm tắt đơn hàng</h3>
                    <div class="space-y-4 mb-6">
                        <?php foreach ($cartItems as $item): ?>
                            <div class="flex items-center space-x-4">
                                <img src="https://via.placeholder.com/60x60?text=<?= urlencode($item['name']) ?>"
                                    alt="<?= $item['name'] ?>"
                                    class="w-15 h-15 object-cover rounded">
                                <div class="flex-1">
                                    <h4 class="text-sm font-medium text-gray-900"><?= $item['name'] ?></h4>
                                    <p class="text-sm text-gray-500">Size: <?= $item['size'] ?> | SL: <?= $item['quantity'] ?></p>
                                </div>
                                <p class="text-sm font-semibold text-gray-900">
                                    <?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?>đ
                                </p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="border-t pt-4 space-y-2">
                        <div class="flex justify-between">
                            <span>Tạm tính</span>
                            <span>2,500,000đ</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Phí giao hàng</span>
                            <span>Miễn phí</span>
                        </div>
                        <div class="flex justify-between text-lg font-semibold border-t pt-2">
                            <span>Tổng cộng</span>
                            <span class="text-blue-600">2,500,000đ</span>
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