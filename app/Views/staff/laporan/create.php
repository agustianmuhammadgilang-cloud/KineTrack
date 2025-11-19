<?= $this->extend('layout/staff_template') ?>
<?= $this->section('content') ?>

<h3 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-100">
    Buat Laporan Baru
</h3>

<div class="bg-white dark:bg-gray-800 shadow rounded-xl p-6 transition-all">

    <form action="<?= base_url('staff/laporan/store') ?>" 
          method="POST" enctype="multipart/form-data" 
          class="space-y-5">

        <!-- Judul -->
        <div class="flex flex-col">
            <label class="block font-medium mb-1 text-gray-700 dark:text-gray-300">Judul</label>
            <input type="text" 
                   name="judul" 
                   required
                   class="w-full border border-gray-300 dark:border-gray-600 
                          rounded-lg px-3 py-2 shadow-sm bg-white dark:bg-gray-700
                          focus:ring-2 focus:ring-orange-400 dark:focus:ring-orange-500
                          focus:outline-none transition">
        </div>

        <!-- Deskripsi -->
        <div class="flex flex-col">
            <label class="block font-medium mb-1 text-gray-700 dark:text-gray-300">Deskripsi</label>
            <textarea name="deskripsi" rows="5" required
                      class="w-full border border-gray-300 dark:border-gray-600 
                             rounded-lg px-3 py-2 shadow-sm bg-white dark:bg-gray-700
                             focus:ring-2 focus:ring-orange-400 dark:focus:ring-orange-500
                             focus:outline-none transition"></textarea>
        </div>

       <!-- Tanggal (FULL WIDTH) -->
        <div>
            <label class="block font-medium mb-1 text-gray-700 dark:text-gray-300">Tanggal</label>
            <input type="date" name="tanggal" required
                   class="w-full border border-gray-300 dark:border-gray-600 
                          rounded-lg px-3 py-2 shadow-sm bg-white dark:bg-gray-700
                          focus:ring-2 focus:ring-orange-400 dark:focus:ring-orange-500
                          focus:outline-none transition">
        </div>

        <!-- Bukti -->
        <div class="flex flex-col">
            <label class="block font-medium mb-1 text-gray-700 dark:text-gray-300">
                Bukti Kegiatan (opsional)
            </label>
            <input type="file" 
                   name="file_bukti"
                   class="w-full border border-gray-300 dark:border-gray-600 
                          rounded-lg px-3 py-2 shadow-sm bg-white dark:bg-gray-700
                          focus:ring-2 focus:ring-orange-400 dark:focus:ring-orange-500
                          focus:outline-none transition">
        </div>

        <!-- Tombol -->
        <div class="flex flex-col sm:flex-row sm:gap-3 mt-6">
            <button class="bg-orange-500 hover:bg-orange-600 
                           text-white font-semibold px-5 py-2.5 rounded-lg shadow 
                           transition-all text-center">
                Kirim
            </button>

            <a href="<?= base_url('staff/laporan') ?>" 
               class="mt-3 sm:mt-0 bg-gray-400 hover:bg-gray-500 
                      text-white font-semibold px-5 py-2.5 rounded-lg shadow 
                      transition-all text-center">
               Kembali
            </a>
        </div>

    </form>

</div>

<?= $this->endSection() ?>
