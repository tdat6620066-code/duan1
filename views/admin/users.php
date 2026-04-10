<?php
include './views/components/admin_navbar.php';
?>

<div class="flex pt-16">
    <div class="w-1/5 bg-gray-900 text-white p-6 min-h-screen">
        <div class="mb-12">
            <h2 class="text-sm font-semibold text-gray-400 mb-6">MENU CHÍNH</h2>
            <a href="<?php echo BASE_URL; ?>?act=admin" class="flex items-center gap-3 px-4 py-3 rounded hover:bg-gray-800 transition">
                <i class="fas fa-chart-line"></i> Dashboard
            </a>
            <a href="<?php echo BASE_URL; ?>" class="flex items-center gap-3 px-4 py-3 rounded hover:bg-gray-800 transition">
                <i class="fas fa-home"></i> Trang chủ
            </a>
        </div>

        <div>
            <h2 class="text-sm font-semibold text-gray-400 mb-6">QUẢN LÝ</h2>
            <a href="<?php echo BASE_URL; ?>?act=admin_products" class="flex items-center gap-3 px-4 py-3 rounded hover:bg-gray-800 transition">
                <i class="fas fa-box"></i> Sản phẩm
            </a>
            <a href="<?php echo BASE_URL; ?>?act=admin_categories" class="flex items-center gap-3 px-4 py-3 rounded hover:bg-gray-800 transition">
                <i class="fas fa-tag"></i> Danh mục
            </a>
            <a href="<?php echo BASE_URL; ?>?act=admin_users" class="flex items-center gap-3 px-4 py-3 rounded bg-blue-600">
                <i class="fas fa-users"></i> Người dùng
            </a>
            <a href="<?php echo BASE_URL; ?>?act=admin_orders" class="flex items-center gap-3 px-4 py-3 rounded hover:bg-gray-800 transition">
                <i class="fas fa-shopping-cart"></i> Đơn hàng
            </a>
        </div>
    </div>

    <div class="w-4/5 p-8">
        <h1 class="text-3xl font-bold mb-8">Quản lý người dùng</h1>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
            <?php endif; ?>

        <div class="bg-white rounded-lg shadow overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-100 border-b">
                        <th class="px-6 py-3 text-left text-sm font-semibold">ID</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Tên</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Email</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Điện thoại</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Vai trò</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Ngày tham gia</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm"><?php echo $user['id']; ?></td>
                            <td class="px-6 py-4 text-sm"><?php echo $user['name']; ?></td>
                            <td class="px-6 py-4 text-sm"><?php echo $user['email']; ?></td>
                            <td class="px-6 py-4 text-sm"><?php echo $user['phone'] ?? '-'; ?></td>
                            <td class="px-6 py-4 text-sm">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                    <?php echo $user['role_name'] === 'admin' ? 'bg-red-100 text-red-700' : 'bg-blue-100 text-blue-700'; ?>">
                                    <?php echo $user['role_name']; ?>
                                </span>
                                </td>
                            <td class="px-6 py-4 text-sm"><?php echo date('d/m/Y', strtotime($user['created_at'])); ?></td>
                            <td class="px-6 py-4 text-sm flex gap-2">
                                <a href="<?php echo BASE_URL; ?>?act=admin_user_edit&id=<?php echo $user['id']; ?>" 
                                   class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-xs transition">
                                    Sửa
                                </a>
                                <?php if ($user['id'] !== $_SESSION['user']['id']): ?>
                                    <a href="<?php echo BASE_URL; ?>?act=admin_user_delete&id=<?php echo $user['id']; ?>" 
                                       onclick="return confirm('Bạn chắc chắn?')"
                                       class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs transition">
                                        Xóa
                                    </a>
                                <?php endif; ?>
                            </td>
                            </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>