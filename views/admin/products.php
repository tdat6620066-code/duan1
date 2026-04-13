<?php
include './views/components/admin_navbar.php';
 
?>
<div class="flex pt-16">
<?php include './views/admin/admin_sidebar.php';?>
<div class="w-4/5 p-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold">Quản lý sản phẩm</h1>
        <a href="<?php echo BASE_URL; ?>?act=admin_product_create" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition">
            +Thêm sản phẩm
        </a>
    </div>
    <?php if(isset($_SESSION['error'])):?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            <?php echo $_SESSION['error']; unset($_SESSION['error']);?>
        </div>
        <?php endif; ?>
        <div class="bg-white rounded-lg shadow overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-100 border-b">
                        <th class="px-6 py-3 text-left text-sm font-semibold">ID</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold w-20">Hình ảnh</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Tên sản phẩm</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Giá</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Danh mục</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Ngày tạo</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product) :?>
                        <tr class="border-b hover:bg-gray-50 align-middle">
                            <td class="px-6 py-4 text-sm align-middle"><?php echo $product['id'];?></td>
                            <td class="px-6 py-4 text-sm align-middle w-20">
                                <?php if(!empty($product['image_url'])):?>
                                    <img src="<?php echo BASE_URL . $product['image_url'] ;?>" alt="<?php echo $product['name'];?>" class="w-16 h-16 object-cover rounded" style="min-width: 60px; min-height: 60px;">
                                <?php else:?>
                                    <span class="text-gray-400 italic">Không có ảnh</span>
                                <?php endif;?>
                            </td>
                            <td class="px-6 py-4 text-sm "><?php echo $product['name'];?></td>
                            <td class="px-6 py-4 text-sm font-semibold"><?php echo number_format($product['price'], 0).' đ';?></td>
                            <td class="px-6 py-4 text-sm "><?php echo $product['category_name'];?></td>
                            <td class="px-6 py-4 text-sm "><?php echo date('d/m/Y', strtotime($product['created_at']));?></td>
                            <td class="px-6 py-4 text-sm flex gap-2"> 
                               <a href="<?php echo BASE_URL; ?>?act=admin_product_edit&id=<?php echo $product['id'];?>"
                               class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-xs transition">
                            Sửa
                            </a>
                            <a href="<?php echo BASE_URL; ?>?act=admin_product_delete&id=<?php echo $product['id'];?>"
                            onclick="return confirm('Bạn chắc chắn muốn xóa không?')"
                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs transition">
                        Xóa
                        </a>
                            </td>
                        </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>
</div>
</div>
