<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<div class="max-w-lg mx-auto">
    <h4 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-6">Tambah Bidang</h4>

    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6">
        <form action="<?= base_url('admin/bidang/store'); ?>" method="POST" class="space-y-4">

            <div>
                <label class="block text-gray-700 dark:text-gray-200 mb-1 font-medium">Nama Bidang</label>
                <input type="text" name="nama_bidang" required
                       class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 
                              focus:outline-none focus:ring-2 focus:ring-orange-400 dark:bg-gray-700 dark:text-white">
            </div>

            <div class="flex justify-end gap-2">
                <a href="<?= base_url('admin/bidang'); ?>" 
                   class="px-4 py-2 bg-gray-400 hover:bg-gray-500 text-white rounded-md font-medium transition">
                   Kembali
                </a>
                <button type="submit" 
                        class="px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white rounded-md font-medium shadow transition">
                    Simpan
                </button>
            </div>

        </form>
    </div>
</div>

<?= $this->endSection() ?>
