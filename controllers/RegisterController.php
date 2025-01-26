<?php

require_once 'Controller.php';

class RegisterController extends Controller
{
    function register()
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            $model = $this->loadModel("RegisterModel");
            $status = $model->addUser($username, $email, $password);
            if($status == true)
            {
                echo "Successful registration!";
            }
            else
            {
                echo "Unsuccessful registration.";
            }
        }
        else
        {
            $this->renderView('register');
        }
    }
}