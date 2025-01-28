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
        if (isset($_SESSION["user_id"])) {
            header("Location: views/home/index.php");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];

            $model = $this->loadModel("user");
            $user = $model->getUserFromUsername($username);

            if ($user != false) {
                if (password_verify($_POST["password"], $user["password"]) == true) {
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

        $this->renderView('login');
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

                if($sender == "/chord-visualizer/version/initTab")
                {
                    header("Location: /chord-visualizer/");
                    exit;
                }
                
                header("Location:" . $sender);
                exit;
            }
        }
        header("Location: /chord-visualizer/");
        exit;
    }
}
