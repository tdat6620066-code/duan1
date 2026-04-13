<?php
class AdminController {
    private $productModel;
    private $categoryModel;
    private $contactModel;
    public function __construct()
    {
        if(session_status() !== PHP_SESSION_ACTIVE){
            session_start();
        }
        $db = connectDB();
        $this->productModel = new Product($db);
        $this->categoryModel = new Category($db);
        $this->contactModel = new Contact($db);
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
            $db = connectDB();
            $productModel = new Product($db);
            $variantModel = new ProductVariant($db);
            $result = $productModel->create($data);
            if($result){
                $productId = $db->lastInsertId();
                $defaultSizes = [38, 39, 40, 41, 42];
                foreach($defaultSizes as $size){
                    $stockValue = max(0, intval($_POST['stock_' . $size] ?? 10));
                    $variantModel->create([
                        'product_id' => $productId,
                        'size' => $size,
                        'stock' => $stockValue
                    ]);
                }
            
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
        $variantModel = new ProductVariant(connectDB());
        $variants = $variantModel->getByProductId($id);
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
                    foreach($variants as $variant){
                        $stockValues = $_POST['variant_stock'] ?? [];
                        $stockValue = max(0, intval($stockValues[$variant['id']] ?? $variant['stock']));
                        $variantModel->update($variant['id'], [
                            'size' => $variant['size'],
                            'stock' => $stockValue
                        ]);
                    }
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
    public function productDelete(){
        $id = (int)$_GET['id'] ?? 0;
        if($this->productModel->delete($id)){
            header('Location: ' . BASE_URL . '?act=admin_products');
            exit;
        }else {
            $_SESSION['error'] = 'Không thể xóa sản phẩm';
            header('Location: ' . BASE_URL . '?act=admin_products');
            exit;
        }
    }
    public function categories(){
        $categories = $this->categoryModel->getAll();
        require_once './views/admin/categories.php';
    }
    public function categoryCreate(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $data = [
                'name' => trim($_POST['name']),
                'description' => trim($_POST['description'])
            ];
            if($this->categoryModel->create($data)){
                header('Location: ' . BASE_URL . '?act=admin_categories');
                exit;
            }else {
                $error = 'Thêm danh mục thất bại';
            }
        }
        require_once './views/admin/category_create.php';
    }
    public function categoryEdit(){
        $id = (int)$_GET['id'] ?? 0;
        $category = $this->categoryModel->getById($id);
        if(!$category){
            header('Location: ' . BASE_URL . '?act=admin_categories');
            exit;
        }
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $data = [
                'name' => trim($_POST['name']),
                'description' => trim($_POST['description'])
            ];
            if($this->categoryModel->update($id, $data)){
                header('Location: ' . BASE_URL . '?act=admin_categories');
                exit;
            }else {
                $error = 'Cập nhật danh mục thất bại';
            }
        }
        require_once './views/admin/category_edit.php';
    }
    public function categoryDelete(){
        $id = (int)$_GET['id'] ?? 0;
        $productCount = $this->productModel->countByCategory($id);
        if($productCount > 0){
            $_SESSION['error'] = 'Không thể xóa danh mục vì hiện có ' . $productCount . ' sản phẩm thuộc danh mục này.';
            header('Location: ' . BASE_URL . '?act=admin_categories');
            exit;
        }
        if($this->categoryModel->delete($id)){
            header('Location: ' . BASE_URL . '?act=admin_categories');
            exit;
        }else {
            $_SESSION['error'] = 'Không thể xóa danh mục';
            header('Location: ' . BASE_URL . '?act=admin_categories');
            exit;
        }
    }
    public function contacts()
    {
        $contacts = $this->contactModel->getAll();
        require_once './views/admin/contacts.php';
    }
    public function contactShow(){
        $id = (int)($_GET['id'] ?? 0);
        $contact = $this->contactModel->getById($id);
        if(!$contact){
            $_SESSION['error'] = 'Không tìm thấy yêu cầu liên hệ';
            header('Location: ' . BASE_URL . '?act=admin_contacts');
            exit;
        }
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $status = trim($_POST['status'] ?? $contact['status']);
            $allowed = ['mới', 'đã xử lý', 'đã phản hồi'];
             if (!in_array($status, $allowed, true)) {
                $status = 'mới';
            }
            if($this->contactModel->updateStatus($id, $status)){
                $_SESSION['success'] = 'Cập nhật trạng thái liên hệ thành công';
                header('Location: ' . BASE_URL . '?act=admin_contact_show&id=' . $id);
                exit;
            }else {
                $_SESSION['error'] = 'Cập nhật trạng thái liên hệ thất bại';
                header('Location: ' . BASE_URL . '?act=admin_contract_show&id' . $id);
                exit;
            }
        }
        require_once './views/admin/contact_show.php';
    }
    public function contactDelete(){
        $id = (int)($_GET['id'] ?? 0);
        if($this->contactModel->delete($id)){
            $_SESSION['seccess'] = 'Xóa liên hệ thành công';
        }else {
            $_SESSION['error'] = 'Không thể xóa liên hệ ';
        }
        header('Location: ' . BASE_URL . '?act=admin_contacts');
        exit;
    }
}