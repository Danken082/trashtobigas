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
$routes->post('admin/create', 'AdminController::create');
$routes->get('admin/delete/(:any)', 'AdminController::delete/$1');
$routes->post('admin/edit/(:any)', 'AdminController::edit/$1');
$routes->get('admin/viewEdit/(:any)', 'AdminController::viewEdit/$1');

//converter
$routes->post('convert-trash/(:any)', 'TrashController::convertTrash/$1');
//converter
$routes->post('qr/generate', 'AdminController::generate');



//applicantRegistration
$routes->post('/admin/register', 'AdminController::registerUser');
$routes->get('/admin/list/', 'AdminController::list');
    
//searchApplicant
$routes->get('search', 'AdminController::search');
$routes->get('user/(:num)', 'AdminController::getUserDetails/$1');


//showing of applicantDetails
$routes->get('applicantdetails/(:any)', 'AdminController::detailsView/$1');


$routes->get('index', 'TrashController::index');
$routes->get('user/getUser/(:num)', 'TrashController::getUser/$1');


//view users
$routes->get('viewapplicants/', 'AdminController::viewAllApplicant');
$routes->get('deleteUser/(:num)', 'AdminController::insertIDNumber/$1');


//for inventory
$routes->get('viewInventory', 'AdminController::viewInventory');
$routes->get('displayInventory', 'AdminController::displayInventoryTable');
$routes->post('addInventory', 'AdminController::addToInventory');


//===login====
$routes->match(['get', 'post'], 'login', 'AuthController::login');
$routes->post('auth/login', 'AuthController::attemptLogin');
$routes->get('logout', 'AuthController::logout');




// >>>>>>> 864b6cebd8709db269757bf8146f2f6e2a28cccd
