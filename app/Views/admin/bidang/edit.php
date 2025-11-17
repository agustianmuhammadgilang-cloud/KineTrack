<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<h4 class="fw-bold mb-3">Edit Bidang</h4>

<div class="card shadow p-4">
    <form action="<?= base_url('admin/bidang/update/'.$bidang['id']); ?>" method="POST">

        <div class="mb-3">
            <label class="form-label">Nama Bidang</label>
            <input type="text" class="form-control" name="nama_bidang"
                   value="<?= esc($bidang['nama_bidang']) ?>" required>
        </div>

        <button class="btn btn-polban">Update</button>
        <a href="<?= base_url('admin/bidang'); ?>" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<?= $this->endSection() ?>
