<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - ShoeStore</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <!-- Top Navbar -->
    <nav class="bg-gray-900 text-white shadow-lg fixed top-0 w-full z-50">
        <div class="px-8 py-4 flex justify-between items-center">
            <a href="<?php echo BASE_URL; ?>?act=admin" class="text-xl font-bold">ShoeStore Admin</a>
            <div class="flex items-center gap-4">
                <span class="text-sm"><i class="fas fa-user-circle mr-2"></i><?php echo $_SESSION['user']['name']; ?></span>
                <a href="<?php echo BASE_URL; ?>?act=logout" class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded text-sm transition">Đăng xuất</a>
            </div>
        </div>
    </nav>
</body>
</html>
