<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/login', 'Auth\Login::index');
$routes->post('/login/process', 'Auth\Login::process');
$routes->get('/logout', 'Auth\Login::logout');

