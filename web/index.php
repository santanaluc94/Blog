<?php

use App\Http\Router;
use App\Http\Request;

include __DIR__ . '/app/bootstrap.php';

$router = new Router(URL);

$request = new Request($router);

include __DIR__ . '/app/Http/Routes/Routes.php';
include __DIR__ . '/app/Http/Routes/AdminRoutes.php';

$router->run()->sendResponse();
