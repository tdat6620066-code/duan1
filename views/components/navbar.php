<nav class="navbar bg-white shadow-sm fixed top-0 w-full z-50 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="<?= BASE_URL ?>" class="text-2xl font-bold text-gray-900">
                    SHOP TTAD
                </a>
            </div>

            <!-- Navigation Links -->
            <div class="hidden md:block">
                <div class="ml-10 flex items-baseline space-x-4">
                    <a href="<?= BASE_URL ?>" class="text-gray-900 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200">Trang chủ</a>
                    <a href="?act=products" class="text-gray-900 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200">Sản phẩm</a>
                    <?php if (isset($_SESSION['user'])): ?>
                        <a href="?act=cart" class="text-gray-900 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200">Giỏ hàng</a>
                        <a href="?act=orders" class="text-gray-900 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200">Đơn hàng</a>
                         <a href="?act=profile" class="text-gray-900 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200">Liên hệ</a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Search Bar -->
            <div class="flex-1 max-w-lg mx-8 hidden md:block">
                <div class="relative">
                    <input type="text" id="search-input" placeholder="Tìm kiếm sản phẩm..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- User Menu -->
            <div class="flex items-center space-x-4">
                <?php if (isset($_SESSION['user'])): ?>
                    <div class="relative">
                        <button class="text-gray-900 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200">
                            <?= $_SESSION['user']['name'] ?>
                        </button>
                        <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10 hidden">
                            <a href="?act=logout" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Đăng xuất</a>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="?act=login" class="text-gray-900 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200">Đăng nhập</a>
                    <a href="?act=register" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors duration-200">Đăng ký</a>
                <?php endif; ?>
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden">
                <button class="text-gray-900 hover:text-blue-600 p-2">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</nav>