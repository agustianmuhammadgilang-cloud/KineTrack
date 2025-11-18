<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<h3 class="fw-bold mb-3">Detail Bidang: <?= esc($bidang['nama_bidang']) ?></h3>

<div class="row">
<?php foreach ($pegawai as $p): ?>

    <div class="col-md-4 mb-4">
        <div class="card shadow-sm p-3">

            <h5 class="fw-bold"><?= $p['nama'] ?></h5>
            <small class="text-muted"><?= $p['nama_jabatan'] ?></small>

            <!-- Ranking -->
            <div class="mt-2">
                <?php if ($p['ranking'] == 1): ?>
                    <span class="badge bg-warning text-dark">🥇 Ranking 1</span>
                <?php elseif ($p['ranking'] == 2): ?>
                    <span class="badge bg-secondary">🥈 Ranking 2</span>
                <?php elseif ($p['ranking'] == 3): ?>
                    <span class="badge bg-danger">🥉 Ranking 3</span>
                <?php else: ?>
                    <span class="badge bg-primary">Ranking <?= $p['ranking'] ?></span>
                <?php endif; ?>
            </div>

            <!-- Laporan -->
            <p class="mt-3 mb-1">Laporan Bulan Ini: <b><?= $p['laporan_bulan_ini'] ?></b></p>

            <!-- Progress -->
            <div class="progress" style="height: 8px;">
                <div class="progress-bar bg-polban" 
                     role="progressbar" 
                     style="width: <?= min($p['progress'], 100) ?>%;">
                </div>
            </div>

            <small class="text-muted">
                Progress: <?= number_format($p['progress'], 1) ?>%
            </small>

            <!-- Status -->
            <p class="mt-2">
                Status: 
                <?php if ($p['status'] == 'Naik'): ?>
                    <span class="text-success fw-bold">Naik ↑</span>
                <?php elseif ($p['status'] == 'Turun'): ?>
                    <span class="text-danger fw-bold">Turun ↓</span>
                <?php else: ?>
                    <span class="text-secondary fw-bold">Stabil →</span>
                <?php endif; ?>
            </p>

            <!-- Detail -->
            <a href="#" class="btn btn-sm btn-polban w-100 mt-2">Lihat Detail</a>

        </div>
    </div>

<?php endforeach; ?>
</div>

<?= $this->endSection() ?>
