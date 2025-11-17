<?= $this->extend('layout/atasan_template') ?>
<?= $this->section('content') ?>

<h3 class="fw-bold mb-3">Detail Laporan</h3>

<div class="card shadow p-4">

    <p><b>Nama Staff:</b> <?= $lap['nama'] ?></p>
    <p><b>Judul:</b> <?= $lap['judul'] ?></p>
    <p><b>Deskripsi:</b><br><?= nl2br($lap['deskripsi']) ?></p>
    <p><b>Tanggal:</b> <?= $lap['tanggal'] ?></p>

    <p><b>Bukti:</b><br>
        <?php if($lap['file_bukti']): ?>
        <a href="<?= base_url('uploads/bukti/'.$lap['file_bukti']) ?>" target="_blank" class="btn btn-primary">
            Lihat Bukti
        </a>
        <?php else: ?>
            <i>Tidak ada bukti.</i>
        <?php endif ?>
    </p>

    <hr>

    <?php if($lap['status']=='pending'): ?>

    <div class="d-flex gap-2">
        <a href="<?= base_url('atasan/laporan/approve/'.$lap['id']) ?>"
           class="btn btn-success">Setujui</a>

        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalTolak">
            Tolak Laporan
        </button>
    </div>

    <?php else: ?>

    <p><b>Status:</b> <?= ucfirst($lap['status']) ?></p>
    <p><b>Catatan Atasan:</b><br><?= $lap['catatan_atasan'] ?? '-' ?></p>

    <?php endif; ?>

</div>


<!-- MODAL TOLAK -->
<div class="modal fade" id="modalTolak">
  <div class="modal-dialog">
    <div class="modal-content p-3">
      <h5 class="fw-bold">Alasan Penolakan</h5>
      <form action="<?= base_url('atasan/laporan/reject/'.$lap['id']) ?>" method="POST">
        <textarea name="catatan" class="form-control" rows="4" required></textarea>
        <button class="btn btn-danger mt-3">Kirim</button>
      </form>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
