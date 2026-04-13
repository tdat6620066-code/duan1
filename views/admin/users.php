<?php
include './views/components/admin_navbar.php';
?>

<div class="flex pt-16">
    <?php include './views/admin/admin_sidebar.php'; ?>

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
