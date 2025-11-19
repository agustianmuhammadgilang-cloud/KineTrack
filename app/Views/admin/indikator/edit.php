<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<h3 class="fw-bold mb-4">Edit Indikator Kinerja</h3>

<form action="<?= base_url('admin/indikator/update/'.$indikator['id']) ?>" method="post">

    <div class="mb-3">
        <label class="form-label">Sasaran Strategis</label>
        <select name="sasaran_id" class="form-control">
            <?php foreach($sasaran as $s): ?>
            <option value="<?= $s['id'] ?>"
                <?= $indikator['sasaran_id']==$s['id']?'selected':'' ?>>
                <?= $s['kode_sasaran'] ?> — <?= $s['nama_sasaran'] ?> (<?= $s['tahun'] ?>)
            </option>
            <?php endforeach ?>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Kode Indikator</label>
        <input type="text" name="kode_indikator" value="<?= $indikator['kode_indikator'] ?>" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label">Nama Indikator</label>
        <textarea name="nama_indikator" class="form-control"><?= $indikator['nama_indikator'] ?></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">Satuan</label>
        <input type="text" name="satuan" value="<?= $indikator['satuan'] ?>" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label">Target PK</label>
        <input type="number" name="target_pk" value="<?= $indikator['target_pk'] ?>" class="form-control">
    </div>

    <hr>

    <div class="row mb-3">
        <div class="col">
            <label class="form-label">TW1</label>
            <input type="number" name="target_tw1" value="<?= $indikator['target_tw1'] ?>" class="form-control">
        </div>
        <div class="col">
            <label class="form-label">TW2</label>
            <input type="number" name="target_tw2" value="<?= $indikator['target_tw2'] ?>" class="form-control">
        </div>
        <div class="col">
            <label class="form-label">TW3</label>
            <input type="number" name="target_tw3" value="<?= $indikator['target_tw3'] ?>" class="form-control">
        </div>
        <div class="col">
            <label class="form-label">TW4</label>
            <input type="number" name="target_tw4" value="<?= $indikator['target_tw4'] ?>" class="form-control">
        </div>
    </div>

    <button class="btn btn-primary">Update</button>
    <a href="<?= base_url('admin/indikator') ?>" class="btn btn-secondary">Kembali</a>

</form>

<?= $this->endSection() ?>
