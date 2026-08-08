<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// Public routes (no auth required)
$routes->add('auth/login', 'Auth::login');
$routes->add('auth/forgot_password', 'Auth::forgot_password');
$routes->add('auth/create_user', 'Auth::create_user');

// Protected routes (auth required)
$routes->get('/', 'Auth::index', ['filter' => 'auth']);
$routes->group('auth', ['filter' => 'auth'], function ($routes) {
	$routes->get('logout', 'Auth::logout');
	$routes->get('/', 'Auth::index');
	$routes->add('create_user', 'Auth::create_user');
	$routes->add('edit_user/(:num)', 'Auth::edit_user/$1');
	$routes->add('create_group', 'Auth::create_group');
	$routes->add('change_password', 'Auth::change_password');
	$routes->get('activate/(:num)', 'Auth::activate/$1');
	$routes->get('activate/(:num)/(:hash)', 'Auth::activate/$1/$2');
	$routes->add('deactivate/(:num)', 'Auth::deactivate/$1');
	$routes->get('reset_password/(:hash)', 'Auth::reset_password/$1');
	$routes->post('reset_password/(:hash)', 'Auth::reset_password/$1');
	$routes->add('welcome', 'Auth::welcome_message');
	$routes->get('welcome', 'Auth::welcome_message');
	// ...
});
