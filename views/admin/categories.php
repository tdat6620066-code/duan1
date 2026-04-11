<?php
include './views/components/admin_navbar.php';
?>
<div class="flex pt-16"> 
    <?php include './views/admin/admin_sidebar.php';?>
<div class="w-4/5 p-8">
  <div class="flex justify-between items-center mb-8">
    <h1 class="text-3xl font-bold">Quản lí danh mục</h1>
    <a href="<?php echo BASE_URL; ?>?act=admin_category_create" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition">
      + Thêm danh mục
    </a>
  </div>
  <?php if(isset($_SESSION['error'])): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
      <?php echo $_SESSION['error']; unset($_SESSION['error']);?>
    </div>
    <?php endif;?>
    <div class="bg-white rounded-lg shadow overflow-x-auto">
  <table class="w-full">
    <thead>
      <tr class="bg-gray-100 border-b">
        <th class="px-6 py-3 text-left text-sm font-semibold">ID</th>
        <th class="px-6 py-3 text-left text-sm font-semibold">Tên danh mục</th>
       
        <th class="px-6 py-3 text-left text-sm font-semibold">Ngày tạo</th>
        <th class="px-6 py-3 text-left text-sm font-semibold">Hành động</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($categories as $category): ?>
        <tr class="border-b hover:bg-gray-50">
          <td class="px-6 py-4 text-sm"><?php echo $category['id'];?></td>
          <td class="px-6 py-4 text-sm"><?php echo $category['name'];?></td>
         
          <td class="px-6 py-4 text-sm"><?php echo date('d/m/Y', strtotime($category['created_at'])); ?></td>
          <td class="px-6 py-4 text-sm flex gap-2">
            <a href="<?php echo BASE_URL; ?>?act=admin_category_edit&id=<?php echo $category['id'];?>"
           class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-xs transition">Sửa</a>
           <a href="<?php echo BASE_URL;?>?act=admin_category_delete&id=<?php echo $category['id']; ?>"
           onclick="return confirm('Bạn chắc chắn?')" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs transition">
          Xóa</a>
          </td>
          
        </tr>
        <?php endforeach;?>
    </tbody>
  </table>
</div>
</div>

</div>