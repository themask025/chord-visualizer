<?php

require_once (__DIR__ . '/../constants.php');
require_once (__DIR__ . '/controller.php');

class HomeController extends Controller {
    public function __construct() {}

    public function index() {
        require_once(__DIR__ ."/../views/home/index.php");
    }
}

?>
