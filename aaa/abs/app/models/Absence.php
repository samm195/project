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
        // Insert absence
        $sql = "INSERT INTO absence (datetime, id_p, id_e)
                VALUES (:datetime, :id_p, :id_e)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':datetime', $datetime);
        $stmt->bindParam(':id_p', $id_p);
        $stmt->bindParam(':id_e', $id_e);
        $stmt->execute();

        // Get subject (matiere) of professor
        $sql = "SELECT matiere FROM users WHERE id_u = :id_p";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_p', $id_p);
        $stmt->execute();
        $matiere = $stmt->fetchColumn();

        // Count absences
        $count = $this->countByStudentAndSubject($id_e, $matiere);

        // If limit exceeded → email student
        if ($count > 9) {
            $sql = "SELECT email, prenom, nom FROM users WHERE id_u = :id_e";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id_e', $id_e);
            $stmt->execute();
            $student = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($student) {
                $this->sendEliminationEmail(
                    $student['email'],
                    $student['prenom'].' '.$student['nom'],
                    $matiere
                );
            }
        }
    }


    // delete an absence
    public function delete($id_a) {
        $sql = "DELETE FROM absence WHERE id_a = :id_a";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_a', $id_a);
        return $stmt->execute();
    }

    public function countByStudentAndSubject($id_e, $matiere) {
        $sql = "
            SELECT COUNT(*) 
            FROM absence a
            JOIN users p ON a.id_p = p.id_u
            WHERE a.id_e = :id_e
            AND p.matiere = :matiere
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_e', $id_e);
        $stmt->bindParam(':matiere', $matiere);
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }

    public function sendEliminationEmail($studentEmail, $studentName, $matiere) {
      require_once __DIR__ . '/../mail/PHPMailer/src/Exception.php';
      require_once __DIR__ . '/../mail/PHPMailer/src/PHPMailer.php';
      require_once __DIR__ . '/../mail/PHPMailer/src/SMTP.php';


        $mail = new PHPMailer\PHPMailer\PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'yomn00811@gmail.com';
            $mail->Password = 'wwhtmgcgqdffyahy';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('yomn00811@gmail.com', 'Absence System');
            $mail->addAddress($studentEmail);

            $mail->isHTML(true);
            $mail->Subject = 'Subject Elimination Notice';

            $mail->Body = "
                Cher/Chère $studentName,<br><br>

                Vous avez dépassé le nombre autorisé de <strong>9 absences</strong> dans la matière
                <strong>$matiere</strong>.<br><br>

                Conformément au règlement de l'établissement, vous êtes désormais
                <strong>éliminé(e)</strong> de cette matière.<br><br>

                Cordialement,<br>
                L'administration

            ";

            $mail->send();
        } catch (Exception $e) {
            // silent fail (recommended)
        }
    }
    public function getByStudentAndSubject($id_e, $subject) {
    $sql = "SELECT a.*, u.matiere AS prof_matiere, u.nom AS prof_nom, u.prenom AS prof_prenom
            FROM absence a
            INNER JOIN users u ON a.id_p = u.id_u
            WHERE a.id_e = :id_e AND u.matiere LIKE :subject
            ORDER BY a.datetime DESC";
    $stmt = $this->conn->prepare($sql);
    $like = '%' . $subject . '%';
    $stmt->bindParam(':id_e', $id_e);
    $stmt->bindParam(':subject', $like);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
   }
   public function getByStudentPaginated($id_e, $limit, $offset) {
    $sql = "SELECT a.*, u.matiere AS prof_matiere, u.nom AS prof_nom, u.prenom AS prof_prenom
            FROM absence a
            INNER JOIN users u ON a.id_p = u.id_u
            WHERE a.id_e = :id_e
            ORDER BY a.datetime DESC
            LIMIT :limit OFFSET :offset";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':id_e', $id_e, PDO::PARAM_INT);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
   }

public function getByStudentAndSubjectPaginated($id_e, $subject, $limit, $offset) {
    $sql = "SELECT a.*, u.matiere AS prof_matiere, u.nom AS prof_nom, u.prenom AS prof_prenom
            FROM absence a
            INNER JOIN users u ON a.id_p = u.id_u
            WHERE a.id_e = :id_e AND u.matiere LIKE :subject
            ORDER BY a.datetime DESC
            LIMIT :limit OFFSET :offset";
    $stmt = $this->conn->prepare($sql);
    $like = '%' . $subject . '%';
    $stmt->bindParam(':id_e', $id_e, PDO::PARAM_INT);
    $stmt->bindParam(':subject', $like, PDO::PARAM_STR);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function countByStudent($id_e) {
    $sql = "SELECT COUNT(*) FROM absence WHERE id_e = :id_e";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':id_e', $id_e);
    $stmt->execute();
    return (int)$stmt->fetchColumn();
}
public function getAbsencesByClass($id_c, $search = null, $limit = 10, $offset = 0) {
    $sql = "SELECT a.*, u.nom, u.prenom FROM absences a
            JOIN users u ON a.id_u = u.id_u
            WHERE u.role = 'etudiant' AND u.id_c = :id_c";

    if ($search) {
        $sql .= " AND (u.nom LIKE :search OR u.prenom LIKE :search)";
    }

    $sql .= " ORDER BY a.date DESC LIMIT :limit OFFSET :offset";

    $stmt = $this->conn->prepare($sql);
    $stmt->bindValue(':id_c', $id_c, PDO::PARAM_INT);
    if ($search) {
        $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
    }
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
public function countAbsencesByClass($id_c, $search = null) {
    $sql = "SELECT COUNT(*) FROM absences a
            JOIN users u ON a.id_u = u.id_u
            WHERE u.role = 'etudiant' AND u.id_c = :id_c";

    if ($search) {
        $sql .= " AND (u.nom LIKE :search OR u.prenom LIKE :search)";
    }

    $stmt = $this->conn->prepare($sql);
    $stmt->bindValue(':id_c', $id_c, PDO::PARAM_INT);
    if ($search) {
        $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
    }
    $stmt->execute();

    return (int)$stmt->fetchColumn();
}



}