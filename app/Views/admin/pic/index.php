<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<h3>Daftar PIC</h3>

<?php if(session()->getFlashdata('success')): ?>
<div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<table border="1" cellpadding="5">
    <thead>
        <tr>
            <th>ID</th>
            <th>Indikator</th>
            <th>PIC</th>
            <th>Bidang / Jabatan</th>
            <th>Tahun</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($pic_list as $p): ?>
            <tr>
                <td><?= $p['id'] ?></td>
                <td><?= $p['indikator_id'] ?></td>
                <td><?= $p['user_id'] ?></td>
                <td><?= $p['bidang_id'] ?> / <?= $p['jabatan_id'] ?></td>
                <td><?= $p['tahun_id'] ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<a href="<?= base_url('admin/pic/create') ?>">Tambah PIC Baru</a>

<?= $this->endSection() ?>