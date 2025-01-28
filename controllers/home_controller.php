<?php

require_once 'controller.php';

class HomeController extends Controller {
    public function __construct() {}

    public function index() {
        require_once("views/home/index.php");
    }
}

?>
