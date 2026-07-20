<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ==================== AUTH ====================
$routes->get('/', 'AuthController::login');
$routes->post('/auth/log', 'AuthController::log');
$routes->post('/auth/log_operateur', 'AuthController::log_operateur');
$routes->get('/auth/logout', 'AuthController::logout');

// ==================== CLIENT ====================
$routes->get('/dashboard', 'ClientController::dashboard');
$routes->get('/client/solde', 'ClientController::solde');
$routes->get('/prefixes', 'PrefixeController::index');
$routes->get('/depot', 'OperationController::depot');
$routes->get('/retrait', 'OperationController::retrait');
$routes->get('/transfert', 'OperationController::transfert');
$routes->post('/operations/store', 'OperationController::store');

// ==================== OPERATEUR ====================
$routes->get('/operateur/login', 'AuthController::operateur');
$routes->get('/operateur/situation', 'OperateurController::situation', ['filter' => 'operateur']);
$routes->get('/operateur/clients', 'OperateurController::clients', ['filter' => 'operateur']);

// ==================== ADMIN ====================
$routes->get('/montant-frais', 'MontantFraisController::index');
$routes->get('/montant-frais/create', 'MontantFraisController::create');
$routes->post('/montant-frais/store', 'MontantFraisController::store');
$routes->get('/montant-frais/(:num)/edit', 'MontantFraisController::edit/$1');
$routes->post('/montant-frais/(:num)/update', 'MontantFraisController::update/$1');
$routes->post('/montant-frais/(:num)/delete', 'MontantFraisController::delete/$1');
