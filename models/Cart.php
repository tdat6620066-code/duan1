<?php
class Cart
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getByUserId($userId)
    {
        $query = "SELECT * FROM carts WHERE user_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$userId]);
        return $stmt->fetch();
    }
    public function getCartItems($cartId)
    {
        $query = "SELECT ci.*, pv.size, p.name, p.price, p.image_url FROM cart_items ci 
              JOIN product_variants pv ON ci.product_variant_id = pv.id 
              JOIN products p ON pv.product_id = p.id 
              WHERE ci.cart_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$cartId]);
        return $stmt->fetchAll();
    }

    public function create($userId)
    {
        $query = "INSERT INTO carts (user_id) VALUES (?)";
        $stmt = $this->conn->prepare($query);
        $result = $stmt->execute([$userId]);
        if ($result) {
            return $this->conn->lastInsertId();
        }
        return false;
    }

    public function addItem($cartId, $variantId, $quantity)
    {

        $query = "SELECT * FROM cart_items WHERE cart_id = ? AND product_variant_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$cartId, $variantId]);
        $existing = $stmt->fetch();

        if ($existing) {

            $query = "UPDATE cart_items SET quantity = quantity + ? WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            return $stmt->execute([$quantity, $existing['id']]);
        } else {

            $query = "INSERT INTO cart_items (cart_id, product_variant_id, quantity) VALUES (?, ?, ?)";
            $stmt = $this->conn->prepare($query);
            return $stmt->execute([$cartId, $variantId, $quantity]);
        }
    }

    public function updateItem($cartId, $variantId, $quantity)
    {
        $query = "UPDATE cart_items SET quantity = ? WHERE cart_id = ? AND product_variant_id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$quantity, $cartId, $variantId]);
    }

    public function removeItem($cartId, $variantId)
    {
        $query = "DELETE FROM cart_items WHERE cart_id = ? AND product_variant_id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$cartId, $variantId]);
    }

    public function clearCart($cartId)
    {
        $query = "DELETE FROM cart_items WHERE cart_id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$cartId]);
    }
}
