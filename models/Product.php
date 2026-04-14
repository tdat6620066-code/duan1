<?php
class Product {
    private $conn;
    public function __construct($db)
    {
        $this->conn = $db;
    }
    public function getAll(){
        $query = "SELECT p.*, c.name as category_name FROM products p JOIN categories c ON p.category_id = c.id ORDER BY p.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function getById($id){
        $query = "SELECT p.*, c.name as category_name FROM products p JOIN categories c ON p.category_id = c.id WHERE p.id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    public function getTop5Latest(){
        $query = "SELECT p.*, c.name as category_name FROM products p JOIN categories c ON p.category_id = c.id ORDER BY p.created_at DESC LIMIT 5";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function create($data){
        $query = "INSERT INTO products (category_id, name, description, price, image_url) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$data['category_id'], $data['name'], $data['description'], $data['price'], $data['image_url']]);
    }
    public function update($id,$data){
        $query = "UPDATE products SET category_id = ?, name = ?, description = ?, price = ?, image_url = ? WHERE id = ? ";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$data['category_id'], $data['name'], $data['description'], $data['price'], $data['image_url'], $id]);
    }
    public function delete($id){
       try{
        $this->conn->beginTransaction();
        $query = "SELECT id FROM product_variants WHERE product_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        $variantIds = array_column($stmt->fetchAll(), 'id');
        if(!empty($variantIds)){
            $placeholders = implode(',', array_fill(0, count($variantIds), '?' ));
            $query = "DELETE FROM cart_items WHERE product_variant_id IN ($placeholders)";
            $stmt = $this->conn->prepare($query);
            $stmt->execute($variantIds);
            $query = "DELETE FROM order_items WHERE product_variant_id IN ($placeholders)";
            $stmt = $this->conn->prepare($query);
            $stmt->execute($variantIds);
        }
        // Xóa ảnh sản phẩm nếu có
        $query = "DELETE FROM product_images WHERE product_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        // Xóa các biến thể trước khi xóa sản phẩm
        $query = "DELETE FROM product_variants WHERE product_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);

         $query = "DELETE FROM products WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $result =  $stmt->execute([$id]);
        
        $this->conn->commit();
        return $result;

       }catch(PDOException $e){
        $this->conn->rollBack();
        return false;
       }
    }

    public function countByCategory($categoryId){
        $query = "SELECT COUNT(*) FROM products WHERE category_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$categoryId]);
        return (int) $stmt->fetchColumn();
    }
}
