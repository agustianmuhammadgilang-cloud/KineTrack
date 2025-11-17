<?= $this->extend('layout/staff_template') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between mb-4">
    <h3 class="fw-bold">Laporan Saya</h3>
    <a href="<?= base_url('staff/laporan/create'); ?>" class="btn btn-polban">+ Buat Laporan</a>
</div>

<?php if(session()->getFlashdata('success')): ?>
<div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<div class="card shadow p-3">
    <table class="table table-bordered table-hover">
        <thead style="background: var(--polban-blue); color:white;">
            <tr>
                <th>#</th>
                <th>Judul</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Bukti</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            <?php $no=1; foreach($laporan as $l): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= esc($l['judul']) ?></td>
                <td><?= $l['tanggal'] ?></td>

                <td>
                    <?php if($l['status']=='pending'): ?>
                        <span class="badge bg-secondary">Pending</span>
                    <?php elseif($l['status']=='approved'): ?>
                        <span class="badge bg-success">Diterima</span>
                    <?php else: ?>
                        <span class="badge bg-danger">Ditolak</span>
                    <?php endif; ?>
                </td>

                <td>
                    <?php if($l['file_bukti']): ?>
                        <a href="<?= base_url('uploads/bukti/'.$l['file_bukti']) ?>" 
                           target="_blank" class="btn btn-sm btn-info">View</a>
                    <?php else: ?>
                        -
                    <?php endif ?>
                </td>

                <td>
                    <?php if($l['status']=='rejected'): ?>
                        <a href="<?= base_url('staff/laporan/rejected/'.$l['id']) ?>" 
                           class="btn btn-sm btn-warning">
                           Lihat
                        </a>
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
