<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Landing::index');
$routes->get('/login', 'Auth\Login::index');
$routes->post('/login/process', 'Auth\Login::process');
$routes->get('/logout', 'Auth\Login::logout');
$routes->group('admin', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'Admin\Dashboard::index');
});

$routes->group('admin', ['filter' => 'auth'], function($routes) {

    // Jabatan
    $routes->get('jabatan', 'Admin\Jabatan::index');
    $routes->get('jabatan/create', 'Admin\Jabatan::create');
    $routes->post('jabatan/store', 'Admin\Jabatan::store');
    $routes->get('jabatan/edit/(:num)', 'Admin\Jabatan::edit/$1');
    $routes->post('jabatan/update/(:num)', 'Admin\Jabatan::update/$1');
    $routes->get('jabatan/delete/(:num)', 'Admin\Jabatan::delete/$1');

    // Bidang
    $routes->get('bidang', 'Admin\Bidang::index');
    $routes->get('bidang/create', 'Admin\Bidang::create');
    $routes->post('bidang/store', 'Admin\Bidang::store');
    $routes->get('bidang/edit/(:num)', 'Admin\Bidang::edit/$1');
    $routes->post('bidang/update/(:num)', 'Admin\Bidang::update/$1');
    $routes->get('bidang/delete/(:num)', 'Admin\Bidang::delete/$1');
});


