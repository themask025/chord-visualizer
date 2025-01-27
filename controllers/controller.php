<?php

class Controller
{
    protected function loadModel($model)
    {
        require_once 'model/' . strtolower($model) . '.php';
        return new  $model();
    }

    protected function renderView($viewPath, $data = [])
    {
        extract($data);
        require_once "views/$viewPath/$viewPath.php";
    }
}