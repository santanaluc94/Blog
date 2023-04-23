<?php

use App\Http\Response;

/** @var \App\Http\Router $router */
$router->get('/admin/login', [
    function () {
        return new Response(200, \App\Controller\Admin\Login::getAdminContentPage());
    }
]);
