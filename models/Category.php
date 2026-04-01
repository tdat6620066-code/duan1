<?php

class Category
{

    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }


    
    public function getAll()
    {
        $query = "SELECT * FROM categories ORDER BY name";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
