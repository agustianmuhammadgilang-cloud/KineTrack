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
// =============================
// DOCUMENT REQUEST (GLOBAL & ATASAN)
// =============================

// Tambahkan alias group untuk atasan agar link di view tidak mati
$routes->group('atasan/document-request', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'DocumentRequestController::index');
    $routes->get('my-status', 'DocumentRequestController::status');
    $routes->post('store', 'DocumentRequestController::store');
});

// Group original (untuk Staff atau akses umum)
$routes->group('document-request', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'DocumentRequestController::index');
    $routes->get('my-status', 'DocumentRequestController::status');
    $routes->post('store', 'DocumentRequestController::store');

    // KHUSUS STAFF (Inbox & Approval)
    $routes->group('', ['filter' => 'role:staff'], function($routes) {
        $routes->get('incoming', 'DocumentRequestController::inbox');
        $routes->post('approve/(:num)', 'DocumentRequestController::approve/$1');
        $routes->post('reject/(:num)', 'DocumentRequestController::reject/$1');
    });
});

// Akses file lampiran (Global Auth)
$routes->get('uploads/request/(:any)', 'DocumentRequestController::viewAttachment/$1', ['filter' => 'auth']);

// ==========================
// ADMIN
// ==========================
$routes->group('admin', ['filter' => 'auth'], function($routes) {

    // Dashboard
    $routes->get('/', 'Admin\Dashboard::index');

    // Kelola Jabatan 
    $routes->get('jabatan', 'Admin\Jabatan::index');
    $routes->get('jabatan/create', 'Admin\Jabatan::create');
    $routes->post('jabatan/store', 'Admin\Jabatan::store');
    $routes->get('jabatan/edit/(:num)', 'Admin\Jabatan::edit/$1');
    $routes->post('jabatan/update/(:num)', 'Admin\Jabatan::update/$1');
    $routes->get('jabatan/delete/(:num)', 'Admin\Jabatan::delete/$1');
    // Kelola Jabatan 

    // Kelola Unit Kerja
    $routes->get('bidang', 'Admin\Bidang::index');
    $routes->get('bidang/create', 'Admin\Bidang::create');
    $routes->post('bidang/store', 'Admin\Bidang::store');
    $routes->get('bidang/edit/(:num)', 'Admin\Bidang::edit/$1');
    $routes->post('bidang/update/(:num)', 'Admin\Bidang::update/$1');
    $routes->get('bidang/delete/(:num)', 'Admin\Bidang::delete/$1');
    // Kelola Unit Kerja

    // Kelola Users
    $routes->get('users', 'Admin\User::index');
    $routes->get('users/create', 'Admin\User::create');
    $routes->post('users/store', 'Admin\User::store');
    $routes->get('users/edit/(:num)', 'Admin\User::edit/$1');
    $routes->post('users/update/(:num)', 'Admin\User::update/$1');
    $routes->get('users/delete/(:num)', 'Admin\User::delete/$1');
    $routes->get('users/export-pdf', 'Admin\User::exportPdf');
    // Kelola Users

    // Kelola MASTER: TAHUN
    $routes->get('tahun', 'Admin\TahunAnggaran::index');
    $routes->get('tahun/create', 'Admin\TahunAnggaran::create');
    $routes->post('tahun/store', 'Admin\TahunAnggaran::store');
    $routes->get('tahun/edit/(:num)', 'Admin\TahunAnggaran::edit/$1');
    $routes->post('tahun/update/(:num)', 'Admin\TahunAnggaran::update/$1');
    $routes->get('tahun/delete/(:num)', 'Admin\TahunAnggaran::delete/$1');
    // Kelola MASTER: TAHUN

    // Kelola MASTER: SASARAN
    $routes->get('sasaran', 'Admin\Sasaran::index');
    $routes->get('sasaran/create', 'Admin\Sasaran::create');
    $routes->post('sasaran/store', 'Admin\Sasaran::store');
    $routes->get('sasaran/edit/(:num)', 'Admin\Sasaran::edit/$1');
    $routes->post('sasaran/update/(:num)', 'Admin\Sasaran::update/$1');
    $routes->get('sasaran/delete/(:num)', 'Admin\Sasaran::delete/$1');
    // Kelola MASTER: SASARAN

    // Kelola MASTER: INDIKATOR
    $routes->get('indikator', 'Admin\Indikator::index');
    $routes->get('indikator/create', 'Admin\Indikator::create');
    $routes->post('indikator/store', 'Admin\Indikator::store');
    $routes->get('indikator/edit/(:num)', 'Admin\Indikator::edit/$1');
    $routes->post('indikator/update/(:num)', 'Admin\Indikator::update/$1');
    $routes->get('indikator/delete/(:num)', 'Admin\Indikator::delete/$1');
    
    // Halaman Report Perjanjian Kinerja Admin
    $routes->get('perjanjian-kinerja', 'Admin\PerjanjianKinerja::index');
    $routes->get('perjanjian-kinerja/export-pdf', 'Admin\PerjanjianKinerja::exportPdf');


    // Kelola INPUT PENGUKURAN
    $routes->get('pengukuran', 'Admin\Pengukuran::index'); // pilih tahun & TW
    $routes->post('pengukuran/load', 'Admin\Pengukuran::load'); // ajax ambil indikator
    $routes->post('pengukuran/store', 'Admin\Pengukuran::store'); // simpan bulk
    // Kelola INPUT PENGUKURAN

    // Kelola OUTPUT PENGUKURAN
    $routes->get('pengukuran/output', 'Admin\Pengukuran::output'); // tampil tabel output
    $routes->get('pengukuran/export/(:num)/(:num)', 'Admin\Pengukuran::export/$1/$2'); // export
    // ==== Tambahkan ini (REPORT PDF) ====
    $routes->get('pengukuran/output/report/(:num)/(:num)', 'Admin\Pengukuran::report/$1/$2');
    $routes->get('pengukuran/output/detail/(:num)/(:num)/(:num)', 'Admin\Pengukuran::detail/$1/$2/$3');
    // Kelola OUTPUT PENGUKURAN

    // Kelola Profile
    $routes->get('profile', 'Admin\ProfileController::index');
    $routes->post('profile/update', 'Admin\ProfileController::update');
    $routes->post('profile/password', 'Admin\ProfileController::updatePassword');

    $routes->get('pengajuan-kategori', 'Admin\PengajuanKategori::index');

    $routes->get('pengajuan-kategori/approve/(:num)', 'Admin\PengajuanKategori::approve/$1');
    $routes->get('pengajuan-kategori/reject/(:num)', 'Admin\PengajuanKategori::reject/$1');
    // Kelola Profile
    

    // DOKUMEN TERVALIDASI
    // LEVEL 1 — KATEGORI
    $routes->get('dokumen-tervalidasi', 'Admin\DokumenTervalidasi::kategori');

    // LEVEL 2 — DOKUMEN PER KATEGORI
    $routes->get(
        'dokumen-tervalidasi/(:num)',
        'Admin\DokumenTervalidasi::dokumen/$1'
    );

    $routes->get(
    'pengukuran/detail/(:num)/(:num)/(:num)',
    'Admin\Pengukuran::detail/$1/$2/$3'
);



});

