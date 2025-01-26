<?php

class LoginController extends Controller
{

    public function login()
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $model = $this->loadModel("LoginModel");
            $user = $model->getUser($username);

            if($user != false)
            {
                if($_POST["password"] == $user["password"])
                {
                    echo "Login successful!";
                }
                else
                {
                    echo "Wrong password!";
                }
            }
            else
            {
                echo "User not found.";
            }
        }
        else
        {
            $this->renderView('login');
        }
    }

}