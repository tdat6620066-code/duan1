<?php

class ProductController
{
    private $productModel;
    private $categoryModel;
    private $variantModel;

    public function __construct()
    {
        $db = connectDB();
        $this->productModel = new Product($db);
        $this->categoryModel = new Category($db);
        $this->variantModel = new ProductVariant($db);
    }

    public function index(){
        $products = $this->productModel->getAll();
        $categories = $this->categoryModel->getAll();
        require_once './views/user/products.php';
    }
}
