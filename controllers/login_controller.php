<?php

require_once (__DIR__ . '/../constants.php');
require_once (__DIR__ . '/controller.php');

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
        if (isset($_SESSION["user_id"])) {
            header("Location: views/home/index.php");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];

            $model = $this->loadModel("user");
            $user = $model->getUserFromUsername($username);

            if ($user != false) {
                if ($_POST["password"] == $user["password"]) {
                    session_start();
                    session_regenerate_id();
                    $_SESSION["user_id"] = $user["id"];
                    $_SESSION["username"] = $user["username"];

                    header("Location: views/home/index.php");
                    exit;
                } else {
                    $this->error = "Invalid username or password.";
                }
            } else {
                $this->error = "Invalid username or password.";
            }
        }

        $this->renderView('login', ["auth_page" => true]);
    }

    public function logout()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            
            if (isset($_SESSION["user_id"])) {
                session_unset();
                session_destroy();

                $sender = $_POST["sender"];

                if($sender ==  BASE_PATH . "version/initTab")
                {
                    header("Location: ". BASE_PATH);
                    exit;
                }
                
                header("Location:" . $sender);
                exit;
            }
        }
        header("Location: ".BASE_PATH);
        exit;
    }
}
