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

<<<<<<< HEAD
<<<<<<< Updated upstream
=======

>>>>>>> e46c4d0ddadcc5a20da1fc0e3141f6c6d3caf987
});


// ------------------------
// Tambahan Routes dari Repan
// ------------------------
$routes->group('admin', ['filter' => 'auth'], function($routes) {

    // ====== MASTER: TAHUN ======
    $routes->get('tahun', 'Admin\TahunAnggaran::index');
    $routes->get('tahun/create', 'Admin\TahunAnggaran::create');
    $routes->post('tahun/store', 'Admin\TahunAnggaran::store');
    $routes->get('tahun/edit/(:num)', 'Admin\TahunAnggaran::edit/$1');
    $routes->post('tahun/update/(:num)', 'Admin\TahunAnggaran::update/$1');
    $routes->get('tahun/delete/(:num)', 'Admin\TahunAnggaran::delete/$1');


    // ====== MASTER: SASARAN ======
    $routes->get('sasaran', 'Admin\Sasaran::index');
    $routes->get('sasaran/create', 'Admin\Sasaran::create');
    $routes->post('sasaran/store', 'Admin\Sasaran::store');
    $routes->get('sasaran/edit/(:num)', 'Admin\Sasaran::edit/$1');
    $routes->post('sasaran/update/(:num)', 'Admin\Sasaran::update/$1');
    $routes->get('sasaran/delete/(:num)', 'Admin\Sasaran::delete/$1');

    // ====== MASTER: INDIKATOR ======
    $routes->get('indikator', 'Admin\Indikator::index');
    $routes->get('indikator/create', 'Admin\Indikator::create');
    $routes->post('indikator/store', 'Admin\Indikator::store');
    $routes->get('indikator/edit/(:num)', 'Admin\Indikator::edit/$1');
    $routes->post('indikator/update/(:num)', 'Admin\Indikator::update/$1');
    $routes->get('indikator/delete/(:num)', 'Admin\Indikator::delete/$1');

    // ====== INPUT PENGUKURAN ======
    $routes->get('pengukuran', 'Admin\Pengukuran::index'); // pilih tahun & TW
    $routes->post('pengukuran/load', 'Admin\Pengukuran::load'); // ajax ambil indikator
    $routes->post('pengukuran/store', 'Admin\Pengukuran::store'); // simpan bulk

    // ====== OUTPUT PENGUKURAN ======
    $routes->get('pengukuran/output', 'Admin\Pengukuran::output'); // tampil tabel output
    $routes->get('pengukuran/export/(:num)/(:num)', 'Admin\Pengukuran::export/$1/$2'); // export
});




// ==========================
// ADMIN - DETAIL BIDANG
// ==========================
$routes->group('admin/bidang', ['filter' => 'auth'], function($routes) {
=======

    });


    // ------------------------
    // Tambahan Routes dari Repan
    // ------------------------
    $routes->group('admin', ['filter' => 'auth'], function($routes) {

        // ====== MASTER: TAHUN ======
        $routes->get('tahun', 'Admin\TahunAnggaran::index');
        $routes->get('tahun/create', 'Admin\TahunAnggaran::create');
        $routes->post('tahun/store', 'Admin\TahunAnggaran::store');
        $routes->get('tahun/edit/(:num)', 'Admin\TahunAnggaran::edit/$1');
        $routes->post('tahun/update/(:num)', 'Admin\TahunAnggaran::update/$1');
        $routes->get('tahun/delete/(:num)', 'Admin\TahunAnggaran::delete/$1');


        // ====== MASTER: SASARAN ======
        $routes->get('sasaran', 'Admin\Sasaran::index');
        $routes->get('sasaran/create', 'Admin\Sasaran::create');
        $routes->post('sasaran/store', 'Admin\Sasaran::store');
        $routes->get('sasaran/edit/(:num)', 'Admin\Sasaran::edit/$1');
        $routes->post('sasaran/update/(:num)', 'Admin\Sasaran::update/$1');
        $routes->get('sasaran/delete/(:num)', 'Admin\Sasaran::delete/$1');

        // ====== MASTER: INDIKATOR ======
        $routes->get('indikator', 'Admin\Indikator::index');
        $routes->get('indikator/create', 'Admin\Indikator::create');
        $routes->post('indikator/store', 'Admin\Indikator::store');
        $routes->get('indikator/edit/(:num)', 'Admin\Indikator::edit/$1');
        $routes->post('indikator/update/(:num)', 'Admin\Indikator::update/$1');
        $routes->get('indikator/delete/(:num)', 'Admin\Indikator::delete/$1');

        // ====== INPUT PENGUKURAN ======
        $routes->get('pengukuran', 'Admin\Pengukuran::index'); // pilih tahun & TW
        $routes->post('pengukuran/load', 'Admin\Pengukuran::load'); // ajax ambil indikator
        $routes->post('pengukuran/store', 'Admin\Pengukuran::store'); // simpan bulk

        // ====== OUTPUT PENGUKURAN ======
        $routes->get('pengukuran/output', 'Admin\Pengukuran::output'); // tampil tabel output
        $routes->get('pengukuran/export/(:num)/(:num)', 'Admin\Pengukuran::export/$1/$2'); // export
    });




    // ==========================
    // ADMIN - DETAIL BIDANG
    // ==========================
    $routes->group('admin/bidang', ['filter' => 'auth'], function($routes) {
>>>>>>> Stashed changes

        // Tahap 4 → Export Bidang (lebih spesifik → TARUH PALING ATAS)
        $routes->get('detail/export/bidang/(:num)', 'Admin\BidangDetail::exportBidang/$1');

        // Tahap 3 → Export Pegawai
        $routes->get('detail/export/(:num)', 'Admin\BidangDetail::exportPegawai/$1');

        // Tahap 2 → Detail Pegawai (Card Level 2)
        $routes->get('pegawai/(:num)', 'Admin\BidangDetail::pegawaiDetail/$1');

        // Tahap 1 → Halaman Detail Bidang (List Pegawai + Card Level 1)
        $routes->get('detail/(:num)', 'Admin\BidangDetail::index/$1');
    });


    $routes->get('admin/bidang-select', 'Admin\BidangDetail::select', ['filter' => 'auth']);



    // ==========================
    // STAFF
    // ==========================
    $routes->group('staff', ['filter' => 'auth'], function($routes) {

        // Dashboard Staff (NEW)
        $routes->get('/', 'Staff\Dashboard::index');  
        $routes->get('dashboard', 'Staff\Dashboard::index');

        // Laporan Staff
        $routes->get('laporan', 'Staff\Laporan::index');
        $routes->get('laporan/create', 'Staff\Laporan::create');
        $routes->post('laporan/store', 'Staff\Laporan::store');

        // Laporan ditolak / rejected
        $routes->get('laporan/rejected/(:num)', 'Staff\Laporan::rejected/$1');
        $routes->post('laporan/resubmit/(:num)', 'Staff\Laporan::resubmit/$1');

        // Profile Staff
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


