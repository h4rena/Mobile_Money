<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/prefixes', 'Prefixe::index');

$routes->get('/operateurs', 'Operateur::index');
$routes->get('/operateurs/create', 'Operateur::create');
$routes->post('/operateurs/store', 'Operateur::store');
$routes->get('/operateurs/(:num)', 'Operateur::show/$1');
$routes->get('/operateurs/(:num)/edit', 'Operateur::edit/$1');
$routes->post('/operateurs/(:num)/update', 'Operateur::update/$1');
$routes->post('/operateurs/(:num)/delete', 'Operateur::delete/$1');

$routes->get('/type-operations', 'TypeOperation::index');
$routes->get('/type-operations/create', 'TypeOperation::create');
$routes->post('/type-operations/store', 'TypeOperation::store');
$routes->get('/type-operations/(:num)', 'TypeOperation::show/$1');
$routes->get('/type-operations/(:num)/edit', 'TypeOperation::edit/$1');
$routes->post('/type-operations/(:num)/update', 'TypeOperation::update/$1');
$routes->post('/type-operations/(:num)/delete', 'TypeOperation::delete/$1');

$routes->get('/montant-frais', 'MontantFrais::index');
$routes->get('/montant-frais/create', 'MontantFrais::create');
$routes->post('/montant-frais/store', 'MontantFrais::store');
$routes->get('/montant-frais/(:num)', 'MontantFrais::show/$1');
$routes->get('/montant-frais/(:num)/edit', 'MontantFrais::edit/$1');
$routes->post('/montant-frais/(:num)/update', 'MontantFrais::update/$1');
$routes->post('/montant-frais/(:num)/delete', 'MontantFrais::delete/$1');

$routes->get('/operations', 'Operation::index');
$routes->get('/operations/create', 'Operation::create');
$routes->post('/operations/store', 'Operation::store');
$routes->get('/operations/(:num)', 'Operation::show/$1');
$routes->get('/operations/(:num)/edit', 'Operation::edit/$1');
$routes->post('/operations/(:num)/update', 'Operation::update/$1');
$routes->post('/operations/(:num)/delete', 'Operation::delete/$1');