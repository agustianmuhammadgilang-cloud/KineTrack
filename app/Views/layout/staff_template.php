<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff - Kinetrack</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    <style>
        :root{
            --polban-blue:#1D2F83;
            --polban-orange:#F58025;
        }
        body { background: #f5f7fa; }
        .btn-polban{ background:var(--polban-orange); color:white; }
        .btn-polban:hover{ background:#c7671e; color:white; }
        .sidebar{
            width:250px; height:100vh; position:fixed;
            background:var(--polban-blue); padding-top:20px;
        }
        .sidebar a{
            color:white; padding:12px 20px; display:block; text-decoration:none;
        }
        .sidebar a:hover{
            background:rgba(255,255,255,0.1);
        }
        .content{ margin-left:260px; padding:30px; }
    </style>
</head>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php if (session()->getFlashdata('alert')) : ?>
<script>
    Swal.fire({
        icon: '<?= session()->getFlashdata('alert')['type'] ?>',
        title: '<?= session()->getFlashdata('alert')['title'] ?>',
        text: '<?= session()->getFlashdata('alert')['message'] ?>',
        confirmButtonColor: '#0d6efd'
    });
</script>
<?php endif; ?>


<body>

<div class="sidebar">
    <h4 class="text-center text-white mb-4">KINETRACK</h4>

    <a href="<?= base_url('staff') ?>">🏠 Dashboard</a>
    <a href="<?= base_url('staff/laporan') ?>">📝 Laporan</a>

    <hr class="text-white">
    <a href="<?= base_url('logout') ?>">Logout</a>
</div>

<div class="content">
    <?= $this->renderSection('content') ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php if (session()->getFlashdata('alert')): 
    $a = session()->getFlashdata('alert'); ?>
<script>
  Swal.fire({
    toast: true, position: 'top-end', showConfirmButton:false, timer:4000,
    icon: '<?= esc($a['type']) ?>', title: '<?= esc($a['title']) ?>', text: '<?= esc($a['message']) ?>'
  });
</script>
<?php endif; ?>

</body>
</html>
