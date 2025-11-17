<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<h4 class="fw-bold mb-3">Edit Jabatan</h4>

<div class="card shadow p-4">
    <form action="<?= base_url('admin/jabatan/update/'.$jabatan['id']); ?>" method="POST">

        <div class="mb-3">
            <label class="form-label">Nama Jabatan</label>
            <input type="text" class="form-control" name="nama_jabatan"
                   value="<?= esc($jabatan['nama_jabatan']) ?>" required>
        </div>

        <button class="btn btn-polban">Update</button>
        <a href="<?= base_url('admin/jabatan'); ?>" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<?= $this->endSection() ?>
