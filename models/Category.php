<?php
class Category {
    private $conn;
    public function __construct($db)
    {
        $this->conn = $db;
    }
    public function getAll(){
        $query = "SELECT * FROM categories ORDER BY name";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function getById($id){
        $query = "SELECT * FROM categories WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}