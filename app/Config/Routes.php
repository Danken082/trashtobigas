<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

//insert ng basura
$routes->get('/', 'Home::index');
$routes->get('/home', 'AdminController::home');
// $routes->get('/ecommerce', 'AdminController::ecommerce');
$routes->get('/inventory', 'AdminController::inventory');
$routes->post('insertTrash', 'AdminController::insertTrash');
$routes->get('pos', 'AdminController::pos');
$routes->post('admin/create', 'AdminController::create');
$routes->get('admin/delete/(:any)', 'AdminController::delete/$1');
$routes->post('admin/edit/(:any)', 'AdminController::edit/$1');
$routes->get('admin/viewEdit/(:any)', 'AdminController::viewEdit/$1');

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


//products to ha
$routes->get('/admin/products/', 'ProductController::index');
$routes->get('/products/create', 'ProductController::create');
$routes->post('/products/store', 'ProductController::store');
$routes->get('/products/edit/(:num)', 'ProductController::edit/$1');
$routes->post('/products/update/(:num)', 'ProductController::update/$1');
$routes->get('/products/delete/(:num)', 'ProductController::delete/$1');

$routes->get('/ecommerce', 'ProductController::index');


$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::attemptLogin');
$routes->get('logout', 'AuthController::logout');