$routes->get(
    'admin/dokumen-tervalidasi',
    'Admin\DokumenTervalidasi::kategori'
);

$routes->get(
    'admin/dokumen-tervalidasi/(:num)',
    'Admin\DokumenTervalidasi::dokumen/$1'
);

$routes->post(
    'admin/dokumen-tervalidasi/update-kategori/(:num)',
    'Admin\DokumenTervalidasi::updateKategori/$1'
);
    // DOKUMEN TERVALIDASI

// ADMIN - DETAIL BIDANG Tidak Berfungsi
$routes->group('admin/bidang', ['filter' => 'auth'], function($routes) {

    $routes->get('detail/export/bidang/(:num)', 'Admin\BidangDetail::exportBidang/$1');
    $routes->get('detail/export/(:num)', 'Admin\BidangDetail::exportPegawai/$1');
    $routes->get('pegawai/(:num)', 'Admin\BidangDetail::pegawaiDetail/$1');
    $routes->get('detail/(:num)', 'Admin\BidangDetail::index/$1');
});

$routes->get('admin/bidang-select', 'Admin\BidangDetail::select', ['filter' => 'auth']);
// ADMIN - DETAIL BIDANG Tidak Berfungsi


// STAFF
$routes->group('staff', ['filter' => 'auth'], function($routes) {
    // Dashboard & Laporan Activity Log
    $routes->get('/', 'Staff\Dashboard::index');  
    $routes->get('activity-logs', 'Staff\ActivityLogController::index');
    $routes->get('dashboard', 'Staff\Dashboard::index');
    $routes->get('laporan', 'Staff\Laporan::index');
    $routes->get('laporan/create', 'Staff\Laporan::create');
    $routes->post('laporan/store', 'Staff\Laporan::store');
    // Progress & Report
    $routes->get('task/progress/(:num)/(:num)', 'Staff\TaskController::progress/$1/$2');
    $routes->get('task/report/(:num)/(:num)', 'Staff\TaskController::report/$1/$2');
    $routes->get('laporan/rejected/(:num)', 'Staff\Laporan::rejected/$1');
    $routes->post('laporan/resubmit/(:num)', 'Staff\Laporan::resubmit/$1');
    // Profile
    $routes->get('profile', 'Staff\Profile::index');
    $routes->post('profile/update', 'Staff\Profile::update');
    // Pengajuan Kategori Dokumen
    $routes->get('kategori/ajukan', 'Staff\PengajuanKategori::create');
    $routes->post('kategori/ajukan/store', 'Staff\PengajuanKategori::store');

});

