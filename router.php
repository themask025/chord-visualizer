<?php


class Router
{
    public function __construct()
    { }

    private function use_default_controller()
    {
        require_once __DIR__ . '/controllers/login_controller.php';
        $controller = new LoginController();
        $controller->login();
    }

    public function choose_route($route)
    {
        $route = trim($route, '/');
        $route_arr = explode("/", $route);
        # route is separated to 'chord-visualizer' <controller_name> ....
        # this is a validation of the route length
        if (count($route_arr) < 2) {

            echo count($route_arr);
            $this->use_default_controller();
        }
        else {

            switch ($route_arr[1]) {
                case "register":
                    include "./views/register/register.php";
                    break;
                default:
                    $controller_name = ucfirst($route_arr[1]) . 'Controller';
                    $controller_file = __DIR__ . '/controllers/' . strtolower($route_arr[1]) . '_controller.php';
                    if (file_exists($controller_file)) {
                        require_once $controller_file;
                        if (class_exists($controller_name)) {
                            $controller = new $controller_name();
                            $action = $route_arr[2] ?? 'index';
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
                    break;
            }
        }
    }
}