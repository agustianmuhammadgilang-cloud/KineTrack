<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<h4 class="fw-bold mb-3">Tambah Jabatan</h4>

<div class="card shadow p-4">
    <form action="<?= base_url('admin/jabatan/store'); ?>" method="POST">

        <div class="mb-3">
            <label class="form-label">Nama Jabatan</label>
            <input type="text" class="form-control" name="nama_jabatan" required>
        </div>

        <button class="btn btn-polban">Simpan</button>
        <a href="<?= base_url('admin/jabatan'); ?>" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<?= $this->endSection() ?>
