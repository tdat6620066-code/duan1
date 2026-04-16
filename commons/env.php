<?php 

// Biến môi trường, dùng chung toàn hệ thống
// Khai báo dưới dạng HẰNG SỐ để không phải dùng $GLOBALS

define('BASE_URL'       , 'http://localhost/DA1_duyTung/');
define('BASE_URL_ADMIN' , 'http://localhost/DA1_duyTung/admin/');

define('DB_HOST'    , 'localhost');
define('DB_PORT'    , 3306);
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME'    , 'shop_giay');

define('SHIPPING_COST', 30000);
define('PATH_ROOT'    , __DIR__ . '/../');
