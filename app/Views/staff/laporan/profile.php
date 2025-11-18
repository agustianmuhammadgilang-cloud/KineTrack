<?= $this->extend('layout/staff_template') ?>
<?= $this->section('content') ?>

<h3 class="fw-bold mb-4">Pengaturan Profil</h3>

<?php if(session()->getFlashdata('success')): ?>
<div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<div class="card shadow p-4">

    <form action="<?= base_url('staff/profile/update') ?>" method="POST">

        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control" 
                   value="<?= $user['nama'] ?>" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control"
                   value="<?= $user['email'] ?>" required>
        </div>

        <div class="mb-3">
            <label>Password Baru (opsional)</label>
            <input type="password" name="password" class="form-control">
            <small class="text-muted">Kosongkan jika tidak ingin mengganti.</small>
        </div>

        <button class="btn btn-polban">Simpan Perubahan</button>
        <a href="<?= base_url('staff') ?>" class="btn btn-secondary">Kembali</a>

    </form>

</div>

<?= $this->endSection() ?>
