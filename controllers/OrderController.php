<?php

class OrderController {
    private $orderModel;
    private $cartModel;
    private $addressModel;

    public function __construct() {
        $db = connectDB();
        $this->orderModel = new Order($db);
        $this->cartModel = new Cart($db);
        $this->addressModel = new ShippingAddress($db);
    }

    public function checkout() {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASE_URL . '?act=login');
            exit;
        }

        $userId = $_SESSION['user']['id'];
        $cart = $this->cartModel->getByUserId($userId);
        if (!$cart) {
            header('Location: ' . BASE_URL . '?act=cart');
            exit;
        }

        $cartItems = $this->cartModel->getCartItems($cart['id']);
        $addresses = $this->addressModel->getByUserId($userId);

        $subtotal = 0;
        foreach ($cartItems as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        $shippingCost = SHIPPING_COST;
        $total = $subtotal + $shippingCost;

        $error = '';
        $selectedAddressId = null;
        $selectedPaymentMethod = 'cod';
        $newAddress = '';
        $newCity = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $selectedAddressId = (int)(($_POST['address_id'] ?? 0));
            $selectedPaymentMethod = $_POST['payment_method'] ?? 'cod';
            $newAddress = trim($_POST['new_address'] ?? '');
            $newCity = trim($_POST['new_city'] ?? '');
            $allowedMethods = ['cod', 'bank'];

            if (!$selectedAddressId) {
                if ($newAddress !== '' && $newCity !== '') {
                    $newAddressId = $this->addressModel->create([
                        'user_id' => $userId,
                        'address' => $newAddress,
                        'city' => $newCity
                    ]);
                    if ($newAddressId) {
                        $selectedAddressId = $newAddressId;
                        $addresses = $this->addressModel->getByUserId($userId);
                    } else {
                        $error = 'Không thể lưu địa chỉ giao hàng mới.';
                    }
                } else {
                    $error = 'Vui lòng chọn hoặc nhập địa chỉ giao hàng.';
                }
            }

            if ($selectedAddressId && $error === '') {
                $address = $this->addressModel->getById($selectedAddressId);
                if (!$address || $address['user_id'] != $userId) {
                    $error = 'Địa chỉ không hợp lệ.';
                }
            }

            if (empty($cartItems)) {
                $error = 'Giỏ hàng đang trống.';
            }

            if (!in_array($selectedPaymentMethod, $allowedMethods)) {
                $selectedPaymentMethod = 'cod';
            }

            if ($error === '') {
                $orderId = $this->orderModel->create($userId, $selectedAddressId, $cartItems, $shippingCost, $selectedPaymentMethod);
                if ($orderId) {
                    $this->cartModel->clearCart($cart['id']);
                    $_SESSION['success'] = 'Đặt hàng thành công. Mã đơn hàng: ' . $orderId;
                    header('Location: ' . BASE_URL . '?act=orders');
                    exit;
                }
                $error = 'Đặt hàng thất bại. Vui lòng thử lại.';
            }
        }

        require_once './views/user/checkout.php';
    }

    public function index() {
        session_start();
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASE_URL . 'login');
            exit;
        }

        $userId = $_SESSION['user']['id'];
        $orders = $this->orderModel->getByUserId($userId);
        require_once './views/user/orders.php';
    }

    public function show($id) {
        session_start();
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASE_URL . '?act=login');
            exit;
        }

        $order = $this->orderModel->getById($id);
        if (!$order || $order['user_id'] != $_SESSION['user']['id']) {
            header('Location: ' . BASE_URL . '?act=orders');
            exit;
        }

        $orderItems = $this->orderModel->getOrderItems($id);
        require_once './views/user/order_detail.php';
    }

    public function cancel($id) {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASE_URL . '?act=login');
            exit;
        }

        $_SESSION['error'] = 'Bạn không được phép thay đổi đơn hàng.';
        header('Location: ' . BASE_URL . '?act=orders');
        exit;
    }

    public function delete($id) {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASE_URL . '?act=login');
            exit;
        }

        $userId = $_SESSION['user']['id'];
        $order = $this->orderModel->getById($id);

        if (!$order || $order['user_id'] != $userId) {
            $_SESSION['error'] = 'Đơn hàng không tồn tại hoặc bạn không có quyền thực hiện.';
            header('Location: ' . BASE_URL . '?act=orders');
            exit;
        }

        if (in_array($order['status'], ['đang giao', 'đã giao'])) {
            $_SESSION['error'] = 'Không thể xóa đơn hàng đã được giao hoặc đang giao.';
            header('Location: ' . BASE_URL . '?act=orders');
            exit;
        }

        if ($this->orderModel->delete($id)) {
            $_SESSION['success'] = 'Đơn hàng đã được xóa thành công.';
        } else {
            $_SESSION['error'] = 'Xóa đơn hàng thất bại. Vui lòng thử lại.';
        }

        header('Location: ' . BASE_URL . '?act=orders');
        exit;
    }
}