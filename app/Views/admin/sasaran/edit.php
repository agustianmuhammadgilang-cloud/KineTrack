<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<h3 class="fw-bold mb-4">Edit Sasaran Strategis</h3>

<form action="<?= base_url('admin/sasaran/update/'.$sasaran['id']) ?>" method="post">

    <div class="mb-3">
        <label class="form-label">Tahun Anggaran</label>
        <select name="tahun_id" class="form-control">
            <?php foreach($tahun as $t): ?>
                <option value="<?= $t['id'] ?>" 
                    <?= $sasaran['tahun_id']==$t['id']?'selected':'' ?>>
                    <?= $t['tahun'] ?>
                </option>
            <?php endforeach ?>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Kode Sasaran</label>
        <input type="text" name="kode_sasaran" value="<?= $sasaran['kode_sasaran'] ?>" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Nama Sasaran</label>
        <textarea name="nama_sasaran" class="form-control" required><?= $sasaran['nama_sasaran'] ?></textarea>
    </div>

    <button class="btn btn-primary">Update</button>
    <a href="<?= base_url('admin/sasaran') ?>" class="btn btn-secondary">Kembali</a>

</form>

<?= $this->endSection() ?>
