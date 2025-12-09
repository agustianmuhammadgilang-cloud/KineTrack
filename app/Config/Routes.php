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

    // Bidang CRUD
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

    // MASTER: TAHUN
    $routes->get('tahun', 'Admin\TahunAnggaran::index');
    $routes->get('tahun/create', 'Admin\TahunAnggaran::create');
    $routes->post('tahun/store', 'Admin\TahunAnggaran::store');
    $routes->get('tahun/edit/(:num)', 'Admin\TahunAnggaran::edit/$1');
    $routes->post('tahun/update/(:num)', 'Admin\TahunAnggaran::update/$1');
    $routes->get('tahun/delete/(:num)', 'Admin\TahunAnggaran::delete/$1');

    // MASTER: SASARAN
    $routes->get('sasaran', 'Admin\Sasaran::index');
    $routes->get('sasaran/create', 'Admin\Sasaran::create');
    $routes->post('sasaran/store', 'Admin\Sasaran::store');
    $routes->get('sasaran/edit/(:num)', 'Admin\Sasaran::edit/$1');
    $routes->post('sasaran/update/(:num)', 'Admin\Sasaran::update/$1');
    $routes->get('sasaran/delete/(:num)', 'Admin\Sasaran::delete/$1');

    // MASTER: INDIKATOR
    $routes->get('indikator', 'Admin\Indikator::index');
    $routes->get('indikator/create', 'Admin\Indikator::create');
    $routes->post('indikator/store', 'Admin\Indikator::store');
    $routes->get('indikator/edit/(:num)', 'Admin\Indikator::edit/$1');
    $routes->post('indikator/update/(:num)', 'Admin\Indikator::update/$1');
    $routes->get('indikator/delete/(:num)', 'Admin\Indikator::delete/$1');

    // INPUT PENGUKURAN
    $routes->get('pengukuran', 'Admin\Pengukuran::index'); // pilih tahun & TW
    $routes->post('pengukuran/load', 'Admin\Pengukuran::load'); // ajax ambil indikator
    $routes->post('pengukuran/store', 'Admin\Pengukuran::store'); // simpan bulk

    // OUTPUT PENGUKURAN
    $routes->get('pengukuran/output', 'Admin\Pengukuran::output'); // tampil tabel output
    $routes->get('pengukuran/export/(:num)/(:num)', 'Admin\Pengukuran::export/$1/$2'); // export
    $routes->get('pengukuran/output/detail/(:num)/(:num)/(:num)', 'Admin\Pengukuran::detail/$1/$2/$3');

    // Profile
    $routes->get('profile', 'Admin\ProfileController::index');
    $routes->post('profile/update', 'Admin\ProfileController::update');
    $routes->post('profile/password', 'Admin\ProfileController::updatePassword');


    
});

// ADMIN - DETAIL BIDANG
$routes->group('admin/bidang', ['filter' => 'auth'], function($routes) {

    $routes->get('detail/export/bidang/(:num)', 'Admin\BidangDetail::exportBidang/$1');
    $routes->get('detail/export/(:num)', 'Admin\BidangDetail::exportPegawai/$1');
    $routes->get('pegawai/(:num)', 'Admin\BidangDetail::pegawaiDetail/$1');
    $routes->get('detail/(:num)', 'Admin\BidangDetail::index/$1');
});

$routes->get('admin/bidang-select', 'Admin\BidangDetail::select', ['filter' => 'auth']);

// STAFF
$routes->group('staff', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'Staff\Dashboard::index');  
    $routes->get('dashboard', 'Staff\Dashboard::index');
    $routes->get('laporan', 'Staff\Laporan::index');
    $routes->get('laporan/create', 'Staff\Laporan::create');
    $routes->post('laporan/store', 'Staff\Laporan::store');
    $routes->get('laporan/rejected/(:num)', 'Staff\Laporan::rejected/$1');
    $routes->post('laporan/resubmit/(:num)', 'Staff\Laporan::resubmit/$1');
    $routes->get('profile', 'Staff\Profile::index');
    $routes->post('profile/update', 'Staff\Profile::update');

});

