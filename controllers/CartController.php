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
        session_start();
        if (!isset($_SESSION['user'])) {
            echo json_encode(['success' => false, 'message' => 'Vui lòng đăng nhập']);
            exit;
        }
        $userId = $_SESSION['user']['id'];
        $variantId = $_POST['variant_id'];
        $quantity = $_POST['quantity'] ?? 1;

        $cart = $this->cartModel->getByUserId($userId);
        if (!$cart) {
            $cartId = $this->cartModel->create($userId);
        } else {
            $cartId = $cart['id'];
        }

        if ($this->cartModel->addItem($cartId, $variantId, $quantity)) {
            echo json_encode(['success' => true, 'message' => 'Đã thêm vào giỏ hàng']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Thêm thất bại']);
        }
    }

    public function update()
    {
        session_start();
        if (!isset($_SESSION['user'])) {
            echo json_encode(['success' => false]);
            exit();
        }
        $userId = $_SESSION['user']['id'];
        $variantId = $_SESSION['variant_id'];
        $quantity = $_SESSION['quantity'];

        $cart = $this->cartModel->getByUserId($userId);
        if ($cart && $this->cartModel->updateItem($cart['id'], $variantId, $quantity)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
    }

    public function remove()
    {
        session_start();
        if (!isset($_SESSION['user'])) {
            echo json_encode(['success' => false]);
            exit;
        }

        $userId = $_SESSION['user']['id'];
        $variantId = $_POST['variant_id'];

        $cart = $this->cartModel->getByUserId($userId);
        if ($cart && $this->cartModel->removeItem($cart['id'], $variantId)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
    }
}
