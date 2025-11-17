<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<h4 class="fw-bold mb-3">Edit User</h4>

<div class="card shadow p-4">

    <form action="<?= base_url('admin/users/update/'.$user['id']); ?>" method="POST">

        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control"
                   value="<?= esc($user['nama']) ?>" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control"
                   value="<?= esc($user['email']) ?>" required>
        </div>

        <div class="mb-3">
            <label>Jabatan</label>
            <select name="jabatan_id" class="form-control" required>
                <?php foreach($jabatan as $j): ?>
                <option value="<?= $j['id'] ?>"
                    <?= $j['id']==$user['jabatan_id']?'selected':'' ?>>
                    <?= $j['nama_jabatan'] ?>
                </option>
                <?php endforeach ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Bidang</label>
            <select name="bidang_id" class="form-control" required>
                <?php foreach($bidang as $b): ?>
                <option value="<?= $b['id'] ?>"
                    <?= $b['id']==$user['bidang_id']?'selected':'' ?>>
                    <?= $b['nama_bidang'] ?>
                </option>
                <?php endforeach ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Role</label>
            <select name="role" class="form-control" required>
                <option value="staff"  <?= $user['role']=='staff'?'selected':'' ?>>Staff</option>
                <option value="atasan" <?= $user['role']=='atasan'?'selected':'' ?>>Atasan</option>
                <option value="admin"  <?= $user['role']=='admin'?'selected':'' ?>>Admin</option>
            </select>
        </div>

        <button class="btn btn-polban">Update</button>
        <a href="<?= base_url('admin/users'); ?>" class="btn btn-secondary">Kembali</a>

    </form>

</div>

<?= $this->endSection() ?>
