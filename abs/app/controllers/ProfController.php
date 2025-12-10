<?php
class ProfController extends Controller {
    private $profClassModel;

    public function __construct() {
        $this->profClassModel = $this->model('ProfClass');
        Session::init();
        if(Session::get('role') != 'prof') {
            header('Location: index.php?controller=Login&action=index');
            exit;
        }
    }

    // Prof dashboard: list classes
    public function index() {
        $id_p = Session::get('id_u');

        /*var_dump($id_p);*/

        $classes = $this->profClassModel->getClassesByProf($id_p);
        $data = ['classes' => $classes];
        $this->view('prof/dashboard', $data);
    }

    public function logout() {
        Session::destroy();
        header('Location: index.php?controller=Login&action=index');
    }

    public function faireAppel() {
        $id_c = $_GET['id_c']; // class ID from URL
        $id_p = Session::get('id_u'); // current professor ID

        // Load students of the class
        $classModel = $this->model('ClassModel');
        $students = $classModel->getStudents($id_c);

        // Load Absence model
        $absenceModel = $this->model('Absence');

        // If form submitted
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            foreach($_POST['status'] as $id_e => $status) {
                if($status == 'absent') {
                    $datetime = date('Y-m-d H:i:s');
                    $absenceModel->add($datetime, $id_p, $id_e);
                }
            }
            $data['success'] = "Attendance saved successfully.";
        }

        $data['students'] = $students;
        $data['id_c'] = $id_c;

        $this->view('prof/faire_appel', $data);
    }
}