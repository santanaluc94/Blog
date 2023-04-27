<?php

use App\Controller\Admin;
use App\Http\Response;

/** @var \App\Http\Router $router */
$router->delete('/admin/roles/deletePost/{id}', [
    'controller' => function ($request) {
        return new Response(
            200,
            Admin\Roles\DeletePost::execute($request),
            'application/x-httpd-php'
        );
    }
]);

$router->delete('/admin/users/deletePost/{id}', [
    'controller' => function ($request) {
        return new Response(
            200,
            Admin\Users\DeletePost::execute($request),
            'application/x-httpd-php'
        );
    }
]);

$router->delete('/admin/categories/deletePost/{id}', [
    'controller' => function ($request) {
        return new Response(
            200,
            Admin\Categories\DeletePost::execute($request),
            'application/x-httpd-php'
        );
    }
]);

$router->delete('/admin/posts/deletePost/{id}', [
    'controller' => function ($request) {
        return new Response(
            200,
            Admin\Posts\DeletePost::execute($request),
            'application/x-httpd-php'
        );
    }
]);
