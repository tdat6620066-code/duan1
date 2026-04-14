<?php


require_once './commons/env.php';
require_once './commons/function.php';


require_once './controllers/HomeController.php';
require_once './controllers/AuthController.php';
require_once './controllers/CartController.php';
require_once './controllers/OrderController.php';

require_once './models/Product.php';
require_once './models/User.php';
require_once './models/Cart.php';
require_once './models/Order.php';



require_once './controllers/AdminController.php';
require_once './controllers/OrderController.php';


 session_set_cookie_params(0, '/duan1');
 session_start();
// Require toàn bộ file Models
require_once './models/Product.php';
require_once './models/Category.php';
require_once './models/Order.php';
require_once './models/User.php';
require_once './models/ShippingAddress.php';
require_once './models/ProductVariant.php';
require_once './models/Contact.php';
require_once './models/Payment.php';
// Route
$act = $_GET['act'] ?? '/';

switch ($act) {

    case '/':
        (new HomeController())->home();
        break;

    case 'login':
        (new AuthController())->login();
        break;

    case 'register':
        (new AuthController())->register();
        break;
    case 'logout':
        (new AuthController())->logout();
        break;
    case 'cart':
        (new CartController())->index();
        break;
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
};
   
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
    case 'admin_categories':
        case 'admin_categories':
            (new AdminController())->categories();
            break;
    case 'admin_category_create':
        case 'admin_category_create':
            (new AdminController())->categoryCreate();
            break;
    case 'admin_category_edit':
        case 'admin_category_edit':
            (new AdminController())->categoryEdit();
            break;
    case 'admin_category_delete':
        case 'admin_category_delete':
            (new AdminController())->categoryDelete();
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
    // Orders
    
    case 'admin_user_delete':
    case 'admin-user-delete':
        (new AdminController())->userDelete();
        break;
    
     case 'admin_users':
    case 'admin-users':
        (new AdminController())->users();
        break;
    
    case 'admin_user_edit':
    case 'admin-user-edit':
        (new AdminController())->userEdit();
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
    case 'admin':
        (new AdminController())->dashboard();
        break;   
};
