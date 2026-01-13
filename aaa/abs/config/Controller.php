<?php
class Controller {
    // Load a view and pass data
    public function view($view, $data = []) {
        // $data is an associative array
        extract($data);
        require_once "../app/views/{$view}.php";
    }

    // Load a model
    public function model($model) {
        require_once "../app/models/{$model}.php";
        return new $model();
    }

    public function dashboardLink() {
        $role = Session::get('role');

        if ($role == 'admin') {
            return "index.php?controller=Admin&action=index";
        }
        if ($role == 'prof') {
            return "index.php?controller=Prof&action=index";
        }
        return "index.php?controller=Etudiant&action=index";
    }

}
