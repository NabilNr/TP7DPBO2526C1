<?php
require_once dirname(__DIR__) . '/config/db.php';

class Team {
    private $conn;
    private $table_name = "teams";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function readAll() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($name, $city) {
        $query = "INSERT INTO " . $this->table_name . " (name, city) VALUES (?, ?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$name, $city]);
    }

    public function update($id, $name, $city) {
        $query = "UPDATE " . $this->table_name . " SET name = ?, city = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$name, $city, $id]);
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }
}
?>