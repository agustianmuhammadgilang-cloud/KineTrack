<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<h3 class="fw-bold mb-3">Detail Bidang: <?= esc($bidang['nama_bidang']) ?></h3>

<?php if(isset($atasan) && $atasan): ?>
<div class="mb-3">
    <strong>Atasan:</strong> <?= esc($atasan['nama']) ?> (<?= esc($atasan['email'] ?? '') ?>)
    <a href="<?= base_url('admin/bidang/detail/export/'.$bidang['id']) ?>" class="btn btn-sm btn-outline-secondary ms-3">Export Bidang (PDF)</a>
</div>
<?php endif; ?>

<div class="row">
    <?php if(empty($pegawai)): ?>
        <div class="col-12"><div class="alert alert-info">Tidak ada pegawai di bidang ini.</div></div>
    <?php endif; ?>

    <?php foreach($pegawai as $p): ?>
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm p-3">
                <h5 class="fw-bold"><?= esc($p['nama']) ?></h5>
                <small class="text-muted"><?= esc($p['jabatan']) ?></small>

                <div class="mt-2">
                    <?php if($p['ranking'] == 1): ?>
                        <span class="badge bg-warning text-dark">🥇 Ranking 1</span>
                    <?php elseif($p['ranking'] == 2): ?>
                        <span class="badge bg-secondary">🥈 Ranking 2</span>
                    <?php elseif($p['ranking'] == 3): ?>
                        <span class="badge bg-danger">🥉 Ranking 3</span>
                    <?php else: ?>
                        <span class="badge bg-primary">Ranking <?= $p['ranking'] ?></span>
                    <?php endif; ?>
                </div>

                <p class="mt-3 mb-1">Laporan Bulan Ini: <b><?= $p['total_laporan'] ?></b></p>

                <div class="progress" style="height: 8px;">
                    <div class="progress-bar" role="progressbar" style="width: <?= min($p['progress'],100) ?>%"><?= $p['progress'] ?>%</div>
                </div>

                <small class="text-muted">Status: 
                    <?php if($p['status']=='Naik'): ?>
                        <span class="text-success fw-bold">Naik ↑</span>
                    <?php elseif($p['status']=='Turun'): ?>
                        <span class="text-danger fw-bold">Turun ↓</span>
                    <?php else: ?>
                        <span class="text-secondary fw-bold">Stabil</span>
                    <?php endif; ?>
                </small>

                <div class="mt-3">
                    <a href="<?= base_url('admin/bidang/pegawai/'.$p['id']) ?>" class="btn btn-polban btn-sm w-100">Lihat Detail</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?= $this->endSection() ?>
