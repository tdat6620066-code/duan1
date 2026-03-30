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
    <section class="relative h-screen flex items-center justify-center overflow-hidden pt-16">
        <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-purple-700"></div>
        <div class="absolute inset-0 bg-black opacity-20"></div>
        <div class="relative z-10 text-center text-white px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl sm:text-6xl lg:text-7xl font-bold mb-6">
                Khám phá
                <span class="block text-yellow-400">Phong cách</span>
            </h1>
            <p class="text-xl sm:text-2xl mb-8 max-w-2xl mx-auto">
                Bộ sưu tập giày thể thao cao cấp với thiết kế hiện đại và chất lượng vượt trội
            </p>
            <a href="?act=products" class="inline-block bg-white text-gray-900 px-8 py-4 rounded-full text-lg font-semibold hover:bg-gray-100 transition-all duration-300 transform hover:scale-105 shadow-lg">
                Khám phá ngay
            </a>
        </div>
        <div class="absolute bottom-0 left-0 right-0 h-32 bg-gradient-to-t from-white to-transparent"></div>
    </section>

    <section class="py-20 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">Sản phẩm nổi bật</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Khám phá những mẫu giày hot nhất với thiết kế độc đáo và chất lượng cao
                </p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-8">
                <?php foreach ($top5ProductLatest as $product): ?>
                    <div class="product-card bg-white rounded-xl shadow-sm overflow-hidden group">
                        <div class="relative aspect-square overflow-hidden">
                            <?php
                            $imgUrl = $product['image_url'] ?? '';
                            if ($imgUrl && !preg_match('/^https?:\/\//i', $imgUrl)) {
                                $imgUrl = BASE_URL . $imgUrl;
                            }
                            $imgSrc = $imgUrl ?: 'https://via.placeholder.com/400x400?text=' . urlencode($product['name']);
                            ?>
                            <img src="<?= $imgSrc ?>"
                                alt="<?= htmlspecialchars($product['name']) ?>"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            <div class="product-overlay">
                                <a href="?act=product&id=<?= $product['id'] ?>"
                                    class="bg-white text-gray-900 px-6 py-3 rounded-full font-semibold hover:bg-gray-100 transition-colors duration-200">
                                    Xem chi tiết
                                </a>
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">
                                <?= $product['name'] ?>
                            </h3>
                            <p class="text-2xl font-bold text-blue-600">
                                <?= number_format($product['price'], 0, ',', '.') ?>đ
                            </p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="text-center mt-12">
                <a href="?act=products" class="inline-block bg-gray-900 text-white px-8 py-4 rounded-full text-lg font-semibold hover:bg-gray-800 transition-colors duration-200">
                    Xem tất cả sản phẩm
                </a>
            </div>
        </div>
    </section>

    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Chất lượng cao cấp</h3>
                    <p class="text-gray-600">Sản phẩm được chế tạo từ vật liệu tốt nhất với công nghệ tiên tiến</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Giao hàng nhanh</h3>
                    <p class="text-gray-600">Giao hàng tận nơi trong 24-48 giờ với dịch vụ chăm sóc khách hàng tận tình</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Đảm bảo hài lòng</h3>
                    <p class="text-gray-600">Chính sách đổi trả linh hoạt và bảo hành dài hạn cho mọi sản phẩm</p>
                </div>
            </div>
        </div>
    </section>

    <script src="public/js/script.js"></script>
</body>

</html>