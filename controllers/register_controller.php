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
        if (isset($_SESSION["user_id"])) {
            header("Location: views/home/index.php");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $password_confirmation = $_POST['password_confirmation'];

            if ($this->is_valid_input($username, $email, $password, $password_confirmation) == true) {
                $model = $this->loadModel("register");
                $status = $model->addUser($username, $email, $password);
                if ($status == true) {
                    $model = $this->loadModel("login");
                    $user = $model->getUser($username);

                    session_start();
                    session_regenerate_id();
                    $_SESSION["user_id"] = $user["id"];

                    header("Location: views/home/index.php");
                    exit;
                } else {
                    $this->error = "Unsuccessful registration.";
                }
            }
        }

        $this->renderView('register');
    }

    private function is_valid_input($username, $email, $password, $password_confirmation)
    {
        if (strlen($username) < 3) {
            $this->error = "Username must be at least 3 characters long.";
            return false;
        }

        if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
            $this->error = "Valid email is required.";
            return false;
        }

        if (strlen($password) < 8) {
            $this->error = "Password must be at least 8 characters long.";
            return false;
        }

        if (preg_match("/[a-z]/", $password) == false) {
            $this->error = "Password must contain at least 1 lowercase letter.";
            return false;
        }

        if (preg_match("/[A-Z]/", $password) == false) {
            $this->error = "Password must contain at least 1 uppercase letter.";
            return false;
        }

        if (preg_match("/[0-9]/", $password) == false) {
            $this->error = "Password must contain at least 1 digit.";
            return false;
        }

        if ($password != $password_confirmation) {
            $this->error = "Passwords must match.";
            return false;
        }

        $model = $this->loadModel("register");

        if($model->checkUsernameExists($username) == true)
        {
            $this->error = "This username is already taken.";
            return false;
        }

        if($model->checkEmailExists($email) == true)
        {
            $this->error = "There already is an account with this email.";
            return false;
        }

        $this->error = null;
        return true;
    }
}