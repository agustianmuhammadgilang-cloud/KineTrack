<?= $this->extend('layout/staff_template') ?>
<?= $this->section('content') ?>

<h3>Input Pengukuran Indikator</h3>

<?php
use App\Models\PicModel;
$picModel = new PicModel();
$pic = $picModel->getPicByIndikator($indikator_id);
?>

<h4>PIC Terkait</h4>
<ul>
<?php foreach($pic as $p): ?>
    <li><?= esc($p['nama']) ?> (<?= esc($p['email']) ?>) - <?= esc($p['nama_bidang']) ?> / <?= esc($p['nama_jabatan']) ?></li>
<?php endforeach; ?>
</ul>

<form action="<?= base_url('staff/task/store') ?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="indikator_id" value="<?= $indikator_id ?>">

    <div>
        <label>Realisasi</label>
        <input type="text" name="realisasi" required>
    </div>

    <div>
        <label>Progress (%)</label>
        <input type="number" name="progress" min="0" max="100">
    </div>

    <div>
        <label>Kendala</label>
        <textarea name="kendala"></textarea>
    </div>

    <div>
        <label>Strategi</label>
        <textarea name="strategi"></textarea>
    </div>

    <div>
        <label>Data Dukung</label>
        <textarea name="data_dukung"></textarea>
    </div>

    <div>
        <label>File Dukung</label>
        <input type="file" name="file_dukung">
    </div>

    <button type="submit">Simpan</button>
</form>

<?= $this->endSection() ?>