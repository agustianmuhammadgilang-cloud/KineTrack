<?= $this->extend('layout/atasan_template') ?>
<?= $this->section('content') ?>

<h3 class="fw-bold mb-4">Dashboard Atasan</h3>

<!-- Informasi Profil -->
<div class="card shadow p-4 mb-4">
    <h5 class="fw-bold mb-3">Informasi Atasan</h5>
    <p><b>Nama:</b> <?= $atasan['nama'] ?></p>
    <p><b>Jabatan:</b> <?= $atasan['nama_jabatan'] ?></p>
    <p><b>Bidang:</b> <?= $atasan['nama_bidang'] ?></p>

    <a href="<?= base_url('atasan/profile') ?>" class="btn btn-polban mt-2">Pengaturan Profil</a>
</div>

<!-- Statistik Laporan -->
<div class="row">

    <div class="col-md-4 mb-3">
        <div class="card shadow p-4 text-center">
            <h4 class="fw-bold text-secondary">Pending</h4>
            <h2 class="fw-bold"><?= $pending ?></h2>
        </div>
    </div>

    <div class="col-md-4 mb-3">
        <div class="card shadow p-4 text-center">
            <h4 class="fw-bold text-success">Diterima</h4>
            <h2 class="fw-bold"><?= $approved ?></h2>
        </div>
    </div>

    <div class="col-md-4 mb-3">
        <div class="card shadow p-4 text-center">
            <h4 class="fw-bold text-danger">Ditolak</h4>
            <h2 class="fw-bold"><?= $rejected ?></h2>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
