<?php

require_once 'controller.php';

class HomeController extends Controller {
    public function __construct() {}

    public function index() {
        header("Location: views/home/index.php");
    }
}

?>
