<?php

use App\Http\Response;

/** @var \App\Http\Router $router */
$router->get('/', [
    function () {
        return new Response(200, \App\Controller\Home::getContentPage());
    }
]);

$router->get('/all_posts', [
    function () {
        return new Response(200, \App\Controller\AllPosts::getContentPage());
    }
]);
