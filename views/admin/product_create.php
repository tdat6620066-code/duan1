<?php
include './views/components/admin_navbar.php';
?>
<div class="flex">
    <div class="w-1/5 bg-gray-900 text-white p-6 min-h-screen">
        <div class="mb-12">
            <h2 class="text-sm font-semibold text-gray-400 mb-6">MENU CHÍNH</h2>
            <a href="<?php echo BASE_URL; ?>?act=admin" class="flex items-center gap-3 px-4 py-3 rounded hover:bg-gray-800 transition">
                <i class="fas fa-chart-line"></i> Dashboard
            </a>
        </div>
        <div>
            <h2 class="text-sm font-semibold text-gray-400 mb-6">quản lý</h2>
            <a href="<?php echo BASE_URL;?>?act=admin_products" class="flex items-center gap-3 px-4 py-3 rounded bg-blue-600">
                <i class="fas fa-box"></i> Sản phẩm
            </a>
            <a href="<?php echo BASE_URL; ?>?act=admin_categories" class="flex items-center gap-3 px-4 py-3 rounded hover:bg-gray-800 transition">
                <i class="fas fa-tag"></i> Danh mục
            </a>
            <a href="<?php echo BASE_URL; ?>?act=admin_users" class="flex items-center gap-3 px-4 py-3 rounded hover:bg-gray-800 transition">
                <i class="fas fa-users"></i> Người dùng
            </a>
            <a href="<?php echo BASE_URL; ?>?act=admin_orders" class="flex items-center gap-3 px-4 py-3 rounded hover:bg-gray-800 transition">
                <i class="fas fa-shopping-cart"></i> Đơn hàng
            </a>
        </div>
    </div>
    <div class="w-4/5 p-8">
        <div class="mb-8">
            <a href="<?php echo BASE_URL; ?>?act=admin_products" class="text-blue-600 hover:text-blue-800 flex items-center gap-2">
               <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>
        <div class="max-w-2xl">
            <h1 class="text-3xl font-bold mb-8">Thêm sản phẩm mới</h1>
            <?php if(isset($error)): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    <?php echo $error; ?>
                </div>
                <?php endif; ?>
                <form action="" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow p-8 space-y-6" >
                    <div>
                        <label for="" class="block text-sm font-semibold mb-2">Danh mục</label>
                        <select name="category_id" required class="w-full border border-gray-300 rounded-lg px-4 py-2" id="">
                            <option value="">-- Chọn danh mục --</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?php echo $cat['id']; ?>"><?php echo $cat['name']?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label for="" class="block text-sm font-semibold mb-2">Tên sản phẩm</label>
                        <input type="text" name="name" required class="w-full border border-gray-300 rounded-lg px-4 py-2">
                    </div>
                    <div>
                        <label for="" class="block text-sm font-semibold mb-2">Mô tả</label>
                        <textarea name="description" id="" rows="4" class="w-full border border-gray-300 rounded-lg px-4 py-2"></textarea>
                    </div>
                    <div>
                        <label for="" class="block text-sm font-semibold mb-2">Giá (đ)</label>
                        <input type="number" name="price" step="0.01" required class="w-full border border-gray-300 rounded-lg px-4 py-2">
                    </div>
                    <div>
                         <label for="" class="block text-sm font-semibold mb-2">URL Hình ảnh (hoặc tải lên)</label>
                         <input type="text" name="image_url" placeholder="https://..." class="w-full border border-gray-300 rounded-lg px-4 py-2">
                         <input type="file" name="image" id="" accept="image/*" class="w-full">
                    </div>
                    <div class="flex gap-4">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition">
                            Thêm sản phẩm
                        </button>
                        <a href="<?php echo BASE_URL; ?>?act=admin_products" class="bg-gray-300 hover:bg-gray-400 text-black px-6 py-2 rounded-lg transition">
                            Hủy
                        </a>
                    </div>
                </form>
        </div>
    </div>
</div>