<?php 

// Require file Common
require_once './commons/env.php'; // Khai báo biến môi trường
require_once './commons/function.php'; // Hàm hỗ trợ

// Require toàn bộ file Controllers
require_once './controllers/HomeController.php';
require_once './controllers/AuthController.php';
require_once './controllers/ProductController.php';
require_once './controllers/CartController.php';
require_once './controllers/OrderController.php';
require_once './controllers/AdminController.php';

// Start session
session_set_cookie_params(0, '/duan1/');
session_start();

// Require toàn bộ file Models
require_once './models/Product.php';
require_once './models/Category.php';
require_once './models/User.php';
require_once './models/Cart.php';
require_once './models/Order.php';
require_once './models/Contact.php';
require_once './models/ProductVariant.php';

require_once './models/ShippingAddress.php';


// Route
$act = $_GET['act'] ?? '/';

switch ($act) {
    // Trang chủ
    case '/':
        (new HomeController())->home();
        break;
    
    // Auth
    case 'login':
        (new AuthController())->login();
        break;
    case 'register':
        (new AuthController())->register();
        break;
    case 'logout':
        (new AuthController())->logout();
        break;
    
    // Products
    case 'products':
        (new ProductController())->index();
        break;
    case 'product':
        $id = $_GET['id'] ?? 0;
        (new ProductController())->show($id);
        break;
    case 'search':
        (new ProductController())->search();
        break;
    case 'category':
        $id = $_GET['id'] ?? 0;
        (new ProductController())->category($id);
        break;
    
    // Cart
    case 'cart':
        (new CartController())->index();
        break;
    case 'cart_add':
        (new CartController())->add();
        break;
    case 'cart_update':
        (new CartController())->update();
        break;
    case 'cart_remove':
        (new CartController())->remove();
        break;
    
    // Orders
    case 'checkout':
        (new OrderController())->checkout();
        break;
    case 'orders':
        (new OrderController())->index();
        break;
    case 'order':
        $id = $_GET['id'] ?? 0;
        (new OrderController())->show($id);
        break;
    case 'order_cancel':
        $id = $_GET['id'] ?? 0;
        (new OrderController())->cancel($id);
        break;
    case 'order_delete':
        $id = $_GET['id'] ?? 0;
        (new OrderController())->delete($id);
        break;
    
    // Admin
    case 'admin':
        (new AdminController())->dashboard();
        break;
    
    case 'admin_products':
    case 'admin-products':
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
    
    case 'admin_categories':
    case 'admin-categories':
        (new AdminController())->categories();
        break;
    
    case 'admin_category_create':
    case 'admin-category-create':
        (new AdminController())->categoryCreate();
        break;
    
    case 'admin_category_edit':
    case 'admin-category-edit':
        (new AdminController())->categoryEdit();
        break;
    
    case 'admin_category_delete':
    case 'admin-category-delete':
        (new AdminController())->categoryDelete();
        break;
    
    case 'admin_users':
    case 'admin-users':
        (new AdminController())->users();
        break;
    
    case 'admin_user_edit':
    case 'admin-user-edit':
        (new AdminController())->userEdit();
        break;
    
    case 'admin_user_delete':
    case 'admin-user-delete':
        (new AdminController())->userDelete();
        break;
    
    case 'admin_orders':
    case 'admin-orders':
        (new AdminController())->orders();
        break;
    
    case 'admin_order_show':
    case 'admin-order-show':
        (new AdminController())->orderShow();
        break;
    
    case 'admin_order_update_status':
    case 'admin-order-update-status':
        (new AdminController())->orderUpdateStatus();
        break;
    
    case 'admin_order_delete':
    case 'admin-order-delete':
        (new AdminController())->orderDelete();
        break;
    
    case 'admin_contacts':
    case 'admin-contacts':
        (new AdminController())->contacts();
        break;
    
    case 'admin_contact_show':
    case 'admin-contact-show':
        (new AdminController())->contactShow();
        break;
    
    case 'admin_contact_delete':
    case 'admin-contact-delete':
        (new AdminController())->contactDelete();
        break;
    
    case 'profile':
        (new AuthController())->profile();
        break;
    
    case 'contact':
        (new AuthController())->contact();
        break;
    
    default:
        (new HomeController())->home();
        break;
};