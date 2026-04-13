<?php
include './views/components/admin_navbar.php';
?>
<div class="flex">
   <?php include './views/admin/admin_sidebar.php';?>
    <div class="w-4/5 p-8">
        <div class="">
            <a href="<?php echo BASE_URL; ?>?act=admin_categories" class="text-blue-600 hover:text-blue-800 flex items-center gap-2">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>
        <div class="max-w-4xl mx-auto">
            <h1 class="text-3xl font-bold mb-8">Thêm danh mục mới</h1>
            <?php if(isset($error)):?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    <?php echo $error; ?>
                </div>
                <?php endif;?>
                <form action="" method="POST" class="bg-white rounded-lg shadow p-8 space-y-6">
                    <div>
                        <label for="" class="block text-sm font-semibold mb-2">Tên danh mục</label>
                        <input type="text" name="name" required class="w-full border border-gray-300 rounded-lg px-4 py-2">
                    </div>
                   
                    <div class="flex gap-4">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition">
                            Thêm danh mục
                        </button>
                        <a href="<?php echo BASE_URL; ?>?act=admin_categories" class="bg-gray-300 hover:bg-gray-400 text-black px-6 py-2 rounded-lg transition">
                            Hủy
                        </a>
                    </div>
                </form>
        </div>
    </div>
</div>