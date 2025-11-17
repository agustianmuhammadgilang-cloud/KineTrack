<?= $this->extend('layout/staff_template') ?>
<?= $this->section('content') ?>

<h3 class="fw-bold mb-4">Detail Laporan Ditolak</h3>

<div class="card shadow p-4">

    <p><b>Judul:</b> <?= $lap['judul'] ?></p>
    <p><b>Deskripsi:</b><br><?= nl2br($lap['deskripsi']) ?></p>
    <p><b>Tanggal:</b> <?= $lap['tanggal'] ?></p>

    <p><b>Alasan Penolakan:</b></p>
    <div class="alert alert-danger">
        <?= $lap['catatan_atasan'] ?>
    </div>

    <p><b>Bukti Lama:</b></p>
    <?php if($lap['file_bukti']): ?>
        <a href="<?= base_url('uploads/bukti/'.$lap['file_bukti']) ?>" 
           target="_blank" class="btn btn-info">Lihat Bukti</a>
    <?php else: ?>
        <p><i>Tidak ada bukti.</i></p>
    <?php endif ?>

    <hr>

    <h4 class="fw-bold mt-3">Perbaiki & Kirim Ulang</h4>

    <form action="<?= base_url('staff/laporan/resubmit/'.$lap['id']) ?>" 
          method="POST" enctype="multipart/form-data">

        <input type="hidden" name="file_lama" value="<?= $lap['file_bukti'] ?>">

        <div class="mb-3">
            <label>Judul</label>
            <input type="text" name="judul" class="form-control" value="<?= $lap['judul'] ?>" required>
        </div>

        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="5" required><?= $lap['deskripsi'] ?></textarea>
        </div>

        <div class="mb-3">
            <label>Tanggal</label>
            <input type="date" name="tanggal" class="form-control" value="<?= $lap['tanggal'] ?>" required>
        </div>

        <div class="mb-3">
            <label>Upload Bukti Baru (opsional)</label>
            <input type="file" name="file_bukti" class="form-control">
        </div>

        <button class="btn btn-polban mt-3">Kirim Ulang</button>
        <a href="<?= base_url('staff/laporan') ?>" class="btn btn-secondary mt-3">Kembali</a>

    </form>

</div>

<?= $this->endSection() ?>
