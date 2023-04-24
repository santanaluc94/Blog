<?php

use App\Http\Router;
use App\View\View;

require __DIR__ . '/vendor/autoload.php';

define('URL', 'http://localhost');

View::init([
    'baseUrl' => URL,
    'baseAdminUrl' => URL . '/admin',
]);

$router = new Router(URL);

include __DIR__ . '/app/Http/Routes/Routes.php';
include __DIR__ . '/app/Http/Routes/AdminRoutes.php';

$router->run()->sendResponse();
