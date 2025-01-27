<?php

require_once 'controller.php';

class RegisterController extends Controller
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
            require_once "views/home/index.php";
            exit;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $password_repeat = $_POST['password_repeat'];

            if($this->is_valid_input($username, $email, $password, $password_repeat) == true)
            {
                $model = $this->loadModel("register");
                $status = $model->addUser($username, $email, $password);
                if($status == true)
                {
                    echo "Successful registration!";
                    $model = $this->loadModel("login");
                    $user = $model->getUser($username);
    
                    session_start();
                    session_regenerate_id();
                    $_SESSION["user_id"] = $user["id"];
    
                    require_once "views/home/index.php";
                    exit;
                }
                else
                {
                    $this->error = "Unsuccessful registration.";
                }
            }            
        }

        $this->renderView('register');
    }

    private function is_valid_input($username, $email, $password, $password_repeat)
    {
        if($password != $password_repeat)
        {
            $this->error = "Passwords do not match!";
            return false;
        }
        return true;
    }
}