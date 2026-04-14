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
    public function dashboard() {
        $db = connectDB();
        
        // Get statistics
        $stats = [];
        // Total revenue
        $query = "SELECT SUM(total_price) as total_revenue FROM orders";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $stats['total_revenue'] = $stmt->fetch()['total_revenue'] ?? 0;

        // Total orders
        $query = "SELECT COUNT(*) as total_orders FROM orders";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $stats['total_orders'] = $stmt->fetch()['total_orders'] ?? 0;

        // Total products
        $query = "SELECT COUNT(*) as total_products FROM products";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $stats['total_products'] = $stmt->fetch()['total_products'] ?? 0;

        // Total users
        $query = "SELECT COUNT(*) as total_users FROM users WHERE role_id = 2";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $stats['total_users'] = $stmt->fetch()['total_users'] ?? 0;

        // Top selling products
        $query = "SELECT p.id, p.name, COALESCE(SUM(oi.quantity), 0) as quantity_sold, COALESCE(SUM(oi.price * oi.quantity), 0) as revenue 
                  FROM products p 
                  LEFT JOIN product_variants pv ON pv.product_id = p.id
                  LEFT JOIN order_items oi ON oi.product_variant_id = pv.id
                  GROUP BY p.id, p.name
                  ORDER BY quantity_sold DESC
                  LIMIT 5";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $stats['top_products'] = $stmt->fetchAll();

        // Recent orders
        $query = "SELECT o.*, u.name as user_name FROM orders o 
                  JOIN users u ON o.user_id = u.id 
                  ORDER BY o.created_at DESC LIMIT 10";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $stats['recent_orders'] = $stmt->fetchAll();

        // Revenue history for chart (last 7 days)
        $startDate = date('Y-m-d', strtotime('-6 days'));
        $endDate = date('Y-m-d');
        $query = "SELECT DATE(created_at) as order_date, SUM(total_price) as total_revenue 
                  FROM orders 
                  WHERE DATE(created_at) BETWEEN ? AND ? 
                  GROUP BY DATE(created_at) 
                  ORDER BY DATE(created_at) ASC";
                  $stmt = $db->prepare($query);
        $stmt->execute([$startDate, $endDate]);
        $revenueRows = $stmt->fetchAll();
        $revenueMap = [];
        foreach ($revenueRows as $row) {
            $revenueMap[$row['order_date']] = (float)$row['total_revenue'];
        }

        $stats['revenue_history'] = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-{$i} days"));
            $stats['revenue_history'][] = [
                'date' => $date,
                'revenue' => $revenueMap[$date] ?? 0
            ];
        }

        // Order status counts for chart
        $query = "SELECT status, COUNT(*) as count FROM orders GROUP BY status";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $stats['order_status_counts'] = [];
        foreach ($stmt->fetchAll() as $row) {
            $stats['order_status_counts'][$row['status']] = (int)$row['count'];
        }

        require_once './views/admin/dashboard.php';
    }

    // User Management
    public function users() {
        $db = connectDB();
        
        $query = "SELECT u.*, r.name as role_name FROM users u 
                  JOIN roles r ON u.role_id = r.id 
                  ORDER BY u.id DESC";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $users = $stmt->fetchAll();
        
        require_once './views/admin/users.php';
    }

    public function userEdit() {
        $id = (int)$_GET['id'] ?? 0;
        $user = $this->userModel->getById($id);
        
        if (!$user) {
            header('Location: ' . BASE_URL . '?act=admin_users');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'id' => $id,
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'phone' => trim($_POST['phone']),
                'role_id' => (int)$_POST['role_id']
            ];

            $query = "UPDATE users SET name = ?, email = ?, phone = ?, role_id = ? WHERE id = ?";
            $db = connectDB();
            $stmt = $db->prepare($query);
            if ($stmt->execute([$data['name'], $data['email'], $data['phone'], $data['role_id'], $id])) {
                header('Location: ' . BASE_URL . '?act=admin_users');
                exit;
            } else {
                $error = 'Cập nhật người dùng thất bại';
            }
        }

        $db = connectDB();
        $query = "SELECT * FROM roles";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $roles = $stmt->fetchAll();

        require_once './views/admin/user_edit.php';
    }

    public function userDelete() {
        $id = (int)$_GET['id'] ?? 0;
        
        // Prevent deleting yourself
        if ($id === $_SESSION['user']['id']) {
            $_SESSION['error'] = 'Không thể xóa chính mình';
            header('Location: ' . BASE_URL . '?act=admin_users');
            exit;
        }

        $query = "DELETE FROM users WHERE id = ? AND role_id != 1";
        $db = connectDB();
        $stmt = $db->prepare($query);
        if ($stmt->execute([$id])) {
            header('Location: ' . BASE_URL . '?act=admin_users');
            exit;
        } else {
            $_SESSION['error'] = 'Không thể xóa người dùng';
            header('Location: ' . BASE_URL . '?act=admin_users');
            exit;
        }
    }

    // Order Management
    public function orders() {
        $db = connectDB();
        
        $query = "SELECT o.*, u.name as user_name, u.email as user_email FROM orders o 
                  JOIN users u ON o.user_id = u.id 
                  ORDER BY o.created_at DESC";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $orders = $stmt->fetchAll();
        
        require_once './views/admin/orders.php';
    }

    private function getOrderStatusTransitions() {
        return [
            'chờ xác nhận' => ['đã xác nhận', 'đã hủy'],
            'đã xác nhận' => ['đang giao', 'đã hủy'],
            'đang giao' => ['đã giao'],
            'đã giao' => [],
            'đã hủy' => []
        ];
    }

    public function orderShow() {
        $id = (int)$_GET['id'] ?? 0;
        $db = connectDB();
        
        // Get order info
        $query = "SELECT o.*, u.name as user_name, u.email as user_email, u.phone as user_phone FROM orders o 
                  JOIN users u ON o.user_id = u.id 
                  WHERE o.id = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$id]);
        $order = $stmt->fetch();
        
        if (!$order) {
            header('Location: ' . BASE_URL . '?act=admin_orders');
            exit;
        }

        // Get order items
        $query = "SELECT oi.*, pv.size, p.name as product_name FROM order_items oi 
                  JOIN product_variants pv ON oi.product_variant_id = pv.id 
                  JOIN products p ON pv.product_id = p.id 
                  WHERE oi.order_id = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$id]);
        $order_items = $stmt->fetchAll();

        // Get shipping address
        $query = "SELECT * FROM shipping_addresses WHERE id = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$order['address_id']]);
        $shipping_address = $stmt->fetch();

        // Get payment info
        $query = "SELECT * FROM payments WHERE order_id = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$id]);
        $payment = $stmt->fetch();
        
        $statusTransitions = $this->getOrderStatusTransitions();
        $currentStatus = $order['status'];
        $nextStatuses = $statusTransitions[$currentStatus] ?? [];

        require_once './views/admin/order_show.php';
    }

    public function orderUpdateStatus() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $order_id = (int)$_POST['order_id'];
            $status = trim(mb_strtolower($_POST['status']));
            $statusMap = [
                'pending' => 'chờ xác nhận',
                'confirmed' => 'đã xác nhận',
                'shipped' => 'đang giao',
                'delivered' => 'đã giao',
                'cancelled' => 'đã hủy',
                'chờ xác nhận' => 'chờ xác nhận',
                'đã xác nhận' => 'đã xác nhận',
                'đang giao' => 'đang giao',
                'đã giao' => 'đã giao',
                'đã hủy' => 'đã hủy'
            ];

            $status = $statusMap[$status] ?? null;
            if ($status === null) {
                $status = 'chờ xác nhận';
            }

            $db = connectDB();
            $query = "SELECT status FROM orders WHERE id = ?";
            $stmt = $db->prepare($query);
            $stmt->execute([$order_id]);
            $currentOrder = $stmt->fetch();

            if (!$currentOrder) {
                $_SESSION['error'] = 'Đơn hàng không tồn tại.';
                header('Location: ' . BASE_URL . '?act=admin_orders');
                exit;
            }

            $currentStatus = $currentOrder['status'];
            $allowedTransitions = $this->getOrderStatusTransitions();
            $allowedNext = $allowedTransitions[$currentStatus] ?? [];

            if (!in_array($status, $allowedNext, true)) {
                $_SESSION['error'] = 'Không thể chuyển trạng thái từ "' . $currentStatus . '" sang "' . $status . '".';
                header('Location: ' . BASE_URL . '?act=admin_order_show&id=' . $order_id);
                exit;
            }

            $query = "UPDATE orders SET status = ? WHERE id = ?";
            $stmt = $db->prepare($query);

            if ($stmt->execute([$status, $order_id])) {
                $_SESSION['success'] = 'Cập nhật trạng thái thành công';
                header('Location: ' . BASE_URL . '?act=admin_order_show&id=' . $order_id);
                exit;
            } else {
                $_SESSION['error'] = 'Cập nhật trạng thái thất bại';
                header('Location: ' . BASE_URL . '?act=admin_order_show&id=' . $order_id);
                exit;
            }
        }
    }

    public function orderDelete() {
        $id = (int)$_GET['id'] ?? 0;
        $db = connectDB();
        
        // Delete cascading
        $query = "DELETE FROM order_items WHERE order_id = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$id]);
        
        $query = "DELETE FROM payments WHERE order_id = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$id]);
        
        $query = "DELETE FROM orders WHERE id = ?";
        $stmt = $db->prepare($query);
        
        if ($stmt->execute([$id])) {
            $_SESSION['success'] = 'Xóa đơn hàng thành công';
            header('Location: ' . BASE_URL . '?act=admin_orders');
            exit;
        } else {
            $_SESSION['error'] = 'Không thể xóa đơn hàng';
            header('Location: ' . BASE_URL . '?act=admin_orders');
            exit;
        }
    }
}
