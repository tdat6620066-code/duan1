<?php
class ShippingAddress
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getByUserId($userId)
    {
        $query = "SELECT * FROM shipping_addresses WHERE user_id = ? ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public function getById($id)
    {
        $query = "SELECT * FROM shipping_addresses WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($data)
    {
        $query = "INSERT INTO shipping_addresses (user_id, address, city) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        if ($stmt->execute([$data['user_id'], $data['address'], $data['city']])) {
            return $this->conn->lastInsertId();
        }
        return false;
    }

    public function update($id, $data)
    {
        $query = "UPDATE shipping_addresses SET address = ?, city = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$data['address'], $data['city'], $id]);
    }

    public function delete($id)
    {
        $query = "DELETE FROM shipping_addresses WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }
}
