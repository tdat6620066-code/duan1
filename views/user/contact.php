<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShoeStore - Liên hệ</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="public/css/style.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <?php include('./views/components/navbar.php'); ?>

    <main class="pt-24 pb-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid gap-12 lg:grid-cols-2 items-center">
                <div class="space-y-6">
                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-sm font-semibold">Liên hệ với chúng tôi</span>
                    <h1 class="text-4xl sm:text-5xl font-bold text-gray-900">Chúng tôi luôn sẵn sàng hỗ trợ bạn</h1>
                    <p class="text-gray-600 text-lg leading-8">Gửi yêu cầu hoặc câu hỏi, đội ngũ hỗ trợ của ShoeStore sẽ phản hồi nhanh chóng. Hãy chia sẻ điều bạn cần và chúng tôi sẽ giúp bạn tìm được sản phẩm ưng ý nhất.</p>

                    <div class="grid gap-4 sm:grid-cols-3">
                        <div class="rounded-3xl bg-white p-6 shadow-sm border border-gray-200">
                            <p class="text-sm text-gray-500">Điện thoại</p>
                            <p class="mt-3 font-semibold text-gray-900">0393295484</p>
                        </div>
                        <div class="rounded-3xl bg-white p-6 shadow-sm border border-gray-200">
                            <p class="text-sm text-gray-500">Email</p>
                            <p class="mt-3 font-semibold text-gray-900">support@shoestore.vn</p>
                        </div>
                        <div class="rounded-3xl bg-white p-6 shadow-sm border border-gray-200">
                            <p class="text-sm text-gray-500">Địa chỉ</p>
                            <p class="mt-3 font-semibold text-gray-900">Hà Nội, Việt Nam</p>
                        </div>
                    </div>
                </div>
                <div class="rounded-[40px] bg-gradient-to-br from-slate-950 via-slate-900 to-blue-950 p-1 shadow-2xl">
                    <div class="rounded-[36px] bg-white p-8 sm:p-10">
                        <div class="mb-8">
                            <p class="text-sm uppercase tracking-[0.32em] text-blue-600 font-semibold">Form liên hệ</p>
                            <h2 class="mt-3 text-3xl font-bold text-gray-900">Gửi lời nhắn ngay</h2>
                        </div>

                        <?php if (!empty($success)): ?>
                            <div class="mb-6 rounded-3xl border border-green-200 bg-green-50 p-4 text-sm text-green-800">
                                <?= htmlspecialchars($success) ?>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($error)): ?>
                            <div class="mb-6 rounded-3xl border border-red-200 bg-red-50 p-4 text-sm text-red-800">
                                <?= htmlspecialchars($error) ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST" class="space-y-5">
                            <div class="grid gap-4 sm:grid-cols-2">
                                <label class="block">
                                    <span class="text-sm font-medium text-gray-700">Họ và tên</span>
                                    <input type="text" name="name" value="<?= htmlspecialchars($name) ?>" placeholder="Nhập họ và tên" class="mt-2 w-full rounded-3xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100" />
                                </label>
                                <label class="block">
                                    <span class="text-sm font-medium text-gray-700">Email</span>
                                    <input type="email" name="email" value="<?= htmlspecialchars($email) ?>" placeholder="Nhập email" class="mt-2 w-full rounded-3xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100" />
                                </label>
                            </div>

                            <label class="block">
                                <span class="text-sm font-medium text-gray-700">Số điện thoại</span>
                                <input type="text" name="phone" value="<?= htmlspecialchars($phone) ?>" placeholder="Nhập số điện thoại" class="mt-2 w-full rounded-3xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100" />
                            </label>

                            <label class="block">
                                <span class="text-sm font-medium text-gray-700">Tiêu đề</span>
                                <input type="text" name="subject" value="<?= htmlspecialchars($subject ?? '') ?>" placeholder="Nhập tiêu đề liên hệ" class="mt-2 w-full rounded-3xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100" />
                            </label>

                            <label class="block">
                                <span class="text-sm font-medium text-gray-700">Nội dung</span>
                                <textarea name="message" rows="5" placeholder="Nhập nội dung liên hệ" class="mt-2 w-full rounded-3xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"><?= htmlspecialchars($message ?? '') ?></textarea>
                            </label>

                            <button type="submit" class="w-full rounded-3xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-500/10 transition hover:bg-blue-700">Gửi liên hệ</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>