<?php
class Absence {
    public $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    // Get absences for a student
    public function getByStudent($id_e) {
        $sql = "SELECT a.*, u.matiere AS prof_matiere, u.nom AS prof_nom, u.prenom AS prof_prenom
                FROM absence a
                INNER JOIN users u ON a.id_p = u.id_u
                WHERE a.id_e = :id_e
                ORDER BY a.datetime DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_e', $id_e);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Add an absence
    public function add($datetime, $id_p, $id_e) {
        $sql = "INSERT INTO absence (datetime, id_p, id_e) VALUES (:datetime, :id_p, :id_e)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':datetime', $datetime);
        $stmt->bindParam(':id_p', $id_p);
        $stmt->bindParam(':id_e', $id_e);
        return $stmt->execute();
    }

    // delete an absence
    public function delete($id_a) {
        $sql = "DELETE FROM absence WHERE id_a = :id_a";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_a', $id_a);
        return $stmt->execute();
    }

}