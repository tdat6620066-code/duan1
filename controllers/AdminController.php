<?php
class AdminController {
    private $productModel;
    private $categoryModel;
    public function __construct()
    {
        if(session_status() !== PHP_SESSION_ACTIVE){
            session_start();
        }
        $db = connectDB();
        $this->productModel = new Product($db);
        $this->categoryModel = new Category($db);
    }
    public function products() {
        $products = $this->productModel->getAll();
        require_once './views/admin/products.php';
    }
    private function handleImageUpload($fileInputName) {
        if(isset($_FILES[$fileInputName]) && $_FILES[$fileInputName]['error'] === UPLOAD_ERR_OK){
            $file = $_FILES[$fileInputName];
            $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $allowed = ['jpg', 'jpeg', 'png', 'gif'];
            if(!in_array($extension, $allowed)){
                return null;
            }
            $uploadDir = 'uploads/products/';
            if(!is_dir($uploadDir)){
                mkdir($uploadDir, 0755, true);
            }
            $newName = uniqid('prod_', true) . '.' . $extension;
            $target = $uploadDir . $newName;
            if(move_uploaded_file($file['tmp_name'], $target)){
                return $target;
            }
        }
        return null;
    }
    public function productCreate() {
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $error = '';
            $category_id = (int)($_POST['category_id'] ?? 0);
            $name = trim($_POST['name'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $price = isset($_POST['price']) ? (float)$_POST['price'] : 0;
            $imageUrl = $this->handleImageUpload('image');
            if(!$imageUrl && !empty($_POST['image_url'])){
                $imageUrl = trim($_POST['image_url']);
            }
            if($category_id <=0){
                $error .= 'Vui lòng chọn danh mục.<br>';
            }
            if($name === ''){
                $error .= 'Vui lòng nhập tên sản phẩm.<br>';
            }
            if($description === ''){
                $error.= 'Vui lòng nhập mô tả.<br>';
            }
            if($price <= 0){
                $error .= 'Giá phải lớn hơn 0 .<br>';
            }
            if(empty($imageUrl)){
                $error .= 'Vui lòng chọn hoặc nhập hình ảnh .<br>';
            }
          if($error === ''){
              $data = [
                'category_id' => (int)$_POST['category_id'],
                'name' => trim($_POST['name']),
                'description' => trim($_POST['description']),
                'price' => (float)$_POST['price'],
                'image_url' => $imageUrl
            ];
            if($this->productModel->create($data)){
                header('Location: ' . BASE_URL . '?act=admin_products');
                exit;
            }else {
                $error = 'Thêm sản phẩm thất bại';
            }
          }
        }
        $categories = $this->categoryModel->getAll();
        require_once './views/admin/product_create.php';
    }
    public function productEdit(){
        $id = (int)$_GET['id'] ?? 0;
        $product = $this->productModel->getById($id);
        if(!$product){
            header('Location: ' . BASE_URL . '?act=admin_products');
            exit;
        }
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $error = '';
            $category_id = (int)($_POST['category_id'] ?? 0);
            $name = trim($_POST['name'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $price = isset($_POST['price']) ? (float)$_POST['price'] : 0;
            $imageUrl = $this->handleImageUpload('image');
            if(!$imageUrl){
                $imageUrl = trim($_POST['image_url'] ?? $product['image_url'] ?? '');
            }
            if($category_id <= 0){
                $error .= 'Vui lòng chọn danh mục.<br>';
            }
            if($name === ''){
                $error .= 'Vui lòng chọn tên sản phẩm.<br>';
            }
            if($description === ''){
                $error .= 'Vui lòng nhập mô tả.<br>';
            }
            if($price <=0){
                $error .= 'Giá phải lớn hơn 0 .<br>';
            }
            if(empty($imageUrl)){
                $error .= 'Vui lòng chọn hình ảnh.<br>';
            }
            if($error === ''){
                $data = [
                    'id' => $id,
                    'category_id' => $category_id,
                    'name' => $name,
                    'description' => $description,
                    'price' => $price,
                    'image_url' => $imageUrl,
                ];
                if($this->productModel->update($id, $data)){
                    header('Location: ' . BASE_URL . '?act=admin_products');
                    exit;
                }else {
                    $error = 'Cập nhật sản phẩm thất bại';
                }
            }
        }
        $categories = $this->categoryModel->getAll();
        require_once './views/admin/product_edit.php';
    }
}