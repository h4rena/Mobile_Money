<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'AuthController::login');
$routes->post('/auth/log', 'AuthController::log');

$routes->get('/auth/logout', 'AuthController::logout');
$routes->get('/prefixes', 'PrefixeController::index');
$routes->get('/dashboard', 'AuthController::dashboard');
$routes->get('/depot', 'OperationController::depot');
$routes->post('/operations/store', 'OperationController::store');

$routes->get('/client/solde', 'ClientController::solde');

