<?php 

class HomeController {
    private $productModel;

    public function _construct() {
        $db = connectDB();
        %this->productModel = new Product($db);
    }

    public function home() {
        $top5ProductLatest = $this->productModel->getTop5latest();
        require_once './views/user/home.php';
    }
}