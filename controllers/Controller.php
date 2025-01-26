<?php

class Controller
{
    protected function loadModel($model)
    {
        require_once 'models/' . $model . '.php';
        return new $model;
    }

    protected function renderView($viewPath, $data = [])
    {
        extract($data);
        require_once "views/$viewPath/$viewPath.php"; 
    }
}