<?= $this->extend('layout/staff_template') ?>
<?= $this->section('content') ?>

<h3 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-100">Detail Laporan Ditolak</h3>

<div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 transition-colors">

    <p><span class="font-semibold">Judul:</span> <?= esc($lap['judul']) ?></p>
    <p class="mt-2"><span class="font-semibold">Deskripsi:</span><br><?= nl2br(esc($lap['deskripsi'])) ?></p>
    <p class="mt-2"><span class="font-semibold">Tanggal:</span> <?= esc($lap['tanggal']) ?></p>

    <p class="mt-3 font-semibold">Alasan Penolakan:</p>
    <div class="bg-red-100 text-red-800 p-3 rounded-lg mb-4 shadow">
        <?= esc($lap['catatan_atasan']) ?>
    </div>

    <p class="font-semibold">Bukti Lama:</p>
    <?php if($lap['file_bukti']): ?>
        <a href="<?= base_url('uploads/bukti/'.$lap['file_bukti']) ?>" 
           target="_blank" 
           class="inline-block bg-blue-500 hover:bg-blue-600 text-white text-sm px-3 py-1 rounded shadow transition-all mb-4">
           Lihat Bukti
        </a>
    <?php else: ?>
        <p class="text-gray-500 italic mb-4">Tidak ada bukti.</p>
    <?php endif ?>

    <hr class="my-6 border-gray-300 dark:border-gray-700">

    <h4 class="text-lg font-semibold mb-4">Perbaiki & Kirim Ulang</h4>

    <form action="<?= base_url('staff/laporan/resubmit/'.$lap['id']) ?>" 
          method="POST" enctype="multipart/form-data" class="space-y-4">

        <input type="hidden" name="file_lama" value="<?= esc($lap['file_bukti']) ?>">

        <div>
            <label class="block font-medium mb-1">Judul</label>
            <input type="text" name="judul" class="w-full border-gray-300 rounded px-3 py-2 shadow-sm focus:ring focus:ring-orange-300" 
                   value="<?= esc($lap['judul']) ?>" required>
        </div>

        <div>
            <label class="block font-medium mb-1">Deskripsi</label>
            <textarea name="deskripsi" rows="5" class="w-full border-gray-300 rounded px-3 py-2 shadow-sm focus:ring focus:ring-orange-300" required><?= esc($lap['deskripsi']) ?></textarea>
        </div>

        <div>
            <label class="block font-medium mb-1">Tanggal</label>
            <input type="date" name="tanggal" class="w-full border-gray-300 rounded px-3 py-2 shadow-sm focus:ring focus:ring-orange-300" 
                   value="<?= esc($lap['tanggal']) ?>" required>
        </div>

        <div>
            <label class="block font-medium mb-1">Upload Bukti Baru (opsional)</label>
            <input type="file" name="file_bukti" class="w-full border-gray-300 rounded px-3 py-2 shadow-sm focus:ring focus:ring-orange-300">
        </div>

        <div class="flex gap-2 mt-4">
            <button class="bg-orange-500 hover:bg-orange-600 text-white font-semibold px-4 py-2 rounded shadow transition-all">Kirim Ulang</button>
            <a href="<?= base_url('staff/laporan') ?>" 
               class="bg-gray-400 hover:bg-gray-500 text-white font-semibold px-4 py-2 rounded shadow transition-all">Kembali</a>
        </div>

    </form>

</div>

<?= $this->endSection() ?>
