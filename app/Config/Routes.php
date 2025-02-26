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
//converter
$routes->post('convert-trash/(:any)', 'TrashController::convertTrash/$1');
//converter
$routes->post('qr/generate', 'QrController::generate');


//applicantRegistration
$routes->post('/admin/register', 'AdminController::registerUser');
    
//searchApplicant
$routes->get('search', 'AdminController::search');
$routes->get('user/(:num)', 'AdminController::getUserDetails/$1');

//showing of applicantDetails
$routes->get('applicantdetails/(:any)', 'AdminController::detailsView/$1');


$routes->get('index', 'TrashController::index');
$routes->get('user/getUser/(:num)', 'TrashController::getUser/$1');

$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::attemptLogin');
$routes->get('logout', 'AuthController::logout');


