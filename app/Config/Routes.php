<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'AuthController::login');
$routes->post('/auth/log', 'AuthController::log');
$routes->post('/auth/log_operateur', 'AuthController::log_operateur');
$routes->get('/auth/logout', 'AuthController::logout');

$routes->get('/dashboard', 'ClientController::dashboard');
$routes->get('/client/solde', 'ClientController::solde');
// ==================== PREFIXES ====================
$routes->get('/prefixes', 'PrefixeController::index');
$routes->post('/prefixes/store', 'PrefixeController::store');
$routes->get('/prefixes/(:num)/edit', 'PrefixeController::edit/$1');
$routes->post('/prefixes/(:num)/update', 'PrefixeController::update/$1');
$routes->post('/prefixes/(:num)/delete', 'PrefixeController::delete/$1');
$routes->get('/depot', 'OperationController::depot');
$routes->get('/retrait', 'OperationController::retrait');
$routes->get('/transfert', 'OperationController::transfert');
$routes->post('/operations/store', 'OperationController::store');

$routes->get('/operateur/login', 'AuthController::operateur');
$routes->get('/operateur/situation', 'OperateurController::situation', ['filter' => 'operateur']);
$routes->get('/operateur/clients', 'OperateurController::clients', ['filter' => 'operateur']);

$routes->get('/montant-frais', 'MontantFraisController::index');
$routes->get('/montant-frais/create', 'MontantFraisController::create');
$routes->post('/montant-frais/store', 'MontantFraisController::store');
$routes->get('/montant-frais/(:num)/edit', 'MontantFraisController::edit/$1');
$routes->post('/montant-frais/(:num)/update', 'MontantFraisController::update/$1');
$routes->post('/montant-frais/(:num)/delete', 'MontantFraisController::delete/$1');

$routes->get('/commission', 'CommissionController::index');
$routes->get('/commission/create', 'CommissionController::create');
$routes->post('/commission/store', 'CommissionController::store');
$routes->get('/commission/(:num)/edit', 'CommissionController::edit/$1');
$routes->post('/commission/(:num)/update', 'CommissionController::update/$1');
$routes->post('/commission/(:num)/delete', 'CommissionController::delete/$1');

$routes->post('/epargne/show', 'EpargneController::show');
$routes->post('/epargne/store', 'EpargneController::store');
