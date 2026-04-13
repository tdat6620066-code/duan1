<?php

class Order {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Lấy tất cả orders
    public function getAll() {
        $query = "SELECT o.*, u.name as user_name, sa.address, sa.city FROM orders o 
                  JOIN users u ON o.user_id = u.id 
                  JOIN shipping_addresses sa ON o.address_id = sa.id 
                  ORDER BY o.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Lấy orders theo user
    public function getByUserId($userId) {
        $query = "SELECT o.*, sa.address, sa.city FROM orders o 
                  JOIN shipping_addresses sa ON o.address_id = sa.id 
                  WHERE o.user_id = ? ORDER BY o.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    // Lấy order theo ID
    public function getById($id) {
        $query = "SELECT o.*, u.name as user_name, sa.address, sa.city FROM orders o 
                  JOIN users u ON o.user_id = u.id 
                  JOIN shipping_addresses sa ON o.address_id = sa.id 
                  WHERE o.id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function getOrderItems($orderId) {
        $query = "SELECT oi.*, pv.size, p.name as product_name, p.image_url FROM order_items oi 
                  JOIN product_variants pv ON oi.product_variant_id = pv.id 
                  JOIN products p ON pv.product_id = p.id 
                  WHERE oi.order_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$orderId]);
        return $stmt->fetchAll();
    }

    // Tạo order mới từ giỏ hàng
    public function create($userId, $addressId, $cartItems, $shippingFee = 0, $paymentMethod = 'cod') {
        $this->conn->beginTransaction();
        try {
            // Tính tổng tiền sản phẩm
            $subtotal = 0;
            foreach ($cartItems as $item) {
                $subtotal += $item['price'] * $item['quantity'];
            }
            $total = $subtotal + $shippingFee;

            // Tạo order
            $query = "INSERT INTO orders (user_id, address_id, total_price) VALUES (?, ?, ?)";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$userId, $addressId, $total]);
            $orderId = $this->conn->lastInsertId();

            // Thêm order items và giảm stock
            foreach ($cartItems as $item) {
                $query = "INSERT INTO order_items (order_id, product_variant_id, quantity, price) VALUES (?, ?, ?, ?)";
                $stmt = $this->conn->prepare($query);
                $stmt->execute([$orderId, $item['product_variant_id'], $item['quantity'], $item['price']]);

                $stockQuery = "UPDATE product_variants SET stock = stock - ? WHERE id = ? AND stock >= ?";
                $stockStmt = $this->conn->prepare($stockQuery);
                $stockStmt->execute([$item['quantity'], $item['product_variant_id'], $item['quantity']]);
                if ($stockStmt->rowCount() === 0) {
                    throw new Exception('Không đủ hàng để đặt');
                }
            }

            // Tạo thông tin thanh toán
            $paymentStatus = 'pending';
            $query = "INSERT INTO payments (order_id, method, status) VALUES (?, ?, ?)";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$orderId, $paymentMethod, $paymentStatus]);

            $this->conn->commit();
            return $orderId;
        } catch (Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }

    // Cập nhật trạng thái order
    public function updateStatus($id, $status) {
        $query = "UPDATE orders SET status = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$status, $id]);
    }

    // Xóa order
    public function delete($id) {
        $query = "DELETE FROM orders WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }
}