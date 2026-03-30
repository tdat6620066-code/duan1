<?php 

// Require file Common
require_once './commons/env.php'; // Khai báo biến môi trường
require_once './commons/function.php'; // Hàm hỗ trợ

// Require toàn bộ file Controllers
require_once './controllers/HomeController.php';
require_once './controllers/AdminController.php';

 session_set_cookie_params(0, '/duan1');
 session_start();
// Require toàn bộ file Models
require_once './models/Product.php';
require_once './models/Category.php';
// Route
$act = $_GET['act'] ?? '/';

switch ($act) {
    // Trang chủ
    case '/':
        (new HomeController())->home();
        break;
   
    case 'admin_products':
    case 'admin-products';
        (new AdminController())->products();
        break;
    case 'admin_product_create':
        case 'admin-product-create':
            (new AdminController())->productCreate();
            break;
    case 'admin_product_edit':
        case 'admin-product-edit':
            (new AdminController())->productEdit();
            break;
    case 'admin_product_delete':
        case 'admin-product-delete':
            (new AdminController())->productDelete();
            break;
};