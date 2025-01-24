<?php

$uri = $_SERVER['REQUEST_URI'];
$app_name="/chord-visualizer/";
switch ($uri) {
    case $app_name . "register/":
        include "./register/register.html";
        break;
    case $app_name . "tab_editor/":
        include "./tab_editor/tab_editor.html";

        break;
    default:
        include "./login/login.html";
        break;
}


