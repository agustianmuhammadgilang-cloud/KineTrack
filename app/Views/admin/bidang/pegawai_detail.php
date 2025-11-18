<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<h3 class="fw-bold mb-3"><?= esc($pegawai['nama']) ?> — Detail Kinerja</h3>

<div class="row">
    <div class="col-md-4">
        <div class="card p-3 shadow-sm mb-4">
            <h5>Profil</h5>
            <p><b>Nama:</b> <?= esc($pegawai['nama']) ?></p>
            <p><b>Jabatan:</b> <?= esc($pegawai['nama_jabatan']) ?></p>
            <p><b>Bidang:</b> <?= esc($pegawai['nama_bidang']) ?></p>

            <hr>
            <p><b>Diterima:</b> <?= $approved ?></p>
            <p><b>Ditolak:</b> <?= $rejected ?></p>
            <p><b>Progress:</b> <?= $progress ?>%</p>
            <p><b>Total Jam Kerja:</b> 
                <?php if($hours > 0): ?>
                    <?= floor($hours/60) ?> jam <?= $hours % 60 ?> menit
                <?php else: ?>
                    -
                <?php endif; ?>
            </p>

            <a href="<?= base_url('admin/bidang/detail/export/'.$pegawai['id']) ?>" class="btn btn-polban mt-2">Export PDF Pegawai</a>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card p-3 shadow-sm">
            <h5>Riwayat Laporan Bulan Ini</h5>

            <table class="table table-bordered mt-3">
                <thead style="background: var(--polban-blue); color:white;">
                    <tr>
                        <th>Judul</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Catatan Atasan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($laporan)): ?>
                        <tr><td colspan="4" class="text-center">Belum ada laporan.</td></tr>
                    <?php endif; ?>
                    <?php foreach($laporan as $l): ?>
                    <tr>
                        <td><?= esc($l['judul']) ?></td>
                        <td><?= esc($l['tanggal']) ?></td>
                        <td>
                            <?php if($l['status']=='approved'): ?>
                                <span class="badge bg-success">Diterima</span>
                            <?php elseif($l['status']=='pending'): ?>
                                <span class="badge bg-secondary">Pending</span>
                            <?php else: ?>
                                <span class="badge bg-danger">Ditolak</span>
                            <?php endif; ?>
                        </td>
                        <td><?= esc($l['catatan_atasan'] ?: '-') ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        </div>
    </div>
</div>

<?= $this->endSection() ?>
