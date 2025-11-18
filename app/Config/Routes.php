<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Landing::index');

// AUTH
$routes->get('/login', 'Auth\Login::index');
$routes->post('/login/process', 'Auth\Login::process');
$routes->get('/logout', 'Auth\Login::logout');

// ==========================
// ADMIN
// ==========================
$routes->group('admin', ['filter' => 'auth'], function($routes) {

    // Dashboard
    $routes->get('/', 'Admin\Dashboard::index');

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

    // Users
    $routes->get('users', 'Admin\User::index');
    $routes->get('users/create', 'Admin\User::create');
    $routes->post('users/store', 'Admin\User::store');
    $routes->get('users/edit/(:num)', 'Admin\User::edit/$1');
    $routes->post('users/update/(:num)', 'Admin\User::update/$1');
    $routes->get('users/delete/(:num)', 'Admin\User::delete/$1');

});


// ==========================
// STAFF
// ==========================
$routes->group('staff', ['filter' => 'auth'], function($routes) {

    // dashboard staff
    $routes->get('/', 'Staff\Laporan::index');

    // laporan staff
    $routes->get('laporan', 'Staff\Laporan::index');
    $routes->get('laporan/create', 'Staff\Laporan::create');
    $routes->post('laporan/store', 'Staff\Laporan::store');

    // fitur baru (rejected)
    $routes->get('laporan/rejected/(:num)', 'Staff\Laporan::rejected/$1');
    $routes->post('laporan/resubmit/(:num)', 'Staff\Laporan::resubmit/$1');

    $routes->get('profile', 'Staff\Profile::index');
    $routes->post('profile/update', 'Staff\Profile::update');
});


// ==========================
// ATASAN
// ==========================
$routes->get('atasan', 'Atasan\Dashboard::index', ['filter' => 'auth']);

$routes->group('atasan', ['filter' => 'auth'], function($routes){

    $routes->get('profile', 'Atasan\Profile::index');
    $routes->post('profile/update', 'Atasan\Profile::update');

    $routes->get('laporan', 'Atasan\Laporan::index');
    $routes->get('laporan/detail/(:num)', 'Atasan\Laporan::detail/$1');

    // approval
    $routes->get('laporan/approve/(:num)', 'Atasan\Laporan::approve/$1');
    $routes->post('laporan/reject/(:num)', 'Atasan\Laporan::reject/$1');

    
});


// polling / API sederhana untuk notifikasi atasan
$routes->get('atasan/notifications/pending-count', 'Atasan\Notifications::pendingCount', ['filter' => 'auth']);
$routes->get('atasan/notifications/list', 'Atasan\Notifications::list', ['filter' => 'auth']); // optional - untuk detail
