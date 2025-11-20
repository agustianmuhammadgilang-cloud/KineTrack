<?= $this->extend('layout/staff_template') ?>
<?= $this->section('content') ?>

<h3 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-100">
    Detail Laporan Ditolak
</h3>

<div class="bg-white dark:bg-gray-800 shadow rounded-xl p-6 transition-all space-y-5">

    <!-- Informasi Laporan -->
    <div>
        <p><span class="font-semibold">Judul:</span> <?= esc($lap['judul']) ?></p>

        <p class="mt-2">
            <span class="font-semibold">Deskripsi:</span><br>
            <?= nl2br(esc($lap['deskripsi'])) ?>
        </p>

        <p class="mt-2">
            <span class="font-semibold">Tanggal:</span> <?= esc($lap['tanggal']) ?>
        </p>
    </div>

    <!-- Alasan Penolakan -->
    <div>
        <p class="font-semibold mb-1">Alasan Penolakan:</p>
        <div class="bg-red-100 text-red-800 p-3 rounded-lg shadow-sm">
            <?= esc($lap['catatan_atasan']) ?>
        </div>
    </div>

    <!-- Bukti Lama -->
    <div>
        <p class="font-semibold mb-1">Bukti Lama:</p>

        <?php if($lap['file_bukti']): ?>
            <a href="<?= base_url('uploads/bukti/'.$lap['file_bukti']) ?>"
               target="_blank"
               class="inline-block bg-blue-500 hover:bg-blue-600 text-white text-sm px-4 py-2 rounded shadow transition-all">
               Lihat Bukti
            </a>
        <?php else: ?>
            <p class="text-gray-500 italic">Tidak ada bukti.</p>
        <?php endif ?>
    </div>

    <hr class="border-gray-300 dark:border-gray-700">

    <!-- Form Kirim Ulang -->
    <h4 class="text-lg font-semibold">Perbaiki & Kirim Ulang</h4>

    <form action="<?= base_url('staff/laporan/resubmit/'.$lap['id']) ?>"
          method="POST" enctype="multipart/form-data"
          class="space-y-4">

        <input type="hidden" name="file_lama" value="<?= esc($lap['file_bukti']) ?>">

        <!-- Judul -->
        <div>
            <label class="block font-medium mb-1">Judul</label>
            <input type="text" name="judul" required
                   value="<?= esc($lap['judul']) ?>"
                   class="w-full border border-gray-300 dark:border-gray-600 rounded-lg
                          px-3 py-2 bg-white dark:bg-gray-700 shadow-sm
                          focus:ring-2 focus:ring-orange-400 dark:focus:ring-orange-500
                          transition outline-none">
        </div>

        <!-- Deskripsi -->
        <div>
            <label class="block font-medium mb-1">Deskripsi</label>
            <textarea name="deskripsi" rows="5" required
                      class="w-full border border-gray-300 dark:border-gray-600 rounded-lg
                             px-3 py-2 bg-white dark:bg-gray-700 shadow-sm
                             focus:ring-2 focus:ring-orange-400 dark:focus:ring-orange-500
                             transition outline-none"><?= esc($lap['deskripsi']) ?></textarea>
        </div>

        <!-- Tanggal -->
        <div>
            <label class="block font-medium mb-1">Tanggal</label>
            <input type="date" name="tanggal" required
                   value="<?= esc($lap['tanggal']) ?>"
                   class="w-full border border-gray-300 dark:border-gray-600 rounded-lg
                          px-3 py-2 bg-white dark:bg-gray-700 shadow-sm
                          focus:ring-2 focus:ring-orange-400 dark:focus:ring-orange-500
                          transition outline-none">
        </div>

        <!-- Bukti Baru -->
        <div>
            <label class="block font-medium mb-1">Upload Bukti Baru (opsional)</label>
            <input type="file" name="file_bukti"
                   class="w-full border border-gray-300 dark:border-gray-600 rounded-lg
                          px-3 py-2 bg-white dark:bg-gray-700 shadow-sm
                          focus:ring-2 focus:ring-orange-400 dark:focus:ring-orange-500
                          transition outline-none">
        </div>

        <!-- Buttons -->
        <div class="flex flex-col sm:flex-row gap-3 pt-3">
            <button
                class="bg-orange-500 hover:bg-orange-600 text-white font-semibold
                       px-5 py-2.5 rounded-lg shadow transition-all text-center">
                Kirim Ulang
            </button>

            <a href="<?= base_url('staff/laporan') ?>"
               class="bg-gray-400 hover:bg-gray-500 text-white font-semibold
                      px-5 py-2.5 rounded-lg shadow transition-all text-center">
               Kembali
            </a>
        </div>

    </form>

</div>

<?= $this->endSection() ?>
