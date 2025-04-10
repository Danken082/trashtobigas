<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

//insert ng basura




$routes->get('/home', 'AdminController::home', ['filter' => 'authFilter']);
// $routes->get('/ecommerce', 'AdminController::ecommerce');
$routes->get('/inventory', 'AdminController::inventory', ['filter' => 'authFilter']);
$routes->post('insertTrash', 'AdminController::insertTrash', ['filter' => 'authFilter']);
$routes->get('pos', 'AdminController::pos', ['filter' => 'authFilter']);
$routes->post('admin/create', 'AdminController::create', ['filter' => 'authFilter']);
$routes->get('admin/delete/(:any)', 'AdminController::delete/$1', ['filter' => 'authFilter']);
$routes->post('admin/edit/(:any)', 'AdminController::edit/$1', ['filter' => 'authFilter']);
$routes->get('admin/viewEdit/(:any)', 'AdminController::viewEdit/$1', ['filter' => 'authFilter']);

//converter
$routes->post('convert-trash/(:any)', 'TrashController::convertTrash/$1', ['filter' => 'authFilter']);
//converter
$routes->post('qr/generate', 'AdminController::generate', ['filter' => 'authFilter']);



//applicantRegistration
$routes->post('/admin/register', 'AdminController::registerUser', ['filter' => 'authFilter']);
$routes->get('/admin/list/', 'AdminController::list', ['filter' => 'authFilter']);
$routes->post('applicant/update/', 'AdminController::updateApplicant', ['filter' => 'authFilter']);
//searchApplicant
$routes->get('search', 'AdminController::search', ['filter' => 'authFilter']);
$routes->get('user/(:num)', 'AdminController::getUserDetails/$1', ['filter' => 'authFilter']);


//showing of applicantDetails
$routes->get('applicantdetails/(:any)', 'AdminController::detailsView/$1', ['filter' => 'authFilter']);


$routes->get('index', 'TrashController::index', ['filter' => 'authFilter']);
$routes->get('user/getUser/(:num)', 'TrashController::getUser/$1', ['filter' => 'authFilter']);



//products to ha
$routes->get('/admin/products/', 'ProductController::index', ['filter' => 'authFilter']);
$routes->get('/products/create', 'ProductController::create', ['filter' => 'authFilter']);
$routes->post('/products/store', 'ProductController::store', ['filter' => 'authFilter']);
$routes->get('/products/edit/(:num)', 'ProductController::edit/$1', ['filter' => 'authFilter']);
$routes->post('/products/update/(:num)', 'ProductController::update/$1', ['filter' => 'authFilter']);
$routes->get('/products/delete/(:num)', 'ProductController::delete/$1',  ['filter' => 'authFilter']);

$routes->get('/ecommerce', 'ProductController::index', ['filter' => 'authFilter']);



$routes->post('login', 'AuthController::attemptLogin');


//register

$routes->post('registerUser', 'AuthController::register', ['filter' => 'authFilter']);

//view users
$routes->get('viewapplicants/', 'AdminController::viewAllApplicant', ['filter' => 'authFilter']);
$routes->get('deleteUser/(:num)', 'AdminController::insertIDNumber/$1', ['filter' => 'authFilter']);


//for inventory
$routes->get('viewInventory', 'AdminController::viewInventory', ['filter' => 'authFilter']);
$routes->get('displayInventory', 'AdminController::displayInventoryTable', ['filter' => 'authFilter']);
$routes->post('addInventory', 'AdminController::addToInventory', ['filter' => 'authFilter']);
$routes->get('deleteInventory/(:any)', 'AdminController::deleteInventory/$1', ['filter' => 'authFilter']);
$routes->post('items/update/', 'AdminController::updateInventory/', ['filter' => 'authFilter']);




$routes->get('logout', 'AuthController::logout' , ['filter' => 'authFilter']);
$routes->get('getuser', 'AuthController::showUser', ['filter' => 'authFilter']);
$routes->get('/disableaccount/(:any)', 'AuthController::disableaccount/$1');
$routes->get('/enableaccount/(:any)', 'AuthController::enableaccount/$1');
$routes->get('/deleteuseradmin/(:any)', 'AuthController::deleteUser/$1');


//points

$routes->get('points', 'TrashController::points', ['filter' => 'authFilter']);
$routes->post('savePoints', 'TrashController::InsertPoints', ['filter' => 'authFilter']);
$routes->post('edit/rangespoints', 'TrashController::updatepoints', ['filter' => 'authFilter']);
$routes->get('deleteRanges/(:num)', 'TrashController::deleteRanges/$1', ['filter' => 'authFilter']);


$routes->get('ecommerce/(:any)', 'ProductController::index/$1', ['filter' => 'authFilter']);
$routes->post('redeem', 'ProductController::redeem', ['filter' => 'authFilter']);
$routes->get('/report/export', 'ReportController::exportExcel');
$routes->get('/report/redemption', 'ReportController::redemptionHistory');


   

if(session()->get('role')=='Admin')
{

$routes->get('ranges', 'TrashController::viewRange', ['filter' => 'authFilter']);
$routes->get('register', 'AuthController::viewregister', ['filter' => 'authFilter']);
$routes->post('updateUser', 'AuthController::updateUser',['filter'=> 'authFilter']);


}
$routes->get('/adminlogin', 'AuthController::login', ['filter' => 'guestFilter']);
 




$routes->post('loginAuth', 'AuthController::attemptLogin', ['filter' => 'guestFilter']);







$routes->get('showredeemed', 'AdminController::redeemItemsHistory');
$routes->get('historyPointsConvertion', 'AdminController::viewHistoryPointsConvertion');
$routes->post('forgotpassword', 'AuthController::forgot');

$routes->post('/send', 'AuthController::sendSample');
$routes->get('/trysend', 'AuthController::buttonsample');

$routes->match(['get', 'post'], '/active/(:any)', 'AuthController::activeAccount/$1');
$routes->match(['get', 'post'], '/resetpassword/(:any)', 'AuthController::resetPassword/$1');
$routes->match(['get', 'post'], '/resetpasswordcon/(:any)', 'AuthController::resetpasswordcon/$1');
$routes->match(['get', 'post'], '/passwordReseter/(:any)', 'AuthController::resetthispassword/$1');

$routes->get('clienthome', 'ClientController::home');
$routes->get('clientprofile', 'ClientController::profile');
$routes->get('clienthistory', 'ClientController::history');
$routes->get('/', 'ClientController::login');

$routes->get('client/resetlink/(:any)', 'ClientController::clientresetview/$1');
$routes->post('client/resetpassword/(:any)', 'ClientController::confirmtoreset/$1');
$routes->match(['get', 'post'], 'resetauth', 'ClientController::resetPassword');
$routes->post('clientloginauth', 'ClientController::loginAuth');
$routes->get('clientLogout', 'ClientController::logout');
$routes->post('uploadprofileimage', 'ClientController::uploadProfileImage');
$routes->post('changepasswordprofile/', 'ClientController::changePassinProf/');