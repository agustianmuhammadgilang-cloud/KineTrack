<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<h3 class="fw-bold mb-4">Sasaran Strategis</h3>

<a href="<?= base_url('admin/sasaran/create') ?>" class="btn btn-primary mb-3">+ Tambah Sasaran</a>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Kode</th>
            <th>Nama Sasaran</th>
            <th>Tahun</th>
            <th width="20%">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($sasaran as $s): ?>
        <tr>
            <td><?= $s['kode_sasaran'] ?></td>
            <td><?= $s['nama_sasaran'] ?></td>
            <td><?= $s['tahun'] ?></td>
            <td>
                <a href="<?= base_url('admin/sasaran/edit/'.$s['id']) ?>" class="btn btn-warning btn-sm">Edit</a>
                <a href="<?= base_url('admin/sasaran/delete/'.$s['id']) ?>" class="btn btn-danger btn-sm"
                   onclick="return confirm('Hapus sasaran?')">Hapus</a>
            </td>
        </tr>
        <?php endforeach ?>
    </tbody>
</table>

<?= $this->endSection() ?>
