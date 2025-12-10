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
}
