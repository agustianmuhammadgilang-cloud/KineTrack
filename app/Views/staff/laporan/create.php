<?= $this->extend('layout/staff_template') ?>
<?= $this->section('content') ?>

<h3 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-100">Buat Laporan Baru</h3>

<div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 transition-colors">

    <form action="<?= base_url('staff/laporan/store') ?>" method="POST" enctype="multipart/form-data" class="space-y-4">

        <div>
            <label class="block font-medium mb-1">Judul</label>
            <input type="text" name="judul" required 
                   class="w-full border-gray-300 rounded px-3 py-2 shadow-sm focus:ring focus:ring-orange-300">
        </div>

        <div>
            <label class="block font-medium mb-1">Deskripsi</label>
            <textarea name="deskripsi" rows="5" required 
                      class="w-full border-gray-300 rounded px-3 py-2 shadow-sm focus:ring focus:ring-orange-300"></textarea>
        </div>

        <div>
            <label class="block font-medium mb-1">Tanggal</label>
            <input type="date" name="tanggal" required 
                   class="w-full border-gray-300 rounded px-3 py-2 shadow-sm focus:ring focus:ring-orange-300">
        </div>

        <div>
            <label class="block font-medium mb-1">Bukti Kegiatan (opsional)</label>
            <input type="file" name="file_bukti" 
                   class="w-full border-gray-300 rounded px-3 py-2 shadow-sm focus:ring focus:ring-orange-300">
        </div>

        <div class="flex gap-2 mt-4">
            <button class="bg-orange-500 hover:bg-orange-600 text-white font-semibold px-4 py-2 rounded shadow transition-all">
                Kirim
            </button>
            <a href="<?= base_url('staff/laporan') ?>" 
               class="bg-gray-400 hover:bg-gray-500 text-white font-semibold px-4 py-2 rounded shadow transition-all">
               Kembali
            </a>
        </div>

    </form>

</div>

<?= $this->endSection() ?>