// ATASAN
$routes->get('atasan', 'Atasan\Dashboard::index', ['filter' => 'auth']);

$routes->group('atasan', ['filter' => 'auth'], function($routes){
    // Profile
    $routes->get('profile', 'Atasan\Profile::index');
    $routes->post('profile/update', 'Atasan\Profile::update');
    //laporan
    $routes->get('laporan', 'Atasan\Laporan::index');
    $routes->get('laporan/detail/(:num)', 'Atasan\Laporan::detail/$1');
    $routes->get('laporan/approve/(:num)', 'Atasan\Laporan::approve/$1');
    $routes->post('laporan/reject/(:num)', 'Atasan\Laporan::reject/$1');
    //notifications
    $routes->get('notifications/pending-count', 'Atasan\Notifications::pendingCount');
    $routes->get('notifications/list', 'Atasan\Notifications::list');
});
// =============================
// AJAX ROUTES
// Admin SASARAN & INDIKATOR - AJAX
$routes->get('admin/indikator/getKode/(:num)', 'Admin\Indikator::getKode/$1');
$routes->get('admin/sasaran/getKode/(:num)', 'Admin\Sasaran::getKode/$1');
// Admin PIC - AJAX
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
    // CRUD Pengukuran
    $routes->get('edit/(:num)', 'Admin\Pengukuran::edit/$1');
    $routes->post('update/(:num)', 'Admin\Pengukuran::update/$1');
    $routes->get('delete/(:num)', 'Admin\Pengukuran::delete/$1');
    $routes->get('pdf/(:num)', 'Admin\Pengukuran::exportPdf/$1');

    // ==== Tambahkan ini ====
    $routes->get('deleteFile/(:num)/(:num)', 'Admin\Pengukuran::deleteFile/$1/$2');
});


$routes->group('admin/tw', ['namespace' => 'App\Controllers\Admin'], function($routes){
    // TW Controller
    $routes->get('/', 'TwController::index');
    $routes->get('toggle/(:num)', 'TwController::toggle/$1');
});

$routes->get(
    // Report Pengukuran
    'admin/pengukuran/output/report/(:num)/(:num)/(:segment)',
    'Admin\Pengukuran::report/$1/$2/$3'
);

$routes->get(
    // Report Task Staff
    'staff/task/report/(:num)/(:num)/(:segment)',
    'Staff\TaskController::report/$1/$2/$3'
);

$routes->group('staff', ['filter' => 'auth'], function ($routes) {

    // =====================
    // DOKUMEN
    // =====================

    // Riwayat semua dokumen milik user
    $routes->get('dokumen', 'Staff\Dokumen::index');

    // Dokumen Personal (Dokumen Saya)
    $routes->get('dokumen/saya', 'Staff\Dokumen::personal');

    // Dokumen Unit
    $routes->get('dokumen/unit', 'Staff\Dokumen::unit');
 
    // Create & Store
    $routes->get('dokumen/create', 'Staff\Dokumen::create');
    $routes->post('dokumen/store', 'Staff\Dokumen::store');

    // Revisi
    $routes->get('dokumen/resubmit/(:num)', 'Staff\Dokumen::resubmit/$1');
    $routes->post('dokumen/resubmit/(:num)', 'Staff\Dokumen::processResubmit/$1');

    // Arsip
    $routes->get('dokumen/arsip', 'Staff\Dokumen::arsip');
     $routes->get('dokumen/public', 'Staff\Dokumen::public');

      // ✅ Tambahkan route export PDF di sini
    $routes->get('dokumen/export_pdf', 'Staff\Dokumen::exportArsipPdf');
    $routes->get('dokumen/exportArsipExcel', 'Staff\Dokumen::exportArsipExcel');

});


