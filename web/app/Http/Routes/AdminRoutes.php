<?php

use App\Http\Response;

/** @var \App\Http\Router $router */
$router->get('/admin/login', [
    function () {
        return new Response(200, \App\Controller\Admin\Login::getAdminContentPage());
    }
]);

$router->get('/admin/register', [
    function () {
        return new Response(200, \App\Controller\Admin\Register::getAdminContentPage());
    }
]);

$router->get('/admin/posts/listing', [
    function () {
        return new Response(200, \App\Controller\Admin\Posts\Listing::getAdminContentPage());
    }
]);

$router->get('/admin/posts/save/{id}', [
    function (int $id) {
        return new Response(200, \App\Controller\Admin\Posts\Save::getAdminContentPage());
    }
]);

$router->get('/admin/categories/listing', [
    function () {
        return new Response(200, \App\Controller\Admin\Categories\Listing::getAdminContentPage());
    }
]);

$router->get('/admin/categories/save/{id}', [
    function (int $id) {
        return new Response(200, \App\Controller\Admin\Categories\Save::getAdminContentPage());
    }
]);

$router->get('/admin/users/listing', [
    function () {
        return new Response(200, \App\Controller\Admin\Users\Listing::getAdminContentPage());
    }
]);

$router->get('/admin/users/save/{id}', [
    function (int $id) {
        return new Response(200, \App\Controller\Admin\Users\Save::getAdminContentPage());
    }
]);

$router->get('/admin/pages/listing', [
    function () {
        return new Response(200, \App\Controller\Admin\Pages\Listing::getAdminContentPage());
    }
]);

$router->get('/admin/pages/save/{id}', [
    function (int $id) {
        return new Response(200, \App\Controller\Admin\Pages\Save::getAdminContentPage());
    }
]);