// ATASAN
$routes->get('atasan', 'Atasan\Dashboard::index', ['filter' => 'auth']);

$routes->group('atasan', ['filter' => 'auth'], function($routes){
    $routes->get('profile', 'Atasan\Profile::index');
    $routes->post('profile/update', 'Atasan\Profile::update');
    $routes->get('laporan', 'Atasan\Laporan::index');
    $routes->get('laporan/detail/(:num)', 'Atasan\Laporan::detail/$1');
    $routes->get('laporan/approve/(:num)', 'Atasan\Laporan::approve/$1');
    $routes->post('laporan/reject/(:num)', 'Atasan\Laporan::reject/$1');
    $routes->get('notifications/pending-count', 'Atasan\Notifications::pendingCount');
    $routes->get('notifications/list', 'Atasan\Notifications::list');
});

$routes->get('admin/indikator/getKode/(:num)', 'Admin\Indikator::getKode/$1');
$routes->get('admin/sasaran/getKode/(:num)', 'Admin\Sasaran::getKode/$1');


$routes->get('admin/pic/getSasaran', 'Admin\PicController::getSasaran');
$routes->get('admin/pic/getIndikator', 'Admin\PicController::getIndikator');
$routes->get('admin/pic/getJabatan', 'Admin\PicController::getJabatan');
$routes->get('admin/pic/getPegawai', 'Admin\PicController::getPegawai');

// Admin PIC
$routes->get('admin/pic', 'Admin\PicController::index');
$routes->get('admin/pic/create', 'Admin\PicController::create');
$routes->post('admin/pic/store', 'Admin\PicController::store');
$routes->get('admin/pic/edit/(:num)', 'Admin\PicController::edit/$1');
$routes->post('admin/pic/update/(:num)', 'Admin\PicController::update/$1');
$routes->get('admin/pic/delete/(:num)', 'Admin\PicController::delete/$1');


/// Staff Task
$routes->group('staff', ['filter' => 'auth'], function($routes) {
    $routes->get('task', 'Staff\TaskController::index');             // daftar task PIC staff
    $routes->get('task/input/(:num)', 'Staff\TaskController::input/$1'); // optional: detail input per indikator
    $routes->post('task/store', 'Staff\TaskController::store');      // simpan input indikator
    $routes->get('task/input/(:num)/(:num)', 'Staff\TaskController::input/$1/$2');
});

// =============================
// NOTIFICATIONS
// =============================

// Jumlah unread
$routes->get('notifications/unread-count', 'Notifications::unreadCount');

// List notif (default 10 atau pakai parameter)
$routes->get('notifications/list', 'Notifications::list');
$routes->get('notifications/list/(:num)', 'Notifications::list/$1');

// === PENTING: Notifikasi terbaru untuk toast popup ===
$routes->get('notifications/latest', 'Notifications::latest'); // <-- FIX

// Mark single read
$routes->post('notifications/mark/(:num)', 'Notifications::mark/$1');

// Mark all read
$routes->post('notifications/mark-all', 'Notifications::markAll');

// Pending task count (jika dipakai staff)
$routes->get('notifications/pending-count', 'Notifications::pendingTaskCount');

$routes->group('admin/pengukuran', function($routes) {
    $routes->get('edit/(:num)', 'Admin\Pengukuran::edit/$1');
    $routes->post('update/(:num)', 'Admin\Pengukuran::update/$1');
    $routes->get('delete/(:num)', 'Admin\Pengukuran::delete/$1');
    $routes->get('pdf/(:num)', 'Admin\Pengukuran::exportPdf/$1');
});

$routes->group('admin/tw', ['namespace' => 'App\Controllers\Admin'], function($routes){
    $routes->get('/', 'TwController::index');
    $routes->get('toggle/(:num)', 'TwController::toggle/$1');
});