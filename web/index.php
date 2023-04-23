<?php

use App\Http\Router;

require __DIR__ . '/vendor/autoload.php';

define('URL', 'http://localhost');

$router = new Router(URL);

include __DIR__ . '/app/Http/routes.php';
include __DIR__ . '/app/Http/admin/routes.php';

$router->run()->sendResponse();