// =======================
// ATASAN ROUTES (FINAL)
// =======================
$routes->group('atasan', ['filter' => 'auth'], function ($routes) {

    // =====================
    // DASHBOARD & PROFILE
    // =====================
    $routes->get('/', 'Atasan\Dashboard::index');
    $routes->get('profile', 'Atasan\Profile::index');
    $routes->post('profile/update', 'Atasan\Profile::update');
     $routes->get('activity-log', 'Atasan\ActivityLogController::index');

    // =====================
    // LAPORAN
    // =====================
    $routes->get('laporan', 'Atasan\Laporan::index');
    $routes->get('laporan/detail/(:num)', 'Atasan\Laporan::detail/$1');
    $routes->get('laporan/approve/(:num)', 'Atasan\Laporan::approve/$1');
    $routes->post('laporan/reject/(:num)', 'Atasan\Laporan::reject/$1');

    // =====================
    // NOTIFICATIONS
    // =====================
    $routes->get('notifications/pending-count', 'Atasan\Notifications::pendingCount');
    $routes->get('notifications/list', 'Atasan\Notifications::list');

    // =====================
    // DOKUMEN
    // =====================
    $routes->get('dokumen', 'Atasan\Dokumen::index');
    $routes->get('dokumen/unit', 'Atasan\Dokumen::unit');
    $routes->get('dokumen/review/(:num)', 'Atasan\Dokumen::review/$1');
    $routes->post('dokumen/approve/(:num)', 'Atasan\Dokumen::approve/$1');
    $routes->post('dokumen/reject/(:num)', 'Atasan\Dokumen::reject/$1');
    $routes->get('dokumen/public', 'Atasan\Dokumen::public');
    $routes->get('dokumen/arsip', 'Atasan\Dokumen::arsip');

    // export PDF arsip dokumen
    $routes->get('dokumen/export_pdf', 'Atasan\Dokumen::exportArsipPdf');
    $routes->get('dokumen/export_excel_arsip', 'Atasan\Dokumen::exportArsipExcel');

    

    // =====================
    // ⬇️ TAMBAHAN HALAMAN BARU (DARI STAFF)
    // =====================
    $routes->get('task', 'Atasan\TaskController::index');
        $routes->get('task/input/(:num)/(:num)', 'Atasan\TaskController::input/$1/$2');
        $routes->post('task/store', 'Atasan\TaskController::store');
        $routes->get('task/progress/(:num)/(:num)', 'Atasan\TaskController::progress/$1/$2');
        $routes->get(
                        'task/report/(:num)/(:num)',
                        'Atasan\TaskController::report/$1/$2'
                    );
        $routes->get(
                        'task/report/(:num)/(:num)/(:segment)',
                        'Atasan\TaskController::report/$1/$2/$3'
                    );


});

// =======================
// ADMIN ROUTES (FINAL)
// =======================
$routes->post('admin/users/delete/(:num)', 'Admin\User::delete/$1');

