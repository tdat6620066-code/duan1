<?php 

// Require file Common
require_once './commons/env.php'; // Khai báo biến môi trường
require_once './commons/function.php'; // Hàm hỗ trợ

// Require toàn bộ file Controllers
require_once './controllers/HomeController.php';

// Require toàn bộ file Models
require_once './models/Product.php';

// Route
$act = $_GET['act'] ?? '/';

switch ($act) {
    // Trang chủ
    case '/':
        (new HomeController())->home();
        break;
    case 'search':
        (new ProductController())->search();
        break;
    case 'category':
        $id = $_GET['id'] ?? 0;
        (new ProductController())->category($id);
        break;
};