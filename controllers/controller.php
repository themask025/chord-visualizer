<?php

class Controller
{
    protected function loadModel($model)
    {
        require_once(__DIR__ . '/../models/' .strtolower($model) . '.php');
        return new $model();
    }

    protected function renderView($view_path, $data = [])
    {
        extract($data);
        require_once(__DIR__ . "/../views/$view_path/$view_path.php");
    }
}