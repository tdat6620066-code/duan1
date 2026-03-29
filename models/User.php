<?php
class User
{
    private $conn;
    public function __construct($db)
    {
        $this->conn = $db;
    }


    public function getAll()
    {
        $query = "SELECT u.*, r.name as role_name FROM users u JOIN roles r ON u.role_id = r.id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getById($id)
    {
        $query = "SELECT u.*, r.name as role_name FROM users u JOIN roles r ON u.role_id = r.id WHERE u.id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($data)
    {
        $query = "INSERT INTO users (role_id, name, email, password, phone) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$data['role_id'], $data['name'], $data['email'], password_hash($data['password'], PASSWORD_DEFAULT), $data['phone']]);
    }

    public function update($id, $data)
    {
        $query = "UPDATE users SET role_id = ?, name = ?, email = ?, phone = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$data['role_id'], $data['name'], $data['email'], $data['phone'], $id]);
    }

    public function delete($id)
    {
        $query = "DELETE FROM users WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
    }

    public function authenticate($email, $password)
    {
        $query = "SELECT u.*, r.name as role_name FROM users u JOIN roles r ON u.role_id = r.id WHERE u.email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }
}
