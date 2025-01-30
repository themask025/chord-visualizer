<?php
require_once (__DIR__ . '/./constants.php');

class Router
{

    public function __construct()
    { }

    private function use_default_controller()
    {
        require_once __DIR__ . '/controllers/home_controller.php';
        $controller = new HomeController();
        $controller->index();
    }

    public function choose_route($route)
    {

        $route = substr($route, strlen(BASE_PATH));
        $route = trim($route, '/');
        $route_arr = explode("/", $route);
        if (count($route_arr) == 0) {

            $this->use_default_controller();
        }
        else {
                    $controller_name = ucfirst($route_arr[0]) . 'Controller';
                    $controller_file = __DIR__ . '/controllers/' . strtolower($route_arr[0]) . '_controller.php';
                    if (file_exists($controller_file)) {
                        require_once $controller_file;

                        if (class_exists($controller_name)) {
                            $controller = new $controller_name();
                            $action = $route_arr[1] ?? 'index';
                            if (method_exists($controller, $action)) {
                                $controller->{$action}();
                            } else {
                                $this->use_default_controller();
                            }
                        } else {
                            $this->use_default_controller();
                        }
                    } else {
                        $this->use_default_controller();
                    }

        }
    }
}
