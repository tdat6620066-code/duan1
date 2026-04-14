<?php
class ProductVariant {
    private $conn;
    public function __construct($db)
    {
        $this->conn = $db;
    }
    public function getByProductId($productId){
        $query = "SELECT * FROM product_variants WHERE product_id = ? ORDER BY size";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$productId]);
        return $stmt->fetchAll();
    }
    public function getById($id){
        $query = "SELECT * FROM product_variants WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    public function create($data){
        $query = "INSERT INTO product_variants (product_id, size, stock) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$data['product_id'], $data['size'], $data['stock']]);
    }
    public function update($id, $data){
        $query = "UPDATE product_variants SET size = ?, stock = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$data['size'], $data['stock'], $id]);
    }
    public function delete($id){
        $query = "DELETE FROM product_variants WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }
    public function decreaseStock($id, $quantity){
        $query = "UPDATE product_variants SET stock = stock - ? WHERE id = ? AND stock >= ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$quantity, $id, $quantity]);
    }
}