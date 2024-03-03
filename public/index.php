<?php

session_start();

require_once '../vendor/autoload.php';

$router = new Project\Router();
$router->routerQuery();