<?php

use App\Core\Router;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/conf.php';

$router = new Router();
$router->match(uri: $_SERVER['REQUEST_URI']);


?>