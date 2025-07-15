<?php
use App\Controllers\HomeController;
use Bramus\Router\Router;

$router = new Router();

//Nơi khai báo các route
$router->get('/',HomeController::class . '@index');

$router->run();