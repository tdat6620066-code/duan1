<?php
class Contact {
    private $conn;
    public function __construct($db)
    {
        $this->conn = $db;
    }
    public function create($data){
        $query = "INSERT INTO contacts (user_id, name, email, phone, subject, message, status) VALUES (?,?,?,?,?,?,?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            $data['user_id'] ?? null,
            $data['name'],
            $data['email'],
            $data['phone'] ?? null,
            $data['subject'],
            $data['message'],
            $data['status'] ?? 'mới',
        ]);
    }
        public function getAll(){
            $query = "SELECT c.*,u.name as user_name, u.email as user_email FROM contacts c LEFT JOIN users u ON c.user_id = u.id ORDER BY c.created_at DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll();
        }
         public function getById($id) {
        $query = "SELECT c.*, u.name as user_name, u.email as user_email FROM contacts c LEFT JOIN users u ON c.user_id = u.id WHERE c.id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
public function updateStatus($id, $status){
    $query = "UPDATE contacts SET status = ? WHERE id = ?";
    $stmt = $this->conn->prepare($query);
    return $stmt->execute([$status, $id]);
}
    }
