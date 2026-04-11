<div class="w-1/5 bg-gray-900 text-white p-6 min-h-screen">
    <div class="mb-12">
     <h2 class="text-sm font-semibold text-gray-400 mb-6">MENU CHÍNH</h2>
     <a href="<?php echo BASE_URL; ?>?act=admin" class="flex items-center gap-3 px-4 rounded hover:bg-gray-800 transition">
        <i class="fas fa-chart-line"></i> Dashboard
     </a>
     <a href="<?php echo BASE_URL;?>" class="flex items-center gap-3 px-4 py-3 rounded hover:bg-gray-800 transition">
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
        <a href="<?php echo BASE_URL; ?>?act=admin_users" class="flex items-center gap-3 px-4 py-3 rounded hover:bg-gray-800 transition">
            <i class="fas fa-users"></i> Người dùng
        </a>
        <a href="<?php echo BASE_URL; ?>?act=admin_orders" class="flex items-center gap-3 px-4 py-3 rounded hover:bg-gray-800 transition">
            <i class="fas fa-shopping-cart"></i> Đơn hàng
        </a>
        <a href="<?php echo BASE_URL; ?>?act=admin_contacts" class="flex items-center gap-3 px-4 py-3 rounded hover:bg-gray-800 transition">
            <i class="fas fa-envelope"></i> Liên hệ
        </a>
    </div>
</div>