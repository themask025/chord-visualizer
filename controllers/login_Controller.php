<?php

namespace controllers;

class LoginController
{

    public function __construct()
    {

    }
    public function index()
    {
        require_once __DIR__ . '/../views/login/login.php';
    }

    public function login($username, $password)
    {

    }
}