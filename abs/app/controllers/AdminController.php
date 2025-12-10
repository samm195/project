<?php
class AdminController extends Controller {
    private $userModel;
    private $classModel;

    public function __construct() {
        $this->userModel = $this->model('User');
        $this->classModel = $this->model('ClassModel'); // class model
        Session::init();
        // Check if admin
        if(Session::get('role') != 'admin') {
            header('Location: index.php?controller=Login&action=index');
            exit;
        }
    }

    // Admin dashboard
    public function index() {
        $profs = $this->userModel->getByRole('prof');
        $classes = $this->classModel->getAll();
        $data = [
            'profs' => $profs,
            'classes' => $classes
        ];
        $this->view('admin/dashboard', $data);
    }

    // ---------------- Professors CRUD ----------------
    public function addProf() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $prenom = $_POST['prenom'];
            $nom = $_POST['nom'];
            $email = $_POST['email'];
            $matiere = $_POST['matiere'];
            $password = $_POST['password'];

            try {
                $sql = "INSERT INTO users (prenom, nom, email, password, role, matiere) 
                        VALUES (:prenom, :nom, :email, :password, 'prof', :matiere)";
                $stmt = $this->userModel->conn->prepare($sql);
                $stmt->bindParam(':prenom', $prenom);
                $stmt->bindParam(':nom', $nom);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':password', $password);
                $stmt->bindParam(':matiere', $matiere);
                $stmt->execute();

