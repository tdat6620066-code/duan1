<?php

class ProductController {
    private $productModel;
    private $categoryModel;
    private $variantModel;

    public function __construct(){
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

    public function show($id){
        $product = $this->productModel->getById($id);
        if (!$product) {
            header('Location: ' . BASE_URL . 'products');
            exit;
        }
        $variants = $this->varianModel->getByProductId($id);
        require_once './views/user/product_detail.php';
    }

    public function search(){
        $keyword = trim($_GET['q'] ?? '');
        $products = $this->productModel->search($ketword);
        $categories = $this->categoryModel->getAll();
        $searchQuery = $keyword;
        require_once './views/user/products.php';
    }

    public function category($categoryId){
        $products = $this->productModel->getByCategory($categoryId);
        $categories = $this->categoryModel->getAll();
        require_once './views/user/products.php';
    }
}
