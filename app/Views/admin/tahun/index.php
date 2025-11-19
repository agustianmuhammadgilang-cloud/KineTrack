<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<h3 class="fw-bold mb-4">Tahun Anggaran</h3>

<a href="<?= base_url('admin/tahun/create') ?>" class="btn btn-primary mb-3">+ Tambah Tahun</a>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th width="10%">ID</th>
            <th>Tahun</th>
            <th>Status</th>
            <th width="20%">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($tahun as $t): ?>
        <tr>
            <td><?= $t['id'] ?></td>
            <td><?= $t['tahun'] ?></td>
            <td>
                <?php if($t['status'] == 'aktif'): ?>
                    <span class="badge bg-success">Aktif</span>
                <?php else: ?>
                    <span class="badge bg-secondary">Tidak Aktif</span>
                <?php endif; ?>
            </td>
            <td>
                <a href="<?= base_url('admin/tahun/edit/'.$t['id']) ?>" class="btn btn-warning btn-sm">Edit</a>
                <a href="<?= base_url('admin/tahun/delete/'.$t['id']) ?>" class="btn btn-danger btn-sm"
                   onclick="return confirm('Hapus tahun?')">Hapus</a>
            </td>
        </tr>
        <?php endforeach ?>
    </tbody>
</table>

<?= $this->endSection() ?>
