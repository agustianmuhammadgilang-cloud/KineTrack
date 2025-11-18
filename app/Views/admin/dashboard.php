<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<h3 class="fw-bold mb-4">Dashboard Admin</h3>

<!-- STAT CARDS -->
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

<!-- WELCOME BOX -->
<div class="card shadow p-4 mt-4">
    <h5 class="fw-bold">Selamat datang di Admin Panel Kinetrack 👋</h5>
    <p class="mt-2 text-muted">Gunakan menu di sebelah kiri untuk mengelola sistem secara maksimal.</p>
</div>

<div class="footer mt-3">
    © <?= date('Y') ?> KINETRACK — Politeknik Negeri Bandung
</div>

<?= $this->endSection() ?>