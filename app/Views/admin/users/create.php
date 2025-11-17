<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<h4 class="fw-bold mb-3">Tambah User</h4>

<div class="card shadow p-4">

    <form action="<?= base_url('admin/users/store'); ?>" method="POST">

        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Jabatan</label>
            <select name="jabatan_id" class="form-control" required>
                <option value="">- Pilih Jabatan -</option>
                <?php foreach($jabatan as $j): ?>
                <option value="<?= $j['id'] ?>"><?= $j['nama_jabatan'] ?></option>
                <?php endforeach ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Bidang</label>
            <select name="bidang_id" class="form-control" required>
                <option value="">- Pilih Bidang -</option>
                <?php foreach($bidang as $b): ?>
                <option value="<?= $b['id'] ?>"><?= $b['nama_bidang'] ?></option>
                <?php endforeach ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Role</label>
            <select name="role" class="form-control" required>
                <option value="staff">Staff</option>
                <option value="atasan">Atasan</option>
                <option value="admin">Admin</option>
            </select>
        </div>

        <p class="text-muted">Password default: <b>123456</b></p>

        <button class="btn btn-polban">Simpan</button>
        <a href="<?= base_url('admin/users'); ?>" class="btn btn-secondary">Kembali</a>

    </form>

</div>

<?= $this->endSection() ?>
