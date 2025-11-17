<?= $this->extend('layout/staff_template') ?>
<?= $this->section('content') ?>

<h3 class="fw-bold mb-4">Buat Laporan Baru</h3>

<div class="card shadow p-4">

    <form action="<?= base_url('staff/laporan/store') ?>" method="POST" enctype="multipart/form-data">

        <div class="mb-3">
            <label>Judul</label>
            <input type="text" name="judul" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="5" required></textarea>
        </div>

        <div class="mb-3">
            <label>Tanggal</label>
            <input type="date" name="tanggal" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Bukti Kegiatan (opsional)</label>
            <input type="file" name="file_bukti" class="form-control">
        </div>

        <button class="btn btn-polban">Kirim</button>
        <a href="<?= base_url('staff/laporan') ?>" class="btn btn-secondary">Kembali</a>

    </form>

</div>

<?= $this->endSection() ?>
