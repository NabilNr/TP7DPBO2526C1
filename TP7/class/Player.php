<?php
require_once dirname(__DIR__) . '/config/db.php';

class Player {
    private $conn;
    private $table_name = "players";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function readAll() {
        $query = "SELECT p.id, p.name, p.position, p.team_id, t.name as team_name 
                  FROM " . $this->table_name . " p 
                  LEFT JOIN teams t ON p.team_id = t.id 
                  ORDER BY p.id DESC";
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

    public function create($name, $position, $team_id) {
        $query = "INSERT INTO " . $this->table_name . " (name, position, team_id) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$name, $position, $team_id]);
    }

    public function update($id, $name, $position, $team_id) {
        $query = "UPDATE " . $this->table_name . " SET name = ?, position = ?, team_id = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$name, $position, $team_id, $id]);
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }
}
?>