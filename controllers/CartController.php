<?php

class CartController
{
    private $cartModel;

    public function __construct()
    {
        $db = connectDB();
        $this->cartModel = new Cart($db);
    }

    public function index()
    {
        session_start();
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASE_URL . 'login');
            exit();
        }

        $userId = $_SESSION['user']['id'];
        $cart = $this->cartModel->getByUserId($userId);
        $cartItems = [];
        if ($cart) {
            $cartItems = $this->cartModel->getCartItems($cart['id']);
        }
        require_once './views/user/cart.php';
    }

    public function add()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        header('Content-Type: application/json');
        if (!isset($_SESSION['user'])) {
            echo json_encode(['success' => false, 'message' => 'Vui lòng đăng nhập']);
            exit;
        }
        $userId = $_SESSION['user']['id'];
        $variantId = $_POST['variant_id'] ?? null;
        $quantity = $_POST['quantity'] ?? 1;

        if (!$variantId) {
            echo json_encode(['success' => false, 'message' => 'Vui lòng chọn kích cỡ']);
            exit;
        }

        $cart = $this->cartModel->getByUserId($userId);
        if (!$cart) {
            $cartId = $this->cartModel->create($userId);
        } else {
            $cartId = $cart['id'];
        }

        if ($this->cartModel->addItem($cartId, $variantId, $quantity)) {
            echo json_encode(['success' => true, 'message' => 'Đã thêm vào giỏ hàng']);
            exit;
        } else {
            echo json_encode(['success' => false, 'message' => 'Thêm thất bại']);
            exit;
        }
    }

    public function update()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        header('Content-Type: application/json');
        if (!isset($_SESSION['user'])) {
            echo json_encode(['success' => false]);
            exit();
        }
        $userId = $_SESSION['user']['id'];
        $variantId = $_POST['variant_id'] ?? null;
        $quantity = $_POST['quantity'] ?? 1;

        if (!$variantId) {
            echo json_encode(['success' => false, 'message' => 'Thiếu mã kích cỡ sản phẩm']);
            exit;
        }

        $cart = $this->cartModel->getByUserId($userId);
        if ($cart && $this->cartModel->updateItem($cart['id'], $variantId, $quantity)) {
            $cartItems = $this->cartModel->getCartItems($cart['id']);
            $subtotal = 0;
            $lineTotal = 0;
            foreach ($cartItems as $item) {
                $subtotal += $item['price'] * $item['quantity'];
                if ($item['product_variant_id'] == $variantId) {
                    $lineTotal = $item['price'] * $item['quantity'];
                }
            }
            echo json_encode([
                'success' => true,
                'subtotal' => $subtotal,
                'shipping' => SHIPPING_COST,
                'line_total' => $lineTotal
            ]);
            exit;
        } else {
            echo json_encode(['success' => false]);
            exit;
        }
    }

    public function remove()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        header('Content-Type: application/json');
        if (!isset($_SESSION['user'])) {
            echo json_encode(['success' => false]);
            exit;
        }

        $userId = $_SESSION['user']['id'];
        $variantId = $_POST['variant_id'] ?? null;

        if (!$variantId) {
            echo json_encode(['success' => false, 'message' => 'Thiếu mã kích cỡ sản phẩm']);
            exit;
        }

        $cart = $this->cartModel->getByUserId($userId);
        if ($cart && $this->cartModel->removeItem($cart['id'], $variantId)) {
            echo json_encode(['success' => true]);
            exit;
        } else {
            echo json_encode(['success' => false]);
            exit;
        }
    }
}
