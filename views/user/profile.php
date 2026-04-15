<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin người dùng - ShoeStore</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="public/css/style.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <?php include './views/components/navbar.php'; ?>

    <div class="pt-20">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <h1 class="text-3xl font-bold text-gray-900 mb-6">Thông tin tài khoản</h1>

            <?php if (!empty($success)): ?>
                <div class="mb-6 rounded-lg bg-green-100 border border-green-300 text-green-800 px-6 py-4">
                    <?= htmlspecialchars($success) ?>
                </div>
            <?php elseif (!empty($error)): ?>
                <div class="mb-6 rounded-lg bg-red-100 border border-red-300 text-red-800 px-6 py-4">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <div class="bg-white rounded-xl shadow-sm p-8">
                <form method="POST" class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Họ và tên</label>
                        <input type="text" name="name" value="<?= htmlspecialchars($user['name'] ?? '') ?>" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" name="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Số điện thoại</label>
                        <input type="tel" name="phone" value="<?= htmlspecialchars($user['phone'] ?? '') ?>" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg transition">Cập nhật thông tin</button>
                        <a href="?act=contact" class="text-blue-600 hover:text-blue-800">Gửi liên hệ với quản trị</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
