<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<h3 class="fw-bold mb-4">Indikator Kinerja</h3>

<a href="<?= base_url('admin/indikator/create') ?>" class="btn btn-primary mb-3">+ Tambah Indikator</a>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Kode</th>
            <th>Indikator</th>
            <th>Satuan</th>
            <th>Sasaran</th>
            <th>Tahun</th>
            <th width="18%">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($indikator as $i): ?>
        <tr>
            <td><?= $i['kode_indikator'] ?></td>
            <td><?= $i['nama_indikator'] ?></td>
            <td><?= $i['satuan'] ?></td>
            <td><?= $i['nama_sasaran'] ?></td>
            <td><?= $i['tahun'] ?></td>

            <td>
                <a href="<?= base_url('admin/indikator/edit/'.$i['id']) ?>" class="btn btn-warning btn-sm">Edit</a>
                <a href="<?= base_url('admin/indikator/delete/'.$i['id']) ?>" class="btn btn-danger btn-sm"
                   onclick="return confirm('Yakin hapus indikator?')">Hapus</a>
            </td>
        </tr>
        <?php endforeach ?>
    </tbody>
</table>

<?= $this->endSection() ?>
