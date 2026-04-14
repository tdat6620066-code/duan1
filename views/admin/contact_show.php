<?php
include './views/components/admin_navbar.php';
?>
<div class="flex pt-16">
    <?php include './views/admin/admin_sidebar.php';?>
<div class="w-4/5 p-8">
   <div class="mb-8">
     <a href="<?php echo BASE_URL;?>?act=admin_contacts" class="text-blue-600 hover:text-blue-800 flex items-center gap-2">
        <i class="fas fa-arrow-left"></i> Quay lại danh sách liên hệ
    </a>
   </div>
   <?php if(isset($_SESSION['error'])): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
        <?php echo $_SESSION['error']; unset($_SESSION['error']);?>
    </div>
    <?php endif;?>
    <?php if(isset($_SESSION['success'])):?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            <?php echo $_SESSION['success']; unset($_SESSION['success']);?>
        </div>
        <?php endif;?>
        <div class="bg-white rounded-lg shadow p-6">
            <h1 class="text-3xl font-bold mb-4">Liên hệ #<?php echo $contact['id']; ?></h1>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <p class="text-sm text-gray-600">Người gửi</p>
                    <p class="text-lg font-semibold"><?php echo htmlspecialchars($contact['name']);?></p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Email</p>
                    <p class="text-lg font-semibold"><?php echo htmlspecialchars($contact['email']);?></p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Số điện thoại</p>
                    <p class="text-lg font-semibold"><?php echo htmlspecialchars($contact['phone']);?></p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Người gửi</p>
                    <p class="text-lg font-semibold"><?php echo date('d/m/Y H:i', strtotime($contact['created_at']));?></p>
                </div>
            </div>
            <div class="mb-6">
                <p class="text-sm text-gray-600">Tiêu đề</p>
                <p class="text-xl font-semibold"><?=  htmlspecialchars($contact['subject']); ?></p>
            </div>
            <div class="mb-8">
                <p class="text-sm text-gray-600">Nội dung</p>
                <div class="mt-2 p-4 rounded-lg bg-gray-50 border border-gray-200 text-gray-800"><?= nl2br(htmlspecialchars($contact['message'])); ?></div>
            </div>
            <form action="" method="POST" class="space-y-4">
                <div>
                    <label for="" class="block text-sm font-semibold mb-2">Cập nhật trạng thái</label>
                    <select name="status" id="" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                          <option value="mới" <?php echo $contact['status'] === 'mới' ? 'selected' : ''; ?>>Mới</option>
                            <option value="đã xử lý" <?php echo $contact['status'] === 'đã xử lý' ? 'selected' : ''; ?>>Đã xử lý</option>
                             <option value="đã phản hồi" <?php echo $contact['status'] === 'đã phản hồi' ? 'selected' : ''; ?>>Đã phản hồi</option>
                    </select>
                </div>
                  <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition">Lưu trạng thái</button>
            </form>
</div>

        </div>
</div>