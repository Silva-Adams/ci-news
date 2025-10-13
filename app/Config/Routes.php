<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Auth::index');
$routes->get('/Auth', 'Auth::index');
$routes->get('/home', 'Home::index');
$routes->get('/about', 'Home::about');