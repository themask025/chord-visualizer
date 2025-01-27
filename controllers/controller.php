<?php

class Controller
{
    protected function loadModel($model)
    {
        require_once 'models/' .strtolower($model) . '.php';
        return new $model();
    }

    protected function renderView($view_path, $data = [])
    {
        extract($data);
        require_once "views/$view_path/$view_path.php"; 
    }
}