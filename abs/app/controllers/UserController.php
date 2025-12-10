<?php
class UserController extends Controller {

    public function profile() {
        $userModel = $this->model('User');
        $id = Session::get('id_u');

        /*echo "<pre>DEBUG ID: ";
        var_dump($id);
        echo "</pre>";*/

        $user = $userModel->getById($id);

        /*echo "<pre>DEBUG USER: ";
        var_dump($user);
        echo "</pre>";*/

        $this->view('user/profile', ['user' => $user]);

 

    }

    public function uploadPhoto() {
        $id = Session::get('id_u');

        if (!empty($_FILES['photo']['name'])) {
            $targetDir = __DIR__ . "/../../public/uploads/";
            $fileName = time() . "_" . basename($_FILES['photo']['name']);
            $targetFile = $targetDir . $fileName;

            move_uploaded_file($_FILES['photo']['tmp_name'], $targetFile);

            $userModel = $this->model('User');
            $userModel->updatePhoto($id, $fileName);
        }

        header("Location: index.php?controller=User&action=profile");
    }
}
