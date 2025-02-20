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
<<<<<<< HEAD
$routes->post('admin/create', 'AdminController::create');
$routes->get('admin/delete/(:any)', 'AdminController::delete/$1');
$routes->post('admin/edit/(:any)', 'AdminController::edit/$1');
$routes->get('admin/viewEdit/(:any)', 'AdminController::viewEdit/$1');
=======
//converter
$routes->post('convert-trash', 'TrashController::convertTrash');
//converter
$routes->post('qr/generate', 'QrController::generate');
>>>>>>> b140ca20ddbc9208c64652211f5f12519af1be6e
