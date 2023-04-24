<?php

use App\Http\Router;

require __DIR__ . '/vendor/autoload.php';

define('URL', 'http://localhost');

$router = new Router(URL);

include __DIR__ . '/app/Http/Routes/Routes.php';
include __DIR__ . '/app/Http/Routes/AdminRoutes.php';

$router->run()->sendResponse();
