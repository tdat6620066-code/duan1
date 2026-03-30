<?php

class HomeController{

private $productModel;

public function __construct()
{
    $db = connectDB();
    $this->productModel = new Product($db);
}

public function home(){
    $top5ProductLatest = $this->productModel->getTop5Latest();
    require_once './views/user/home.php';
}
}