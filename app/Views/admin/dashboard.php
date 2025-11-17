<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Kinetrack</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --polban-blue: #1D2F83;
            --polban-orange: #F58025;
        }

        body {
            background-color: #f5f7fa;
        }

        .sidebar {
            height: 100vh;
            background-color: var(--polban-blue);
            padding-top: 20px;
            position: fixed;
        }

        .sidebar a {
            color: #f0f0f0;
            padding: 12px 20px;
            display: block;
            font-size: 15px;
            text-decoration: none;
        }

        .sidebar a:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: var(--polban-orange);
        }

        .sidebar .active {
            background-color: var(--polban-orange);
            color: white;
        }

        .content {
            margin-left: 250px;
            padding: 35px;
        }

        .topbar {
            background-color: white;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 25px;
            display: flex;
            justify-content: space-between;
        }

        .card-stat {
            border-left: 6px solid var(--polban-orange);
            border-radius: 10px;
        }

        .logout-btn {
            background-color: var(--polban-orange);
            color: white;
        }

        .logout-btn:hover {
            background-color: #c7671e;
        }
    </style>
</head>

<body>

    <!-- SIDEBAR -->
    <div class="sidebar">
        <h4 class="text-center text-white mb-4">KINETRACK</h4>

        <a href="<?= base_url('admin'); ?>" class="active">📊 Dashboard</a>
        <a href="<?= base_url('admin/users'); ?>">👤 Manajemen User</a>
        <a href="<?= base_url('admin/jabatan'); ?>">🏅 Manajemen Jabatan</a>
        <a href="<?= base_url('admin/bidang'); ?>">📁 Manajemen Bidang</a>

        <hr class="text-white mx-3">

        <a href="<?= base_url('/logout'); ?>" class="logout-btn text-center mx-3 mt-3">Logout</a>
    </div>

    <!-- CONTENT -->
    <div class="content">

        <!-- TOPBAR -->
        <div class="topbar shadow-sm">
            <h5 class="fw-bold">Dashboard Admin</h5>
            <div>Halo, <strong><?= session('nama'); ?></strong></div>
        </div>

        <!-- STAT CARDS -->
        <div class="row">

            <div class="col-md-4 mb-3">
                <div class="card p-3 shadow card-stat">
                    <h6>Total User</h6>
                    <h3 class="fw-bold text-polban-orange">32</h3>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card p-3 shadow card-stat">
                    <h6>Total Jabatan</h6>
                    <h3 class="fw-bold">4</h3>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card p-3 shadow card-stat">
                    <h6>Total Bidang</h6>
                    <h3 class="fw-bold">6</h3>
                </div>
            </div>

        </div>

        <!-- WELCOME -->
        <div class="card shadow p-4 mt-4">
            <h5 class="fw-bold">Selamat datang di Admin Panel Kinetrack</h5>
            <p class="mt-2">Gunakan menu di sebelah kiri untuk mengelola sistem.</p>
        </div>

    </div>

</body>

</html>