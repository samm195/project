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
        $absences = $this->absenceModel->getByStudent($id_e);
        $data = ['absences' => $absences];
        $this->view('etudiant/dashboard', $data);
    }

    public function logout() {
        Session::destroy();
        header('Location: index.php?controller=Login&action=index');
    }
}