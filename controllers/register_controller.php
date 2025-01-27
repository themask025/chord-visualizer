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
            header("Location: views/home/index.php");
            exit;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $password_confirmation = $_POST['password_confirmation'];

            if($this->is_valid_input($username, $email, $password, $password_confirmation) == true)
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
    
                    header("Location: views/home/index.php");
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

    private function is_valid_input($username, $email, $password, $password_confirmation)
    {
        if($password != $password_confirmation)
        {
            $this->error = "Passwords do not match!";
            return false;
        }

        if (strlen($username) <= 3) {
            $this->error = "Username must be at least 3 characters long.";
            return false;
        }

        if(strlen($password) < 8)
        {
            $this->error = "Password must be at least 8 characters long.";
            return false;
        }

        return true;
    }
}