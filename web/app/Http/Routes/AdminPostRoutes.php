<?php

use App\Controller\Admin;
use App\Http\Response;

/** @var \App\Http\Router $router */
$router->post('/admin/loginPost', [
    'controller' => function ($request) {
        return new Response(
            200,
            Admin\LoginPost::execute($request),
            'application/x-httpd-php'
        );
    }
]);

$router->post('/admin/roles/savePost/{id}', [
    'controller' => function ($request) {
        return new Response(
            200,
            Admin\Roles\SavePost::execute($request),
            'application/x-httpd-php'
        );
    }
]);

$router->post('/admin/users/savePost/{id}', [
    'controller' => function ($request) {
        return new Response(
            200,
            Admin\Users\SavePost::execute($request),
            'application/x-httpd-php'
        );
    }
]);

$router->post('/admin/posts/savePost/{id}', [
    'controller' => function ($request) {
        return new Response(
            200,
            Admin\Posts\SavePost::execute($request),
            'application/x-httpd-php'
        );
    }
]);

$router->post('/admin/categories/savePost/{id}', [
    'controller' => function ($request) {
        return new Response(
            200,
            Admin\Categories\SavePost::execute($request),
            'application/x-httpd-php'
        );
    }
]);
