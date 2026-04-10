<?php
public function search($keyword) {
    $query = "SELECT p.*, c.name as category_name FROM products p JOIN categories c ON p.category_id = c.id WHERE p.name LIKE ? OR p.description LIKE ?";
    $stmt = $this->conn->prepare($query);
    $stmt->execute(['%' . $keyword . '%', '%' . $keyword . '%']);
    return $stmt->fetchAll();
}
public function getByCategory($categoryId) {
    $query = "SELECT p.*, c.name as category_name FROM products p JOIN categories c ON p.category_id = c.id WHERE p.category_id = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$categoryId]);
    return $stmt->fetchAll();
}