<?php
include './views/components/admin_navbar.php';
?>
<div class="flex">
   <?php include './views/admin/admin_sidebar.php';?>
    <div class="w-4/5 p-8">
        <div class="mb-8">
            <a href="<?php echo BASE_URL; ?>?act=admin_products" class="text-blue-600 hover:text-blue-800 flex items-center gap-2">
               <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>
        <div class="max-w-4xl mx-auto">
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
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                        <h2 class="text-lg font-semibold mb-4">Tồn kho theo size</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <?php $defaultSizes = [38, 39, 40, 41, 42];?>
                            <?php foreach ($defaultSizes as $size):?>
                                <div>
                                    <label for="" class="block text-sm font-semibold mb-2">Size <?=  $size ?> </label>
                                    <input type="number" name="stock_<?= $size ?>" value="10" min="0" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                                </div>
                                <?php endforeach;?>
                        </div>
                        <p class="text-sm text-gray-500 mt-3">Điền số lượng tồn kho cho từng size, nếu để trống sẽ mặc định 10.</p>
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