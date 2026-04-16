<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShoeStore - Chi tiết sản phẩm</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="public/css/style.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <?php include('./views/components/navbar.php'); ?>

    <div class="pt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Product Images -->
                <div class="space-y-4">
                    <div class="aspect-square rounded-xl overflow-hidden bg-gray-100">
                        <?php
                        $imgUrl = $product['image_url'] ?? '';
                        if ($imgUrl && !preg_match('/^https?:\/\//i', $imgUrl)) {
                            $imgUrl = BASE_URL . $imgUrl;
                        }
                        ?>
                        <img src="<?= $imgUrl ?: 'https://via.placeholder.com/600x600?text=' . urlencode($product['name']) ?>" 
                             alt="<?= htmlspecialchars($product['name']) ?>" 
                             class="w-full h-full object-cover product-image cursor-zoom-in">
                    </div>
                </div>

                <!-- Product Info -->
                <div class="space-y-6">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 mb-2"><?= $product['name'] ?></h1>
                        <p class="text-lg text-gray-600"><?= $product['category_name'] ?></p>
                    </div>

                    <div>
                        <p class="text-4xl font-bold text-blue-600 mb-4">
                            <?= number_format($product['price'], 0, ',', '.') ?>đ
                        </p>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Mô tả sản phẩm</h3>
                        <p class="text-gray-600 leading-relaxed"><?= $product['description'] ?></p>
                    </div>

                    <!-- Size Selection -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Chọn kích cỡ</h3>
                        <div class="flex flex-wrap gap-3">
                            <?php foreach ($variants as $variant): ?>
                            <button class="size-btn w-12 h-12 border-2 border-gray-300 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition-colors flex items-center justify-center font-semibold"
                                    data-variant-id="<?= $variant['id'] ?>">
                                <?= $variant['size'] ?>
                            </button>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Add to Cart -->
                    <div class="space-y-4">
                        <button id="add-to-cart-btn" 
                                class="w-full bg-blue-600 text-white py-4 px-6 rounded-xl text-lg font-semibold hover:bg-blue-700 transition-colors duration-200 transform hover:scale-105 disabled:bg-gray-400 disabled:cursor-not-allowed"
                                disabled>
                            Chọn kích cỡ trước
                        </button>
                        <p class="text-sm text-gray-500 text-center">Miễn phí giao hàng toàn quốc</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="public/js/script.js"></script>
</body>
</html>