                header('Location: index.php?controller=Admin&action=index');
                exit;

            } catch (PDOException $e) {

                // Check if it is duplicate email error
                if ($e->getCode() == 23000) {
                    $error = "This email already exists. Please choose another.";
                } else {
                    $error = "An unexpected error occurred.";
                }

                // Return back to the form with message
                $this->view('admin/add_prof', ['error' => $error]);
                return;
            }
        }

        // Show empty form (GET)
        $this->view('admin/add_prof');
    }


    public function deleteProf() {
        $id_p = $_GET['id'];
        $sql = "DELETE FROM users WHERE id_u = :id";
        $stmt = $this->userModel->conn->prepare($sql);
        $stmt->bindParam(':id', $id_p);
        $stmt->execute();
        header('Location: index.php?controller=Admin&action=index');
    }

    public function editProf() {
        $id = $_GET['id'];

        $userModel = $this->model('User');
        $prof = $userModel->getById($id);

        $data = ['prof' => $prof];
        $this->view('admin/edit_prof', $data);
    }

    public function updateProf() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id_u'];
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $email = $_POST['email'];
            $matiere = $_POST['matiere'];

            $userModel = $this->model('User');
            $userModel->updateProf($id, $nom, $prenom, $email, $matiere);

            header("Location: index.php?controller=Admin&action=index");
            exit;
        }
    }


    // ---------------- Classes ----------------
    public function addClass() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = $_POST['nom'];
            $sql = "INSERT INTO class (nom) VALUES (:nom)";
            $stmt = $this->classModel->conn->prepare($sql);
            $stmt->bindParam(':nom', $nom);
            $stmt->execute();
            header('Location: index.php?controller=Admin&action=index');
        }
        $this->view('admin/add_class');
    }

    public function deleteClass() {
        $id_c = $_GET['id'];
        $sql = "DELETE FROM class WHERE id_c = :id";
        $stmt = $this->classModel->conn->prepare($sql);
        $stmt->bindParam(':id', $id_c);
        $stmt->execute();
        header('Location: index.php?controller=Admin&action=index');
    }

    public function addProfForm() {
        $id_c = $_GET['id_c'];

        $classModel = $this->model('ClassModel');
        $availableProfs = $classModel->getAvailableProfsForClass($id_c);

        $this->view('admin/add_prof_to_class', [
            'id_c' => $id_c,
            'profs' => $availableProfs
        ]);
    }

    public function addProfToClass() {
        $id_c = $_POST['id_c'];
        $id_p = $_POST['id_p'];

        $classModel = $this->model('ClassModel');
        $classModel->assignProfToClass($id_p, $id_c);

        header("Location: index.php?controller=Admin&action=showProfs&id_c=$id_c");
        exit;
    }

    public function removeProfFromClass() {
        $id_c = $_GET['id_c'];
        $id_p = $_GET['id_p'];

        $classModel = $this->model('ClassModel');
        $classModel->removeProfFromClass($id_p, $id_c);

        header("Location: index.php?controller=Admin&action=showProfs&id_c=$id_c");
        exit;
    }



    public function showProfs() {
        $id_c = $_GET['id_c'];

        $classModel = $this->model('ClassModel');

        // Get profs teaching this class
        $profs = $classModel->getProfsByClass($id_c);

        // Get profs NOT teaching this class (to add)
        $availableProfs = $classModel->getAvailableProfsForClass($id_c);

        $data = [
            'profs' => $profs,
            'availableProfs' => $availableProfs,
            'id_c' => $id_c
        ];

        $this->view('admin/show_profs', $data);
    }

    public function editClass() {
        $id_c = $_GET['id'];

        $classModel = $this->model('ClassModel');
        $class = $classModel->getById($id_c);

        $data = ['class' => $class];
        $this->view('admin/edit_class', $data);
    }

    public function updateClass() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_c = $_POST['id_c'];
            $nom = $_POST['nom'];

            $classModel = $this->model('ClassModel');
            $classModel->updateClass($id_c, $nom);

            header("Location: index.php?controller=Admin&action=index");
            exit;
        }
    }


    // ---------------- Students ----------------
    public function showStudents() {
        $id_c = $_GET['id'];
        $classModel = $this->classModel;
        $students = $classModel->getStudents($id_c);
        $data = ['students' => $students, 'id_c' => $id_c];
        $this->view('admin/students', $data);
    }

    public function addStudent() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $prenom = $_POST['prenom'];
            $nom = $_POST['nom'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $id_c = $_POST['id_c'];

            $sql = "INSERT INTO users (prenom, nom, email, password, role, id_c) 
                    VALUES (:prenom, :nom, :email, :password, 'etudiant', :id_c)";
            $stmt = $this->userModel->conn->prepare($sql);
            $stmt->bindParam(':prenom', $prenom);
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':id_c', $id_c);
            $stmt->execute();
            header('Location: index.php?controller=Admin&action=showStudents&id='.$id_c);
        }
        $id_c = $_GET['id_c'];
        $this->view('admin/add_student', ['id_c' => $id_c]);
    }

    public function deleteStudent() {
        $id_e = $_GET['id'];
        $id_c = $_GET['id_c'];
        $sql = "DELETE FROM users WHERE id_u = :id";
        $stmt = $this->userModel->conn->prepare($sql);
        $stmt->bindParam(':id', $id_e);
        $stmt->execute();
        header('Location: index.php?controller=Admin&action=showStudents&id='.$id_c);
    }

    public function editStudent() {
        $id = $_GET['id'];

        $userModel = $this->model('User');
        $student = $userModel->getById($id);

        $classModel = $this->model('ClassModel');
        $classes = $classModel->getAllClasses();

        $data = ['student' => $student, 'classes' => $classes];
        $this->view('admin/edit_student', $data);
    }

    public function updateStudent() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id_u'];
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $email = $_POST['email'];
            $id_c = $_POST['id_c']; // class

            $userModel = $this->model('User');
            $userModel->updateStudent($id, $nom, $prenom, $email, $id_c);

            header("Location: index.php?controller=Admin&action=index");
            exit;
        }
    }



    // Show absences of a student
    public function showAbsences() {
        $id_e = $_GET['id'];
        $absenceModel = $this->model('Absence');
        $absences = $absenceModel->getByStudent($id_e);
        $data = ['absences' => $absences, 'id_e' => $id_e];
        $this->view('admin/absences', $data);
    }

    // Delete a specific absence
    public function deleteAbsence() {
        $id_a = $_GET['id'];
        $id_e = $_GET['id_e'];
        $absenceModel = $this->model('Absence');
        $absenceModel->delete($id_a);
        header('Location: index.php?controller=Admin&action=showAbsences&id='.$id_e);
    }


    // Logout
    public function logout() {
        Session::destroy();
        header('Location: index.php?controller=Login&action=index');
    }
}
