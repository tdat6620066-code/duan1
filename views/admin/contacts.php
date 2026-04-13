<?php
include './views/components/admin_navbar.php';
?>
<div class="flex pt-16">
      <?php include './views/admin/admin_sidebar.php';?>
      <div class="w-4/5 p-8">
         <h1 class="text-3xl font-bold mb-8">Quản lý liên hệ</h1>
         <?php if (isset($_SESSION['error'])): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
               <?php endif; ?>
               <?php if (isset($_SESSION['success'])):?>
               <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                 <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
               </div>
               <?php endif; ?>
               <div class="bg-white rounded-lg shadow overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-100 border-b">
                            <th class="px-6 py-3 text-left text-sm font-semibold">ID</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Tên</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Email</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Tiêu đề</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Trạng thái</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Ngày gửi</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($contacts as $contact):?>
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm">#<?php echo $contact['id']; ?></td>
                                <td class="px-6 py-4 text-sm"><?php echo htmlspecialchars($contact['name']); ?></td>
                                  <td class="px-6 py-4 text-sm text-gray-600"><?php echo htmlspecialchars($contact['email']); ?></td>
                                   <td class="px-6 py-4 text-sm"><?php echo htmlspecialchars($contact['subject']); ?></td>
                                    <td class="px-6 py-4 text-sm">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold <?php echo $contact['status'] === 'mới' ? 'bg-yellow-100 text-yellow-700' : ($contact['status'] === 'đã xử lý' ? 'bg-blue-100 text-blue-700' : 'bg-green-100 text-green-700'); ?>">
                                    <?php echo htmlspecialchars($contact['status']); ?>
                                </span>
                            </td>
                               <td class="px-6 py-4 text-sm"><?php echo date('d/m/Y H:i', strtotime($contact['created_at'])); ?></td>
                                  <td class="px-6 py-4 text-sm flex gap-2">
                                <a href="<?php echo BASE_URL; ?>?act=admin_contact_show&id=<?php echo $contact['id']; ?>" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs transition">Xem</a>
                                <a href="<?php echo BASE_URL; ?>?act=admin_contact_delete&id=<?php echo $contact['id']; ?>" onclick="return confirm('Bạn chắc chắn muốn xóa liên hệ này?')" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs transition">Xóa</a>
                            </td>
                            </tr>
                            <?php endforeach; ?>
                    </tbody>
                </table>
               </div>
      </div>
</div>