<?php
use App\Controllers\HomeController;
use App\Controllers\ProductController;
use App\Controllers\StaffController;
use App\Controllers\CategoryController;
use App\Controllers\UserController;
use Bramus\Router\Router;

$router = new Router();

//Nơi khai báo các route
$router->get('/',HomeController::class . '@index');

$router->mount('/users', function() use ($router) {
    
});



$router->mount('/staff', function() use ($router) {
    $router->get('/', StaffController::class . '@index');
    $router->get('/products', ProductController::class . '@index');
    $router->get('/products/show/{id}',      ProductController::class . '@show');
    $router->get('/products/create',      ProductController::class . '@create');
    $router->post('/products/store',      ProductController::class . '@store');
    $router->get('/products/edit/{id}',      ProductController::class . '@edit');
    $router->post('/products/update/{id}', ProductController::class . '@update');
    $router->post('/products/destroy/{id}', ProductController::class . '@destroy');


    $router->get('/categories', CategoryController::class . '@index');
    $router->get('/categories/create', CategoryController::class . '@create');
    $router->post('/categories/store', CategoryController::class . '@store');
    $router->post('/categories/destroy/{id}', CategoryController::class . '@destroy');

    $router->get('/users', UserController::class . '@index');
    $router->post('/users/update-status/{id}', UserController::class . '@updateStatus');


});
$router->run();