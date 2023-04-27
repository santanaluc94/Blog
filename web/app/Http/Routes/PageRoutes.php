<?php

use App\Http\Response;
use App\Controller\Site;

/** @var \App\Http\Router $router */
$router->get('/', [
    'controller' => function ($request) {
        return new Response(200, Site\Posts\CardList::execute($request));
    }
]);

$router->get('/posts/view/{id}', [
    'controller' => function ($request) {
        return new Response(200, Site\Posts\PostsView::execute($request));
    }
]);

$router->get('/categories/{id}', [
    'controller' => function ($request) {
        return new Response(200, Site\Categories\CategoryView::execute($request));
    }
]);
