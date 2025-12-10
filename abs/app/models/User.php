<?php
class User {
    public $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    // Get user by email and password (login)
    public function login($email, $password) {
        $sql = "SELECT * FROM users WHERE email = :email AND password = :password LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password); // plain text for now
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Get user by ID
    public function getById($id_u) {
        $sql = "SELECT * FROM users WHERE id_u = :id_u LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_u', $id_u);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Get all users by role (e.g., all profs)
    public function getByRole($role) {
        $sql = "SELECT * FROM users WHERE role = :role";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':role', $role);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updatePhoto($id, $file) {
        $stmt = $this->conn->prepare("UPDATE users SET photo = ? WHERE id_u = ?");
        return $stmt->execute([$file, $id]);
    }

    public function updateProf($id, $nom, $prenom, $email, $matiere) {
        $sql = "UPDATE users SET nom = :nom, prenom = :prenom, email = :email, matiere = :matiere 
                WHERE id_u = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':email' => $email,
            ':matiere' => $matiere,
            ':id' => $id
        ]);
    }

    public function updateStudent($id, $nom, $prenom, $email, $id_c) {
        $sql = "UPDATE users SET nom = :nom, prenom = :prenom, email = :email, id_c = :id_c
                WHERE id_u = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':email' => $email,
            ':id_c' => $id_c,
            ':id' => $id
        ]);
    }

    public function updateClass($id_c, $nom) {
        $sql = "UPDATE class SET nom = :nom WHERE id_c = :id_c";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':nom' => $nom,
            ':id_c' => $id_c
        ]);
    }




}
