<?php
class ProfClass {
    public $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    // Get classes taught by a prof
    public function getClassesByProf($id_p) {
        $sql = "SELECT c.* FROM class c
                INNER JOIN prof_class pc ON c.id_c = pc.id_c
                WHERE pc.id_p = :id_p";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_p', $id_p);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Get paginated classes taught by a prof
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

// Count total classes for a prof
public function countClassesByProf($id_p) {
    $sql = "SELECT COUNT(*) FROM prof_class WHERE id_p = :id_p";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':id_p', $id_p);
    $stmt->execute();
    return (int)$stmt->fetchColumn();
}

// Get paginated + filtered classes by name
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

// Count filtered classes
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

}
