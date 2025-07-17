<?php
use App\Controllers\HomeController;
use App\Controllers\ProductController;
use App\Controllers\StaffController;
use Bramus\Router\Router;

$router = new Router();

//Nơi khai báo các route
$router->get('/',HomeController::class . '@index');

$router->mount('/users', function() use ($router) {
    
});



$router->mount('/staff', function() use ($router) {
    $router->get('/', StaffController::class . '@index');
    $router->get('/products', ProductController::class . '@index');
});
$router->run();