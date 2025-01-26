<?php
use controllers\LoginController;
class Router
{
    public function __construct()
    { }

    private function use_default_controller()
    {
        require_once __DIR__ . '/controllers/login_Controller.php';
        $controller = new LoginController();
        $controller->index();
    }

    public function choose_route($route)
    {
        $route_arr = explode("/", $route);
        # route is separated to '' 'chord-visualizer' <controller_name> ....
        # this is a validation of the route length
        if (count($route_arr) < 3) {
            $this->use_default_controller();
        }
        else {
            switch ($route_arr[2]) {
                case "register":
                    include "./views/register/register.php";
                    break;
                case "tab_editor":
                    include "./views/tab_editor/tab_editor.html";

                    break;
                default:
                    $this->use_default_controller();
                    break;
            }
        }
    }
}