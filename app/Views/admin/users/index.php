<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between mb-3">
    <h4 class="fw-bold">Manajemen User</h4>
    <a href="<?= base_url('admin/users/create'); ?>" class="btn btn-polban">+ Tambah User</a>
</div>

<?php if(session()->getFlashdata('success')): ?>
<div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<div class="card shadow p-3">
    <table class="table table-bordered table-hover">
        <thead style="background:var(--polban-blue); color:white;">
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Jabatan</th>
                <th>Bidang</th>
                <th>Role</th>
                <th width="160">Aksi</th>
            </tr>
        </thead>

        <tbody>
            <?php $no=1; foreach($users as $u): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= esc($u['nama']) ?></td>
                <td><?= esc($u['email']) ?></td>
                <td><?= esc($u['nama_jabatan']) ?></td>
                <td><?= esc($u['nama_bidang']) ?></td>
                <td><?= esc($u['role']) ?></td>
                <td>
                    <a href="<?= base_url('admin/users/edit/'.$u['id']) ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="<?= base_url('admin/users/delete/'.$u['id']) ?>"
                       onclick="return confirm('Hapus user ini?')"
                       class="btn btn-danger btn-sm">Hapus</a>
                </td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
