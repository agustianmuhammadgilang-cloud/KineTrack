<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Kinetrack</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    <style>
        :root{
            --polban-blue:#1D2F83;
            --polban-orange:#F58025;
        }
        body { background: #f5f7fa; }
        .btn-polban{ background: var(--polban-orange); color:white; }
        .btn-polban:hover{ background:#c7671e; color:white; }
        .sidebar{
            width:250px; height:100vh; position:fixed; background:var(--polban-blue); padding-top:20px;
        }
        .sidebar a{
            color:white; text-decoration:none; padding:12px 20px; display:block;
        }
        .sidebar a:hover{ background:rgba(255,255,255,0.1); }
        .content{
            margin-left:260px; padding:30px;
        }
    </style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h4 class="text-center text-white mb-4">KINETRACK</h4>

    <a href="<?= base_url('admin') ?>">📊 Dashboard</a>
    <a href="<?= base_url('admin/users') ?>">👤 User</a>
    <a href="<?= base_url('admin/jabatan') ?>">🏅 Jabatan</a>
    <a href="<?= base_url('admin/bidang') ?>">📁 Bidang</a>

    <hr class="text-white">
    <a href="<?= base_url('logout') ?>">Logout</a>
</div>

<!-- CONTENT -->
<div class="content">
    <?= $this->renderSection('content') ?>
</div>

</body>
</html>
