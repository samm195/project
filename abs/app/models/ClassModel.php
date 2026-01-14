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
    public function getClassesByProfPaginated($id_p, $limit, $offset) {
    $sql = "SELECT c.* FROM class c
            INNER JOIN prof_class pc ON c.id_c = pc.id_c
            WHERE pc.id_p = :id_p
            ORDER BY c.nom ASC
            LIMIT :limit OFFSET :offset";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':id_p', $id_p, PDO::PARAM_INT);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function countClassesByProf($id_p) {
    $sql = "SELECT COUNT(*) FROM prof_class WHERE id_p = :id_p";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':id_p', $id_p);
    $stmt->execute();
    return (int)$stmt->fetchColumn();
}

public function getClassesByProfAndSearch($id_p, $search, $limit, $offset) {
    $sql = "SELECT c.* FROM class c
            INNER JOIN prof_class pc ON c.id_c = pc.id_c
            WHERE pc.id_p = :id_p AND c.nom LIKE :search
            ORDER BY c.nom ASC
            LIMIT :limit OFFSET :offset";
    $stmt = $this->conn->prepare($sql);
    $like = '%' . $search . '%';
    $stmt->bindParam(':id_p', $id_p, PDO::PARAM_INT);
    $stmt->bindParam(':search', $like, PDO::PARAM_STR);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function countClassesByProfAndSearch($id_p, $search) {
    $sql = "SELECT COUNT(*) FROM class c
            INNER JOIN prof_class pc ON c.id_c = pc.id_c
            WHERE pc.id_p = :id_p AND c.nom LIKE :search";
    $stmt = $this->conn->prepare($sql);
    $like = '%' . $search . '%';
    $stmt->bindParam(':id_p', $id_p);
    $stmt->bindParam(':search', $like);
    $stmt->execute();
    return (int)$stmt->fetchColumn();
}
public function getAllPaginated($limit, $offset) {
    $sql = "SELECT * FROM class ORDER BY nom ASC LIMIT :limit OFFSET :offset";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function countAll() {
    $sql = "SELECT COUNT(*) FROM class";
    return (int)$this->conn->query($sql)->fetchColumn();
}
public function getStudentsPaginated($id_c, $limit, $offset) {
    $sql = "SELECT * FROM users 
            WHERE role = 'etudiant' AND id_c = :id_c 
            ORDER BY nom ASC 
            LIMIT :limit OFFSET :offset";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':id_c', $id_c, PDO::PARAM_INT);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
public function countStudentsInClass($id_c) {
    $sql = "SELECT COUNT(*) FROM users WHERE role = 'etudiant' AND id_c = :id_c";
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
public function getProfsByClassPaginated($id_c, $limit, $offset) {
    $sql = "SELECT u.* FROM users u
            INNER JOIN prof_class pc ON u.id_u = pc.id_p
            WHERE pc.id_c = :id_c
            ORDER BY u.nom ASC
            LIMIT :limit OFFSET :offset";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':id_c', $id_c, PDO::PARAM_INT);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
public function countProfsInClass($id_c) {
    $sql = "SELECT COUNT(*) FROM prof_class WHERE id_c = :id_c";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':id_c', $id_c, PDO::PARAM_INT);
    $stmt->execute();
    return (int)$stmt->fetchColumn();
}
public function searchProfsInClass($id_c, $search, $limit, $offset) {
    $sql = "SELECT u.* FROM users u
            INNER JOIN prof_class pc ON u.id_u = pc.id_p
            WHERE pc.id_c = :id_c 
            AND (u.nom LIKE :search OR u.prenom LIKE :search OR u.email LIKE :search)
            ORDER BY u.nom ASC
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
public function countProfsInClassBySearch($id_c, $search) {
    $sql = "SELECT COUNT(*) FROM users u
            INNER JOIN prof_class pc ON u.id_u = pc.id_p
            WHERE pc.id_c = :id_c 
            AND (u.nom LIKE :search OR u.prenom LIKE :search OR u.email LIKE :search)";
    $stmt = $this->conn->prepare($sql);
    $like = '%' . $search . '%';
    $stmt->bindParam(':id_c', $id_c, PDO::PARAM_INT);
    $stmt->bindParam(':search', $like, PDO::PARAM_STR);
    $stmt->execute();
    return (int)$stmt->fetchColumn();
}


}