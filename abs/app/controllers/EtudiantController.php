<?php
class EtudiantController extends Controller {
    private $absenceModel;

    public function __construct() {
        $this->absenceModel = $this->model('Absence');
        Session::init();
        if(Session::get('role') != 'etudiant') {
            header('Location: index.php?controller=Login&action=index');
            exit;
        }
    }

    // Student dashboard: show absences
public function index() {
    $id_e = Session::get('id_u');
    $subject = $_GET['subject'] ?? null;
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = 6;
    $offset = ($page - 1) * $limit;

    if ($subject) {
        $absences = $this->absenceModel->getByStudentAndSubjectPaginated($id_e, $subject, $limit, $offset);
        $total = $this->absenceModel->countByStudentAndSubject($id_e, $subject);
    } else {
        $absences = $this->absenceModel->getByStudentPaginated($id_e, $limit, $offset);
        $total = $this->absenceModel->countByStudent($id_e);
    }

    $totalPages = ceil($total / $limit);

    $data = [
        'absences' => $absences,
        'subject' => $subject,
        'page' => $page,
        'totalPages' => $totalPages
    ];

    $this->view('etudiant/dashboard', $data);
}



    public function logout() {
        Session::destroy();
        header('Location: index.php?controller=Login&action=index');
    }
}