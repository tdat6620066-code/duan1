<?php 


require_once './commons/env.php';
require_once './commons/function.php'; 


require_once './controllers/HomeController.php';
require_once './controllers/AuthController.php';

require_once './models/Product.php';
require_once './models/User.php';

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
};