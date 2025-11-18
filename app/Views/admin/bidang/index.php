<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between mb-3">
    <h4 class="fw-bold">Manajemen Bidang</h4>
    <a href="<?= base_url('admin/bidang/create'); ?>" class="btn btn-polban">+ Tambah Bidang</a>
</div>

<?php if(session()->getFlashdata('success')): ?>
<div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<div class="card shadow p-3">
    <table class="table table-bordered table-hover">
        <thead style="background: var(--polban-blue); color:white;">
            <tr>
                <th width="70">No</th>
                <th>Nama Bidang</th>
                <th width="180">Aksi</th>
            </tr>
        </thead>

        <tbody>
            <?php $no=1; foreach($bidang as $b): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= esc($b['nama_bidang']) ?></td>
                <td>
                    <a href="<?= base_url('admin/bidang/edit/'.$b['id']) ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="<?= base_url('admin/bidang/delete/'.$b['id']) ?>" class="btn btn-danger btn-sm"
                       onclick="return confirm('Hapus bidang ini?')">Hapus</a>
                </td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
