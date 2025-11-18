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
            background-color: #eef1f6;
        }

        /* SIDEBAR */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 250px;
            height: 100vh;
            background-color: var(--polban-blue);
            padding-top: 25px;
            overflow-y: auto;
        }

        .sidebar h4 {
            color: white;
            letter-spacing: 1.5px;
            margin-bottom: 25px;
        }

        .sidebar a {
            color: #e9e9e9;
            padding: 12px 20px;
            display: block;
            font-size: 15px;
            text-decoration: none;
            transition: 0.2s;
        }

        .sidebar a:hover {
            background-color: rgba(255, 255, 255, 0.12);
            color: var(--polban-orange);
            padding-left: 25px;
        }

        .sidebar .active {
            background-color: var(--polban-orange);
            color: white !important;
            border-radius: 6px;
        }

        /* CONTENT AREA */
        .content {
            margin-left: 260px;
            padding: 35px;
        }

        /* TOPBAR */
        .topbar {
            background-color: white;
            padding: 15px 22px;
            border-radius: 10px;
            margin-bottom: 25px;
            box-shadow: 0px 2px 6px rgba(0, 0, 0, .05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* STAT CARDS */
        .stat-card {
            background-color: white;
            padding: 22px;
            border-radius: 12px;
            box-shadow: 0px 2px 6px rgba(0, 0, 0, .08);
            border-left: 6px solid var(--polban-orange);
            transition: 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0px 4px 10px rgba(0, 0, 0, .12);
        }

        .stat-number {
            font-size: 32px;
            font-weight: bold;
            color: var(--polban-blue);
        }

        .btn-polban {
            background-color: var(--polban-orange);
            color: white;
        }

        .btn-polban:hover {
            background-color: #c4661b;
            color: white;
        }

        /* FOOTER */
        .footer {
            margin-top: 40px;
            font-size: 14px;
            color: gray;
            text-align: center;
        }

    </style>
</head>

<body>

    <!-- SIDEBAR -->
    <div class="sidebar">
        <h4 class="text-center fw-bold">KINETRACK</h4>

        <a href="<?= base_url('admin'); ?>" class="active">📊 Dashboard</a>
        <a href="<?= base_url('admin/users'); ?>">👤 Manajemen User</a>
        <a href="<?= base_url('admin/jabatan'); ?>">🏅 Manajemen Jabatan</a>
        <a href="<?= base_url('admin/bidang'); ?>">📁 Manajemen Bidang</a>
        <a href="<?= base_url('admin/bidang-select'); ?>">📊 Analisis Bidang</a>


        <hr class="text-white mx-3">

        <a href="<?= base_url('/logout'); ?>" class="text-center mt-3">🚪 Logout</a>
    </div>

    <!-- CONTENT -->
    <div class="content">

        <!-- TOPBAR -->
        <div class="topbar">
            <h5 class="fw-bold">Dashboard Admin</h5>
            <div>Halo, <strong><?= session('nama'); ?></strong></div>
        </div>

        <!-- STATS -->
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <div class="stat-card">
                    <p class="mb-1">Total User</p>
                    <div class="stat-number"><?= $total_user ?></div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="stat-card">
                    <p class="mb-1">Total Jabatan</p>
                    <div class="stat-number"><?= $total_jabatan ?></div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="stat-card">
                    <p class="mb-1">Total Bidang</p>
                    <div class="stat-number"><?= $total_bidang ?></div>
                </div>
            </div>
        </div>


        <!-- WELCOME -->
        <div class="card shadow p-4 mt-4">
            <h5 class="fw-bold">Selamat datang di Admin Panel Kinetrack 👋</h5>
            <p class="mt-2 text-muted">Gunakan menu di sebelah kiri untuk mengelola sistem secara maksimal.</p>
        </div>

        <div class="footer mt-3">
            © <?= date('Y') ?> KINETRACK — Politeknik Negeri Bandung
        </div>

    </div>

</body>

</html>