$routes->group('admin', ['filter' => 'auth'], function ($routes) {

    // =====================
    // KATEGORI DOKUMEN
    $routes->get('kategori-dokumen', 'Admin\KategoriDokumen::index');
    $routes->get('kategori-dokumen/create', 'Admin\KategoriDokumen::create');
    $routes->post('kategori-dokumen/store', 'Admin\KategoriDokumen::store');

    $routes->get('kategori-dokumen/edit/(:num)', 'Admin\KategoriDokumen::edit/$1');
    $routes->post('kategori-dokumen/update/(:num)', 'Admin\KategoriDokumen::update/$1');

    $routes->get('kategori-dokumen/toggle/(:num)', 'Admin\KategoriDokumen::toggleStatus/$1');

$routes->get('kategori-dokumen/export', 'Admin\KategoriDokumen::export');
$routes->get(
    'kategori-dokumen/export-excel',
    'Admin\KategoriDokumen::exportExcel'
);



// =====================
// PIC - EXPORT PDF
// =====================
$routes->get('pic/export_pdf', 'Admin\PicController::exportPdf');

//excel user
$routes->get('users/export-excel', 'Admin\User::exportExcel');
//perjanjian kinerja
$routes->get('perjanjian-kinerja/export-excel', 'Admin\PerjanjianKinerja::exportExcel');
//manajemen pic
$routes->get('pic/export-excel', 'Admin\PicController::exportExcel');


    // =====================
    // DOKUMEN
    // =====================

    $routes->get('dokumen-tervalidasi', 'Admin\DokumenTervalidasi::kategori');
    $routes->get('dokumen-tervalidasi/(:num)', 'Admin\DokumenTervalidasi::dokumen/$1');

    $routes->get('dokumen-tidak-tervalidasi', 'Admin\DokumenTidakTervalidasi::kategori');
    $routes->get('dokumen-tidak-tervalidasi/(:num)', 'Admin\DokumenTidakTervalidasi::dokumen/$1');

    // DOKUMEN TIDAK TERVALIDASI
    $routes->get('dokumen-tidak-tervalidasi', 'Admin\DokumenTidakTervalidasi::kategori');

    $routes->get(
        'dokumen-tidak-tervalidasi/dokumen/(:num)',
        'Admin\DokumenTidakTervalidasi::dokumen/$1'
    );
    
    // =====================
    // ACTIVITY LOG
    // =====================
    $routes->get('activity-logs', 'Admin\ActivityLogController::index');

    // Log arsip
    $routes->get('activity-logs/archive', 'Admin\ActivityLogArchiveController::index');
    // Backup & Restore
    $routes->post('activity-logs/archive/backup', 'Admin\ActivityLogArchiveController::backup');
$routes->post('activity-logs/archive/restore', 'Admin\ActivityLogArchiveController::restore');
//Log Schedule
$routes->get('activity-logs/schedule', 'Admin\ActivityLogScheduleController::index');
$routes->post('activity-logs/schedule', 'Admin\ActivityLogScheduleController::update');
// Log Backup & Restore
$routes->get('activity-logs/backup', 'Admin\ActivityLogBackupController::index');
$routes->post('activity-logs/backup/run', 'Admin\ActivityLogBackupController::backup');
$routes->post('activity-logs/backup/restore', 'Admin\ActivityLogBackupController::restore');
// Log Cleanup
$routes->get('activity-logs/cleanup', 'Admin\LogCleanupController::index');
$routes->post('activity-logs/cleanup/run', 'Admin\LogCleanupController::run');
// Log Backup Download
$routes->get('activity-logs/backup/download/(:any)', 'Admin\ActivityLogBackupController::download/$1');

// =====================
// SYSTEM REMINDER (AUDIT)
// =====================
$routes->get('activity-logs/reminder', 'Admin\ActivityLogReminderController::index');
});
// ==========================
// GRAFIK KINERJA - ADMIN
// ==========================
$routes->group('admin/grafik', ['filter' => 'auth'], function($routes) {

    // LEVEL 1 — Grafik Tahun
    $routes->get('/', 'Admin\GrafikKinerja::index');

    // LEVEL 2 — Grafik Triwulan per Indikator
    $routes->get('triwulan/(:num)', 'Admin\GrafikKinerja::triwulan/$1');

    // AJAX — GRAFIK INDIKATOR PER TAHUN
    $routes->get('data-indikator/(:num)', 'Admin\GrafikKinerja::dataIndikator/$1');
});

// STAFF
$routes->group('staff/grafik', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'Staff\GrafikKinerja::index');
    $routes->get('data-indikator/(:num)', 'Staff\GrafikKinerja::dataIndikator/$1');
    $routes->get('triwulan/(:num)', 'Staff\GrafikKinerja::triwulan/$1');
});



// ATASAN
$routes->group('atasan/grafik', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'Atasan\GrafikKinerja::index');
    $routes->get('data-indikator/(:num)', 'Atasan\GrafikKinerja::dataIndikator/$1');
    $routes->get('triwulan/(:num)', 'Atasan\GrafikKinerja::triwulan/$1');
});


$routes->get('badge/pengukuran', 'BadgeController::pengukuran');
$routes->get('badge/pengajuan', 'BadgeController::pengajuan');
$routes->post('badge/pengajuan/mark-all', 'BadgeController::markPengajuanRead');
$routes->get('badge/dokumen-atasan', 'BadgeController::dokumenKinerja');

$routes->post('badge/dokumen-atasan/mark-all', 'BadgeController::markDokumenRead');

$routes->get('badge/dokumen-unit', 'BadgeController::dokumenUnit');
$routes->get('badge/dokumen-public', 'BadgeController::dokumenPublic');

$routes->post('badge/dokumen-unit/mark-all', 'BadgeController::markDokumenUnitRead');
$routes->post('badge/dokumen-public/mark-all', 'BadgeController::markDokumenPublicRead');

// Badge Dokumen untuk STAFF
$routes->get('badge/staff-dokumen-unit', 'BadgeController::staffDokumenUnit');
$routes->post('badge/staff-dokumen-unit/mark-all', 'BadgeController::markStaffDokumenUnitRead');

$routes->get('badge/staff-dokumen-public', 'BadgeController::staffDokumenPublic');
$routes->post('badge/staff-dokumen-public/mark-all', 'BadgeController::markStaffDokumenPublicRead');

$routes->post('admin/notifikasi/read-all', 'Admin\Dashboard::markAllRead');
