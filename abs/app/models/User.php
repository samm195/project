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
    public function getAllProfsPaginated($limit, $offset) {
    $sql = "SELECT * FROM users WHERE role = 'prof' ORDER BY nom ASC LIMIT :limit OFFSET :offset";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function countAllProfs() {
    $sql = "SELECT COUNT(*) FROM users WHERE role = 'prof'";
    return (int)$this->conn->query($sql)->fetchColumn();
}

public function searchProfs($search, $limit, $offset) {
    $sql = "SELECT * FROM users WHERE role = 'prof' AND (nom LIKE :search OR prenom LIKE :search OR email LIKE :search)
            ORDER BY nom ASC LIMIT :limit OFFSET :offset";
    $stmt = $this->conn->prepare($sql);
    $like = '%' . $search . '%';
    $stmt->bindParam(':search', $like);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function countProfsBySearch($search) {
    $sql = "SELECT COUNT(*) FROM users WHERE role = 'prof' AND (nom LIKE :search OR prenom LIKE :search OR email LIKE :search)";
    $stmt = $this->conn->prepare($sql);
    $like = '%' . $search . '%';
    $stmt->bindParam(':search', $like);
    $stmt->execute();
    return (int)$stmt->fetchColumn();
}
public function getStudentsPaginated($id_c, $limit, $offset) {
    $sql = "SELECT * FROM users WHERE role = 'etudiant'
 AND id_c = :id_c LIMIT :limit OFFSET :offset";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindValue(':id_c', $id_c, PDO::PARAM_INT);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function countStudentsInClass($id_c) {
    $sql = "SELECT COUNT(*) FROM users 
            WHERE role = 'etudiant'
 AND id_c = :id_c";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':id_c', $id_c, PDO::PARAM_INT);
    $stmt->execute();
    return (int)$stmt->fetchColumn();
}
public function searchStudentsInClass($id_c, $search, $limit, $offset) {
    $sql = "SELECT * FROM users 
            WHERE role = 'etudiant' AND id_c = :id_c 
            AND (nom LIKE :search OR prenom LIKE :search OR email LIKE :search)
            ORDER BY nom ASC 
            LIMIT :limit OFFSET :offset";
    $stmt = $this->conn->prepare($sql);
    $like = '%' . $search . '%';
    $stmt->bindParam(':id_c', $id_c, PDO::PARAM_INT);
    $stmt->bindParam(':search', $like, PDO::PARAM_STR);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
public function countStudentsInClassBySearch($id_c, $search) {
    $sql = "SELECT COUNT(*) FROM users 
           WHERE role = 'etudiant' AND id_c = :id_c 
            AND (nom LIKE :search OR prenom LIKE :search OR email LIKE :search)";
    $stmt = $this->conn->prepare($sql);
    $like = '%' . $search . '%';
    $stmt->bindParam(':id_c', $id_c, PDO::PARAM_INT);
    $stmt->bindParam(':search', $like, PDO::PARAM_STR);
    $stmt->execute();
    return (int)$stmt->fetchColumn();
}
public function getProfsInClassPaginated($id_c, $limit, $offset) {
    $sql = "SELECT * FROM users 
            WHERE role = 'prof' AND id_c = :id_c 
            ORDER BY nom ASC 
            LIMIT :limit OFFSET :offset";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindValue(':id_c', $id_c, PDO::PARAM_INT);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
public function searchProfsInClass($id_c, $search, $limit, $offset) {
    $sql = "SELECT * FROM users 
            WHERE role = 'prof' AND id_c = :id_c 
            AND (nom LIKE :search OR prenom LIKE :search OR email LIKE :search)
            ORDER BY nom ASC 
            LIMIT :limit OFFSET :offset";
    $stmt = $this->conn->prepare($sql);
    $like = '%' . $search . '%';
    $stmt->bindParam(':id_c', $id_c, PDO::PARAM_INT);
    $stmt->bindParam(':search', $like, PDO::PARAM_STR);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
public function countProfsInClass($id_c) {
    $sql = "SELECT COUNT(*) FROM users 
            WHERE role = 'prof' AND id_c = :id_c";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':id_c', $id_c, PDO::PARAM_INT);
    $stmt->execute();
    return (int)$stmt->fetchColumn();
}
public function countProfsInClassBySearch($id_c, $search) {
    $sql = "SELECT COUNT(*) FROM users 
            WHERE role = 'prof' AND id_c = :id_c 
            AND (nom LIKE :search OR prenom LIKE :search OR email LIKE :search)";
    $stmt = $this->conn->prepare($sql);
    $like = '%' . $search . '%';
    $stmt->bindParam(':id_c', $id_c, PDO::PARAM_INT);
    $stmt->bindParam(':search', $like, PDO::PARAM_STR);
    $stmt->execute();
    return (int)$stmt->fetchColumn();
}





}
