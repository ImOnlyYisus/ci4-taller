<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->post('auth/login', 'AuthController::login');

$routes->group('products', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'ProductController::index');
    $routes->post('/', 'ProductController::create');
    $routes->get('(:any)', 'ProductController::show/$1');
    $routes->put('(:any)', 'ProductController::update/$1');
    $routes->delete('(:any)', 'ProductController::delete/$1');
});

/* $routes->get('/', 'ProductController::indexView') */;

