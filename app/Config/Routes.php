<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\Pages;
use App\Controllers\News;

/**
 * @var RouteCollection $routes
 */
// Public routes (no auth required)
$routes->match(['get', 'post'], 'auth/login', 'Auth::login');
$routes->match(['get', 'post'], 'auth/forgot_password', 'Auth::forgot_password');

// Protected routes (auth required)
$routes->get('/', 'Auth::index', ['filter' => 'auth']);
$routes->group('auth', ['filter' => 'auth'], function ($routes) {
	$routes->get('logout', 'Auth::logout');
	$routes->get('index', 'Auth::index');
	$routes->match(['get', 'post'], 'create_user', 'Auth::create_user');
	$routes->match(['get', 'post'], 'edit_user/(:num)', 'Auth::edit_user/$1');
	$routes->match(['get', 'post'], 'create_group', 'Auth::create_group');
	$routes->match(['get', 'post'], 'change_password', 'Auth::change_password');
	$routes->get('activate/(:num)', 'Auth::activate/$1');
	$routes->get('activate/(:num)/(:hash)', 'Auth::activate/$1/$2');
	$routes->match(['get', 'post'], 'deactivate/(:num)', 'Auth::deactivate/$1');
	$routes->match(['get', 'post'], 'reset_password/(:hash)', 'Auth::reset_password/$1');
	$routes->match(['get', 'post'], 'welcome', 'Auth::welcome_message');
	$routes->get('pages/(:segment)', [Pages::class, 'view']);
	$routes->match(['get', 'post'], 'news/(:segment)', [Pages::class, 'view']);
	$routes->get('news', [News::class, 'index']);
	$routes->get('pages/(:segment)', [Pages::class, 'view']);
	$routes->get('news/(:segment)', 'News::show/$1');

});
