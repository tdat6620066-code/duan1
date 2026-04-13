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
            <h1 class="text-3xl font-bold mb-8">Cập nhật sản phẩm</h1>
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
                                <option value="<?php echo $cat['id']; ?>"
                                <?php echo $product['category_id'] == $cat['id'] ? 'selected' : ''; ?>>
                                <?php echo $cat['name']?>
                            
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label for="" class="block text-sm font-semibold mb-2">Tên sản phẩm</label>
                        <input type="text" name="name" value="<?php echo $product['name']; ?>" required 
                        class="w-full border border-gray-300 rounded-lg px-4 py-2">
                    </div>
                    <div>
                        <label for="" class="block text-sm font-semibold mb-2">Mô tả</label>
                        <textarea name="description" id="" rows="4" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                        <?php echo $product['description'] ?? '';?>

                        </textarea>
                    </div>
                    <div>
                        <label for="" class="block text-sm font-semibold mb-2">Giá (đ)</label>
                        <input type="number" name="price" step="0.01" value="<?php echo $product['price'];?>" 
                        required class="w-full border border-gray-300 rounded-lg px-4 py-2">
                    </div>
                    <div>
                         <label for="" class="block text-sm font-semibold mb-2">URL Hình ảnh (hoặc tải lên)</label>
                          <input type="text" name="image_url" placeholder="https://..." class="w-full border border-gray-300 rounded-lg px-4 py-2 mb-2" value="<?= htmlspecialchars($product['image_url'] ?? '') ?>">
                         <input type="file" name="image" id="" accept="image/*" class="w-full">
                           <img src="<?php echo BASE_URL . $product['image_url'] ;?>" alt="<?php echo $product['name'];?>" class="w-16 h-16 object-cover rounded" style="min-width: 200px; min-height: 200px;">
                    </div>
                    <?php if(!empty($variants)):?>
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                            <h2 class="text-lg font-semibold mb-4">Tồn kho theo size</h2>
                            <div class="space-y-4">
                                <?php foreach($variants as $variant):?>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                                        <div>
                                            <label for="" class="block text-sm font-semibold mb-2">Size</label>
                                            <input type="text" value="<?=  htmlspecialchars($variant['size']) ?>" disabled class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-white">
                                        </div>
                                        <div class="md:col-span-2">
                                            <label for="" class="block text-sm font-semibold mb-2">Số lượng</label>
                                            <input type="number" name="variant_stock[<?=  $variant['id'] ?>]" value="<?=  htmlspecialchars($variant['stock']) ?>" min="0"  class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-white">
                                        </div>
                                    </div>
                                    <?php endforeach;?>
                            </div>
                            <p class="text-sm text-gray-500 mt-3">Cập nhật số lượng tồn kho từng size của sản phẩm</p>
                        </div>
                        <?php endif;?>
                    <div class="flex gap-4">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition">
                           Cập nhật
                        </button>
                        <a href="<?php echo BASE_URL; ?>?act=admin_products" class="bg-gray-300 hover:bg-gray-400 text-black px-6 py-2 rounded-lg transition">
                            Hủy
                        </a>
                    </div>
                </form>
        </div>
    </div>
</div>