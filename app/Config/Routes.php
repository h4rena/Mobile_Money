<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'AuthController::login');
$routes->post('/auth/log', 'AuthController::log');

$routes->get('/auth/logout', 'AuthController::logout');
$routes->get('/dashboard', 'ClientController::dashboard');

$routes->get('/prefixes', 'PrefixeController::index');
$routes->get('/depot', 'OperationController::depot');
$routes->post('/operations/store', 'OperationController::store');

$routes->get('/client/solde', 'ClientController::solde');

