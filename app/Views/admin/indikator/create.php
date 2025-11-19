<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<h3 class="fw-bold mb-4">Tambah Indikator Kinerja</h3>

<form action="<?= base_url('admin/indikator/store') ?>" method="post">

    <div class="mb-3">
        <label class="form-label">Sasaran Strategis</label>
        <select name="sasaran_id" class="form-control" required>
            <?php foreach($sasaran as $s): ?>
            <option value="<?= $s['id'] ?>">
                <?= $s['kode_sasaran'] ?> — <?= $s['nama_sasaran'] ?> (<?= $s['tahun'] ?>)
            </option>
            <?php endforeach ?>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Kode Indikator</label>
        <input type="text" name="kode_indikator" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Nama Indikator</label>
        <textarea name="nama_indikator" class="form-control" required></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">Satuan</label>
        <input type="text" name="satuan" class="form-control" placeholder="% / Unit / Dokumen / dll">
    </div>

    <div class="mb-3">
        <label class="form-label">Target PK</label>
        <input type="number" name="target_pk" class="form-control">
    </div>

    <hr>

    <div class="row mb-3">
        <div class="col">
            <label class="form-label">Target TW1</label>
            <input type="number" name="target_tw1" class="form-control">
        </div>
        <div class="col">
            <label class="form-label">Target TW2</label>
            <input type="number" name="target_tw2" class="form-control">
        </div>
        <div class="col">
            <label class="form-label">Target TW3</label>
            <input type="number" name="target_tw3" class="form-control">
        </div>
        <div class="col">
            <label class="form-label">Target TW4</label>
            <input type="number" name="target_tw4" class="form-control">
        </div>
    </div>

    <button class="btn btn-primary">Simpan</button>
    <a href="<?= base_url('admin/indikator') ?>" class="btn btn-secondary">Kembali</a>

</form>

<?= $this->endSection() ?>
