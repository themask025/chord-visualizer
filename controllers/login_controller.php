<?php

require_once 'controller.php';

class LoginController extends Controller
{
    public $error;

    public function __construct()
    {
        $this->error = null;
    }

    public function index()
    {
        session_start();
        if (isset($_SESSION["user_id"]))
        {
            // header("Location: views/home/index.php");
            require_once "views/home/index.php";
            exit;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $username = $_POST['username'];

            $model = $this->loadModel("login");
            $user = $model->getUser($username);

            if($user != false)
            {
                if($_POST["password"] == $user["password"])
                {
                    session_start();
                    session_regenerate_id();
                    $_SESSION["user_id"] = $user["id"];

                    require_once "views/home/index.php";
                    exit;
                }
                else
                {
                    $this->error = "Wrong password!";  
                }
            }
            else
            {
                $this->error = "User not found.";
            }
        }

        $this->renderView('login');
    }
}