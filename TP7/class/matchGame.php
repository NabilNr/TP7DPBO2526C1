<?php
require_once dirname(__DIR__) . '/config/db.php';

class MatchGame {
    private $conn;
    private $table_name = "matches";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function readAll() {
        $query = "SELECT m.id, m.match_date, m.home_team_id, m.away_team_id, m.score_home, m.score_away, 
                         t1.name as home_team, t2.name as away_team 
                  FROM " . $this->table_name . " m 
                  JOIN teams t1 ON m.home_team_id = t1.id 
                  JOIN teams t2 ON m.away_team_id = t2.id 
                  ORDER BY m.match_date DESC";
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

    public function create($match_date, $home_team_id, $away_team_id, $score_home, $score_away) {
        $query = "INSERT INTO " . $this->table_name . " (match_date, home_team_id, away_team_id, score_home, score_away) 
                  VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$match_date, $home_team_id, $away_team_id, $score_home, $score_away]);
    }

    public function update($id, $match_date, $home_team_id, $away_team_id, $score_home, $score_away) {
        $query = "UPDATE " . $this->table_name . " SET match_date = ?, home_team_id = ?, away_team_id = ?, score_home = ?, score_away = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$match_date, $home_team_id, $away_team_id, $score_home, $score_away, $id]);
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }
}
?>