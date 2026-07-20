<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'AuthController::login');
$routes->post('/auth/log', 'AuthController::log');

$routes->get('/dashboard', 'ClientController::dashboard');
$routes->get('/prefixes', 'PrefixeController::index');
$routes->get('/client/solde', 'ClientController::solde');