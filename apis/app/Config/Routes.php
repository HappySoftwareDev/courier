<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Login');
$routes->setDefaultMethod('login');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Login::login');
$routes->post('get_pickup_areas', 'Api::get_pickup_areas');
$routes->post('get_dropoff_areas', 'Api::get_dropoff_areas');
$routes->post('get_package_weight', 'Api::get_package_weight');
$routes->post('get_package_value',  'Api::get_package_value');
$routes->post('get_package_quantity', 'Api::get_package_quantity');
$routes->post('get_transport_options', 'Api::get_transport_options');
$routes->post('get_insurance_options', 'Api::get_insurance_options');
$routes->post('get_pickup_time_options', 'Api::get_pickup_time_options');
$routes->post('get_deliver_time_options', 'Api::get_deliver_time_options');
$routes->post('save_booking', 'Api::save_booking');


$routes->get('login', 'Login::login');
$routes->get('dashboard', 'Home::dashboard');
$routes->get('my-stores', 'Home::my_stores');
$routes->get('my-store/(:any)/(:num)', 'Home::my_stores/$2/$1');
$routes->get('add-stores', 'Home::add_store');
$routes->post('add-stores', 'Home::add_store');
$routes->get('logout', 'Login::logout');
$routes->post('logincheck', 'Login::logincheck');
$routes->get('profile', 'Home::profile');
$routes->post('profile', 'Home::profile');
$routes->get('change-password', 'Home::change_password');
$routes->post('change-password', 'Home::change_password');
$routes->get('my-orders', 'Home::my_orders');
$routes->post('my-orders', 'Home::my_orders');
$routes->get('forget-password', 'Login::forget_password');
$routes->post('forget-password', 'Login::forget_password');
$routes->get('register', 'Login::register');
$routes->post('register', 'Login::register');



/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
