<?php
use App\Controllers\AuthController;
use App\Controllers\CartController;
use App\Controllers\HomeController;
use App\Controllers\OrderController;
use App\Controllers\PaymentController;
use App\Controllers\ProductController;
use App\Controllers\StaffController;
use App\Controllers\CategoryController;
use App\Controllers\UserController;
use App\Controllers\UserOrderController;
use Bramus\Router\Router;

$router = new Router();

//Nơi khai báo các route
$router->get('/', HomeController::class . '@index');

$router->mount('/users', function () use ($router) {

});



$router->mount('/staff', function () use ($router) {
    $router->get('/', StaffController::class . '@index');
    $router->get('/products', ProductController::class . '@index');
    $router->get('/products/show/{id}', ProductController::class . '@show');
    $router->get('/products/create', ProductController::class . '@create');
    $router->post('/products/store', ProductController::class . '@store');
    $router->get('/products/edit/{id}', ProductController::class . '@edit');
    $router->post('/products/update/{id}', ProductController::class . '@update');
    $router->post('/products/destroy/{id}', ProductController::class . '@destroy');


    $router->get('/categories', CategoryController::class . '@index');
    $router->get('/categories/create', CategoryController::class . '@create');
    $router->post('/categories/store', CategoryController::class . '@store');
    $router->post('/categories/destroy/{id}', CategoryController::class . '@destroy');

    $router->get('/users', UserController::class . '@index');
    $router->post('/users/update-status/{id}', UserController::class . '@updateStatus');

    $router->get('/orders', OrderController::class . '@index');
    $router->get('/orders/show/{id}', OrderController::class . '@show');
    $router->post('/orders/updateStatus', OrderController::class . '@updateStatus');
});


$router->mount('/user', function () use ($router) {
    $router->get('/', HomeController::class . '@index');
    $router->get('/products/show/{id}', HomeController::class . '@showProduct');
    $router->get('/cart', CartController::class . '@index');
    $router->post('/cart/add/{id}', CartController::class . '@add');
    $router->get('/cart/remove/{id}', CartController::class . '@remove');
    $router->post('/cart/update', CartController::class . '@update');
    $router->get('/payment', PaymentController::class . '@index');
    $router->post('/order/submit', PaymentController::class . '@submit');

    $router->get('/orders', UserOrderController::class . '@index');
    $router->get('/orders/show/{orderId}', UserOrderController::class . '@show');
    $router->post('/orders/cancel/{id}', UserOrderController::class . '@cancel');
    $router->post('/orders/receive/{id}', UserOrderController::class . '@markAsReceived');

});

$router->get('/login', AuthController::class . '@showLoginForm');
$router->post('/login', AuthController::class . '@login');
$router->get('/logout', AuthController::class . '@logout');

$router->get('/register', AuthController::class . '@showRegisterForm');
$router->post('/register', AuthController::class . '@register');

$router->run();