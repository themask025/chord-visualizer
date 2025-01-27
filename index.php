<?php

$uri = $_SERVER['REQUEST_URI'];
require_once  'router.php';
$router = new Router();
$router->choose_route(parse_url($uri)['path']);


