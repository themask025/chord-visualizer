<?php

require_once 'controller.php';

class RegisterController extends Controller
{
    function index()
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            $model = $this->loadModel("register");
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