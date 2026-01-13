<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
class LoginController extends Controller {

    private $userModel;

    public function __construct() {
        $this->userModel = $this->model('User');
    }

    // Show login form
    public function index() {
        $this->view('login');
    }

    // Process login
    public function login() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $user = $this->userModel->login($email, $password);

            if($user) {
                // Store info in session
                Session::set('id_u', $user['id_u']);
                Session::set('role', $user['role']);
                Session::set('nom', $user['nom']);
                Session::set('prenom', $user['prenom']);

                /*echo "<pre>";
                echo "SESSION NOW:\n";
                var_dump($_SESSION);
                echo "</pre>";
                exit;*/


                // Load PHPMailer
                require_once __DIR__ .'/../mail/PHPMailer/src/Exception.php';
                require_once __DIR__ .'/../mail/PHPMailer/src/PHPMailer.php';
                require_once __DIR__ .'/../mail/PHPMailer/src/SMTP.php';

                $user_name = $user['prenom'].' '.$user['nom'];
                $role = $user['role'];
                $admins = $this->userModel->getByRole('admin');
                
                if ($admins && count($admins) > 0) {
                  $admin = $admins[0];
                  $mail = new PHPMailer(true);

                  try {
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'yomn00811@gmail.com';
                    $mail->Password = 'wwhtmgcgqdffyahy';
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port = 587;
                    $mail->setFrom('yomn00811@gmail.com', 'mail');
                    $mail->addAddress($admin['email']);
                    $mail->isHTML(true);
                    $mail->Subject = 'Login Notification';
                    $mail->Body = "$user_name ($role) just logged in at " . date('Y-m-d H:i:s');
                    $mail->send();
                   } catch (Exception $e) {
                       error_log("Mail Error: " . $e->getMessage());
                   }
                }



                // Redirect based on role
                if($user['role'] == 'admin') {
                    header('Location: index.php?controller=Admin&action=index');
                    exit;
                } elseif($user['role'] == 'prof') {
                    header('Location: index.php?controller=Prof&action=index');
                    exit;
                } else {
                    header('Location: index.php?controller=Etudiant&action=index');
                    exit;
                }
            } else {
                $data['error'] = "Invalid email or password.";
                $this->view('login', $data);
            }
        }
    }

    // Logout
    public function logout() {
        Session::destroy();
        header('Location: index.php?controller=Login&action=index');
        exit;
    }
}