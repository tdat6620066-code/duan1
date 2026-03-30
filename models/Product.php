<?php

class Product{
     private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }
    public function getTop5Latest() {
        $query = "SELECT p.*, c.name as category_name FROM products p JOIN categories c ON p.category_id = c.id ORDER BY p.created_at DESC LIMIT 5";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}