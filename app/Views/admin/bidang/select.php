<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<style>
    .bidang-card {
        background: white;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0px 3px 6px rgba(0,0,0,0.1);
        transition: .2s;
        cursor: pointer;
        border-left: 6px solid var(--polban-orange);
    }

    .bidang-card:hover {
        transform: translateY(-4px);
        box-shadow: 0px 6px 12px rgba(0,0,0,0.15);
    }

    .bidang-title {
        font-size: 18px;
        font-weight: 700;
        color: var(--polban-blue);
    }
</style>

<div class="mb-4">
    <h3 class="fw-bold">📊 Pilih Bidang untuk Analisis</h3>
    <p class="text-muted">Silakan pilih bidang berikut untuk melihat detail kinerja pegawai.</p>
</div>

<div class="row">
    <?php foreach ($bidang as $b): ?>
    <div class="col-md-4 mb-3">
        <a href="<?= base_url('admin/bidang/detail/'.$b['id']) ?>" style="text-decoration: none;">
            <div class="bidang-card">
                <div class="bidang-title"><?= $b['nama_bidang'] ?></div>
                <p class="text-muted mt-1">Klik untuk melihat analisis lengkap bidang ini</p>
            </div>
        </a>
    </div>
    <?php endforeach ?>

    <?php if (count($bidang) == 0): ?>
        <p class="text-muted">Belum ada bidang ditambahkan.</p>
    <?php endif ?>
</div>

<?= $this->endSection() ?>
