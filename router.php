<?php
use controllers\LoginController;
class Router
{
    public function __construct()
    { }
    public function choose_route($route)
    {
        $app_name="/chord-visualizer/";
        switch ($route) {
            case $app_name . "register/":
                include "./views/register/register.html";
                break;
            case $app_name . "tab_editor/":
                include "./views/tab_editor/tab_editor.html";

                break;
            default:
                require_once __DIR__ . '/controllers/login_Controller.php';
                $controller = new LoginController();
                $controller->index();
                break;
        }
    }
}