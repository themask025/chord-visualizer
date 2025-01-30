<?php

$uri = $_SERVER['REQUEST_URI'];
require_once (__DIR__ .  '/router.php');
$router = new Router();
$router->choose_route(parse_url($uri)['path']);


