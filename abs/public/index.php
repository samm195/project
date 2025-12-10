<?php
require_once "../config/Database.php";
require_once "../config/Session.php";
require_once "../config/Controller.php";
require_once "../config/Router.php";

// Initialize session
Session::init();

// Default controller/action
$controller = isset($_GET['controller']) ? $_GET['controller'] : 'Login';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

// Route request
Router::route($controller, $action);
