<?php
class Router {
    public static function route($controller, $method = "index") {
        $controllerFile = "../app/controllers/{$controller}Controller.php";
        if(file_exists($controllerFile)) {
            require_once $controllerFile;
            $controllerClass = $controller . "Controller";
            $controllerInstance = new $controllerClass();
            if(method_exists($controllerInstance, $method)) {
                $controllerInstance->$method();
            } else {
                echo "Method {$method} not found in {$controller}";
            }
        } else {
            echo "Controller {$controller} not found";
        }
    }
}
