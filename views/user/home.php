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

    </section>
</body>
</html>