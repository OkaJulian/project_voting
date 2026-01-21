<?php
class Vote {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function hasVoted($user_id) {
        $stmt = $this->conn->prepare(
            "SELECT id FROM votes WHERE user_id = ?"
        );
        $stmt->execute([$user_id]);
        return $stmt->fetch();
    }

    public function vote($user_id, $candidate_id) {
        $stmt = $this->conn->prepare(
            "INSERT INTO votes (user_id, candidate_id) VALUES (?, ?)"
        );
        return $stmt->execute([$user_id, $candidate_id]);
    }

    public function results() {
        return $this->conn->query(
            "SELECT c.name, COUNT(v.id) total_vote
             FROM candidates c
             LEFT JOIN votes v ON c.id = v.candidate_id
             GROUP BY c.id"
        )->fetchAll(PDO::FETCH_ASSOC);
    }
}
