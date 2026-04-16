<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShoeStore - Trang chủ</title>
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
            <div class="text-center mb-12">
                <p class="text-sm uppercase tracking-[0.3em] text-blue-600 font-semibold">Sản phẩm nổi bật</p>
                <h2 class="text-4xl sm:text-5xl font-bold text-gray-900 mt-4">Khám phá những mẫu giày hot nhất</h2>
                <p class="mt-4 text-gray-600 max-w-2xl mx-auto">Khám phá những mẫu giày hot nhất với thiết kế độc đáo và chất lượng cao.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">
                <?php if (empty($top5ProductLatest)): ?>
                    <div class="lg:col-span-5 bg-white rounded-3xl shadow-sm p-8 text-center text-gray-700">
                        Chưa có sản phẩm nổi bật để hiển thị.
                    </div>
                <?php else: ?>
                    <?php foreach ($top5ProductLatest as $product): ?>
                        <?php
                            $imgUrl = $product['image_url'] ?? '';
                            if ($imgUrl && !preg_match('/^https?:\/\//i', $imgUrl)) {
                                $imgUrl = BASE_URL . ltrim($imgUrl, '/');
                            }
                            $imgSrc = $imgUrl ?: 'https://via.placeholder.com/400x400?text=' . urlencode($product['name']);
                        ?>
                        <div class="bg-white rounded-3xl overflow-hidden shadow-lg group">
                            <div class="relative aspect-[4/5] overflow-hidden">
                                <img src="<?= htmlspecialchars($imgSrc) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                                <a href="<?= BASE_URL ?>?act=product&id=<?= $product['id'] ?>" class="absolute inset-0 flex items-center justify-center bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <span class="bg-white text-gray-900 px-5 py-3 rounded-full text-sm font-semibold">Xem chi tiết</span>
                                </a>
                            </div>
                            <div class="p-5">
                                <h3 class="text-lg font-semibold text-gray-900 line-clamp-2 mb-3">
                                    <a href="<?= BASE_URL ?>?act=product&id=<?= $product['id'] ?>" class="hover:text-blue-600 transition-colors">
                                        <?= htmlspecialchars($product['name']) ?>
                                    </a>
                                </h3>
                                <p class="text-sm text-gray-500 mb-4 line-clamp-2"><?= htmlspecialchars($product['category_name']) ?></p>
                                <p class="text-2xl font-bold text-blue-600">
                                    <?= number_format($product['price'], 0, ',', '.') ?>đ
                                </p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <div class="mt-12 text-center">
                <a href="?act=products" class="inline-flex items-center justify-center bg-gray-900 text-white px-8 py-4 rounded-full text-lg font-semibold hover:bg-gray-800 transition-colors duration-300">
                    Xem tất cả sản phẩm
                </a>
            </div>
        </div>
    </section>

    <section class="py-20 px-4 sm:px-6 lg:px-8 bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                <div class="p-8 rounded-3xl bg-slate-50 border border-slate-200">
                    <div class="mx-auto mb-6 h-16 w-16 flex items-center justify-center rounded-full bg-blue-100 text-blue-600 text-2xl">
                        ✓
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Chất lượng cao cấp</h3>
                    <p class="text-gray-600">Sản phẩm được chế tạo từ vật liệu tốt nhất với công nghệ tiên tiến.</p>
                </div>
                <div class="p-8 rounded-3xl bg-slate-50 border border-slate-200">
                    <div class="mx-auto mb-6 h-16 w-16 flex items-center justify-center rounded-full bg-emerald-100 text-emerald-600 text-2xl">
                        📦
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Giao hàng nhanh</h3>
                    <p class="text-gray-600">Giao hàng tận nơi trong 24-48 giờ với dịch vụ chăm sóc khách hàng tận tình.</p>
                </div>
                <div class="p-8 rounded-3xl bg-slate-50 border border-slate-200">
                    <div class="mx-auto mb-6 h-16 w-16 flex items-center justify-center rounded-full bg-violet-100 text-violet-600 text-2xl">
                        ♥
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Đảm bảo hài lòng</h3>
                    <p class="text-gray-600">Chính sách đổi trả linh hoạt và bảo hành dài hạn cho mọi sản phẩm.</p>
                </div>
            </div>
        </div>
    </section>
</body>
</html>