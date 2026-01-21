<?php
class Candidate {
    private $conn;
    private $table = "candidates";

    public function __construct($db) {
        $this->conn = $db;
    }

    // READ ALL
    public function getAll() {
        return $this->conn
            ->query("SELECT * FROM {$this->table}")
            ->fetchAll(PDO::FETCH_ASSOC);
    }

    // CREATE
    public function create($name, $vision, $mission) {
        $stmt = $this->conn->prepare(
            "INSERT INTO {$this->table} (name, vision, mission)
             VALUES (?, ?, ?)"
        );
        return $stmt->execute([$name, $vision, $mission]);
    }

    // UPDATE
    public function update($id, $name, $vision, $mission) {
        $stmt = $this->conn->prepare(
            "UPDATE {$this->table}
             SET name = ?, vision = ?, mission = ?
             WHERE id = ?"
        );
        return $stmt->execute([$name, $vision, $mission, $id]);
    }

    // DELETE
    public function delete($id) {
        $stmt = $this->conn->prepare(
            "DELETE FROM {$this->table} WHERE id = ?"
        );
        return $stmt->execute([$id]);
    }
}
