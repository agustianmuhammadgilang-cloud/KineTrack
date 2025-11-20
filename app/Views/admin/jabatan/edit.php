<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<h4 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-6">Edit Jabatan</h4>

<div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-4 sm:p-6 max-w-full sm:max-w-md mx-auto">
    <form action="<?= base_url('admin/jabatan/update/'.$jabatan['id']); ?>" method="POST" class="space-y-4">

        <div>
            <label class="block mb-1 text-gray-700 dark:text-gray-200 font-medium">Nama Jabatan</label>
            <input type="text" name="nama_jabatan" value="<?= esc($jabatan['nama_jabatan']) ?>" 
                   class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-orange-400 dark:bg-gray-700 dark:text-white" required>
        </div>

        <div class="flex flex-col sm:flex-row gap-2 mt-4">
            <button type="submit" class="w-full sm:w-auto bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-md font-medium shadow transition">
                Update
            </button>
            <a href="<?= base_url('admin/jabatan'); ?>" 
               class="w-full sm:w-auto bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded-md font-medium shadow transition">
               Kembali
            </a>
        </div>

    </form>
</div>

<?= $this->endSection() ?>
