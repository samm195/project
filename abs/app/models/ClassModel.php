<?php
class ClassModel {
    public $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    // Get all classes
    public function getAll() {
        $sql = "SELECT * FROM class";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get students in a class
    public function getStudents($id_c) {
        $sql = "SELECT * FROM users WHERE role='etudiant' AND id_c=:id_c";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_c', $id_c);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAvailableProfsForClass($id_c) {
        $sql = "
            SELECT * FROM users 
            WHERE role = 'prof'
            AND id_u NOT IN (
                SELECT id_p FROM prof_class WHERE id_c = :id_c
            )
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_c', $id_c);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function assignProfToClass($id_p, $id_c) {
        $sql = "INSERT INTO prof_class (id_p, id_c) VALUES (:id_p, :id_c)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id_p' => $id_p, ':id_c' => $id_c]);
    }


    public function removeProfFromClass($id_p, $id_c) {
        $sql = "DELETE FROM prof_class WHERE id_p = :id_p AND id_c = :id_c";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id_p' => $id_p, ':id_c' => $id_c]);
    }


    public function getProfsByClass($id_c) {
        $sql = "SELECT u.* FROM users u
                INNER JOIN prof_class pc ON u.id_u = pc.id_p
                WHERE pc.id_c = :id_c";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_c', $id_c);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id_c) {
        $sql = "SELECT * FROM class WHERE id_c = :id_c";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_c', $id_c);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllClasses() {
        $sql = "SELECT * FROM class";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

     // Update class name
    public function updateClass($id_c, $nom) {
        $sql = "UPDATE class SET nom = :nom WHERE id_c = :id_c";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':id_c', $id_c);
        $stmt->execute();
    }
}