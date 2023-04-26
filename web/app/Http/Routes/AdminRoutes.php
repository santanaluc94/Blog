<?php

use App\Controller\Admin;
use App\Http\Response;

/** @var \App\Http\Router $router */
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

$router->get('/admin/login', [
    'controller' => function ($request) {
        return new Response(200, Admin\Login::execute($request));
    }
]);

$router->get('/admin/register', [
    'controller' => function ($request) {
        return new Response(200, Admin\Register::execute($request));
    }
]);

$router->get('/admin/posts/listing', [
    'controller' => function ($request) {
        return new Response(200, Admin\Posts\Listing::execute($request));
    }
]);

$router->get('/admin/posts/save/{id}', [
    'controller' => function ($request) {
        return new Response(200, Admin\Posts\Save::execute($request));
    }
]);

$router->get('/admin/categories/listing', [
    'controller' => function ($request) {
        return new Response(200, Admin\Categories\Listing::execute($request));
    }
]);

$router->get('/admin/categories/save/{id}', [
    'controller' => function ($request) {
        return new Response(200, Admin\Categories\Save::execute($request));
    }
]);

$router->get('/admin/users/listing', [
    'controller' => function ($request) {
        return new Response(200, Admin\Users\Listing::execute($request));
    }
]);

$router->get('/admin/users/save/{id}', [
    'controller' => function ($request) {
        return new Response(200, Admin\Users\Save::execute($request));
    }
]);

$router->get('/admin/roles/listing', [
    'controller' => function ($request) {
        return new Response(200, Admin\Roles\Listing::execute($request));
    }
]);

$router->get('/admin/roles/save/{id}', [
    'controller' => function ($request) {
        return new Response(200, Admin\Roles\Save::execute($request));
    }
]);

/** @var \App\Http\Router $router */
$router->get('/admin/roles/deletePost/{id}', [
    'controller' => function ($request) {
        return new Response(
            200,
            Admin\Roles\DeletePost::execute($request),
            'application/x-httpd-php'
        );
    }
]);
