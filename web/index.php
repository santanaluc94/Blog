<?php

use App\Http\Router;

include __DIR__ . '/app/bootstrap.php';

$router = new Router(URL);

include __DIR__ . '/app/Http/Routes/Routes.php';
include __DIR__ . '/app/Http/Routes/AdminRoutes.php';

$router->run()->sendResponse();
