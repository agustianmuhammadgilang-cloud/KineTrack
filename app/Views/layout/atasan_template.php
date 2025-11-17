<!DOCTYPE html>
<html>
<head>
    <title>Atasan - Kinetrack</title>
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    <style>
        :root{
            --polban-blue:#1D2F83;
            --polban-orange:#F58025;
        }
        .btn-polban{ background:var(--polban-orange); color:white; }
        .btn-polban:hover{ background:#c7671e; color:white; }
        .sidebar{
            width:250px; height:100vh; background:var(--polban-blue);
            position:fixed; padding-top:20px;
        }
        .sidebar a{
            display:block; padding:12px 20px; color:white; text-decoration:none;
        }
        .sidebar a:hover{
            background:rgba(255,255,255,0.1);
        }
        .content{ margin-left:260px; padding:30px; }
    </style>
</head>

<body>

<div class="sidebar">
    <h4 class="text-center text-white mb-4">KINETRACK</h4>
    
<a href="<?= base_url('atasan') ?>">🏠 Dashboard</a>
<a href="<?= base_url('atasan/laporan') ?>">📄 Laporan Masuk</a>


    <hr class="text-white">
    <a href="<?= base_url('logout') ?>">Logout</a>
</div>

<div class="content">
    <?= $this->renderSection('content') ?>
</div>

</body>
</html>
