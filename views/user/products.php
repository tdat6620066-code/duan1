<!DOCTYPE html>
<html lang="vi">
    <head>
        <meta charset="UTF-8">
         <meta name="viewport" content="width=device-width, initial-scale=1.0">
         <title>ShoeStore - Sản phẩm</title>
         <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
          <link rel="stylesheet" href="public/css/style.css">
          <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="bg-gray-50">
        <?php include('./views/components/navbar.php'); ?>
         <div class="pt-20">
            <div class="bg-white shadow-sm">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                    <?php $searchQuery = $searchQuery ?? ''; ?>
                    <?php if (!empty($searchQuery)): ?>
                        <h1 class="text-3xl font-bold text-gray-900">Kết quả tìm kiếm</h1>
                        <p class="text-gray-600 mt-2">Hiển thị <?= count($products) ?> sản phẩm cho "<span class="font-medium"><?= htmlspecialchars($searchQuery) ?></span>"</p>
                        <?php else: ?>
                            <h1 class="text-3xl font-bold text-gray-900">Sản phẩm</h1>
                            <p class="text-gray-600 mt-2">Khám phá bộ sưu tập giày thể thao của chúng tôi</p>
                    <?php endif; ?>
                        </div>
            </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="flex flex-col lg:flex-row gap-8">
                    <div class="lg:w-1/4">
                        <div class="bg-white rounded-lg shadow-sm p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Danh mục</h3>
                            <div class="space-y-2">
                                <a href="?act=products" class="block text-gray-700 hover:text-blue-600 transition-colors">Tất cả</a>
                                <?php foreach ($categories as $category): ?>
                                    <a href="?act=category&id=<?= $category['id'] ?>" class="block text-gray-700 hover:text-blue-600 transition-colors">
                                        <?= $category['name'] ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <div class="lg:w-3/4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" id="products-grid">
                            <?php if (count($products) === 0): ?>
                                 <div class="lg:col-span-3 bg-white rounded-lg shadow-sm p-8 text-center text-gray-700">
                                    <?php if (!empty($searchQuery)): ?>
                                        Không tìm thấy sản phẩm phù hợp với "<strong><?= htmlspecialchars($searchQuery) ?></strong>".
                                <?php else: ?>
                                    Chưa có sản phẩm nào.
                                <?php endif; ?>
                                </div>
                            <?php else: ?>
                                <?php foreach ($products as $product): ?>
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
                                                 <?= htmlspecialchars($product['name']) ?>
                                            </h3>
                                            <p class="text-sm text-gray-600 mb-2"><?= htmlspecialchars($product['category_name']) ?></p>
                                            <p class="text-2xl font-bold text-blue-600">
                                                 <?= number_format($product['price'], 0, ',', '.') ?>đ
                                            </p>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <script src="public/js/script.js"></script>
    </body>
</html>