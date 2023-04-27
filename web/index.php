<?php

use App\Http\Router;
use App\Http\Request;

include __DIR__ . '/app/bootstrap.php';

$router = new Router(URL);

$request = new Request($router);

include __DIR__ . '/app/Http/Routes/AdminPostRoutes.php';
include __DIR__ . '/app/Http/Routes/AdminPageRoutes.php';
include __DIR__ . '/app/Http/Routes/AdminDeleteRoutes.php';
include __DIR__ . '/app/Http/Routes/PageRoutes.php';

$router->run()->sendResponse();
