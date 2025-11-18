<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between mb-3">
    <h4 class="fw-bold">Manajemen Jabatan</h4>
    <a href="<?= base_url('admin/jabatan/create'); ?>" class="btn btn-polban">+ Tambah Jabatan</a>
</div>

<?php if(session()->getFlashdata('success')): ?>
<div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<div class="card shadow p-3">
    <table class="table table-bordered table-hover">
        <thead style="background: var(--polban-blue); color:white;">
            <tr>
                <th width="70">No</th>
                <th>Nama Jabatan</th>
                <th width="180">Aksi</th>
            </tr>
        </thead>

        <tbody>
            <?php $no=1; foreach($jabatan as $j): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= esc($j['nama_jabatan']) ?></td>
                <td>
                    <a href="<?= base_url('admin/jabatan/edit/'.$j['id']) ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="<?= base_url('admin/jabatan/delete/'.$j['id']) ?>" class="btn btn-danger btn-sm"
                       onclick="return confirm('Hapus jabatan ini?')">Hapus</a>
                </td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
