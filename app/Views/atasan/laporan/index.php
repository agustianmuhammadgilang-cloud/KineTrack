<?= $this->extend('layout/atasan_template') ?>
<?= $this->section('content') ?>

<h3 class="fw-bold mb-4">Laporan Masuk</h3>

<?php if(session()->getFlashdata('success')): ?>
<div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<div class="card shadow p-3">

<table class="table table-bordered table-hover">
    <thead style="background:var(--polban-blue); color:white;">
        <tr>
            <th>#</th>
            <th>Nama Staff</th>
            <th>Judul</th>
            <th>Tanggal</th>
            <th>Status</th>
            <th width="120">Aksi</th>
        </tr>
    </thead>

    <tbody>
    <?php $no=1; foreach($laporan as $l): ?>
        <tr>
            <td><?= $no++ ?></td>
            <td>
                <?= model('UserModel')->find($l['user_id'])['nama'] ?>
            </td>
            <td><?= $l['judul'] ?></td>
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
                <a href="<?= base_url('atasan/laporan/detail/'.$l['id']) ?>"
                   class="btn btn-sm btn-info">Detail</a>
            </td>
        </tr>
    <?php endforeach ?>
    </tbody>
</table>

</div>

<?= $this->endSection() ?>
