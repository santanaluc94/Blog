<?php


use App\Http\Response;

/** @var \App\Http\Router $router */
$router->get('/', [
    'controller' => function ($request) {
        return new Response(200, \App\Controller\Site\Home::execute($request));
    }
]);

$router->get('/login', [
    'controller' => function ($request) {
        return new Response(200, \App\Controller\Site\Login::execute($request));
    }
]);
