<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<h3 class="fw-bold mb-4">Edit Tahun Anggaran</h3>

<form action="<?= base_url('admin/tahun/update/'.$tahun['id']) ?>" method="post">

    <div class="mb-3">
        <label class="form-label">Tahun</label>
        <input type="number" class="form-control" name="tahun" 
               value="<?= $tahun['tahun'] ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Status</label>
        <select name="status" class="form-control">
            <option value="aktif" <?= $tahun['status']=='aktif'?'selected':'' ?>>Aktif</option>
            <option value="tidak aktif" <?= $tahun['status']=='tidak aktif'?'selected':'' ?>>Tidak Aktif</option>
        </select>
    </div>

    <button class="btn btn-primary">Update</button>
    <a href="<?= base_url('admin/tahun') ?>" class="btn btn-secondary">Kembali</a>

</form>

<?= $this->endSection() ?>
