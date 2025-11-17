<?= $this->extend('layout/atasan_template') ?>
<?= $this->section('content') ?>

<h3 class="fw-bold mb-4">Dashboard Atasan</h3>

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

<div class="mt-4">
    <a href="<?= base_url('atasan/laporan') ?>" class="btn btn-polban">Lihat Semua Laporan</a>
</div>

<?= $this->endSection() ?>
