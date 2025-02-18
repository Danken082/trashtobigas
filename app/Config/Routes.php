<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

//insert ng basura
$routes->get('/', 'Home::index');
$routes->get('/home', 'AdminController::home');
$routes->get('/inventory', 'AdminController::inventory');
$routes->post('insertTrash', 'AdminController::insertTrash');
$routes->get('pos', 'AdminController::pos');
