<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<div class="max-w-lg mx-auto px-4 sm:px-6 lg:px-8">
    <h4 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-6">
        Tambah Unit Kerja
    </h4>

    <?php if(session()->getFlashdata('error')): ?>
    <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4">
        <?= session()->getFlashdata('error') ?>
    </div>
    <?php endif; ?>

    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6">
        <form action="<?= base_url('admin/bidang/store'); ?>" method="POST" class="space-y-4">

            <!-- Nama Unit -->
            <div>
                <label class="block text-gray-700 dark:text-gray-200 mb-1 font-medium">
                    Nama Unit Kerja
                </label>
                <input type="text" name="nama_bidang" required
                       value="<?= old('nama_bidang') ?>"
                       class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 
                              focus:outline-none focus:ring-2 focus:ring-orange-400 dark:bg-gray-700 dark:text-white">
            </div>

            <!-- Jenis Unit -->
            <div>
                <label class="block text-gray-700 dark:text-gray-200 mb-1 font-medium">
                    Jenis Unit Kerja
                </label>
                <select name="jenis_unit" id="jenis_unit" required
                        class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 
                               dark:bg-gray-700 dark:text-white">
                    <option value="">-- Pilih Jenis Unit --</option>
                    <option value="jurusan" <?= old('jenis_unit') === 'jurusan' ? 'selected' : '' ?>>Jurusan</option>
                    <option value="prodi"   <?= old('jenis_unit') === 'prodi' ? 'selected' : '' ?>>Prodi</option>
                </select>
            </div>

            <!-- Induk Jurusan (CONDITIONAL) -->
            <div id="parent-wrapper" class="<?= old('jenis_unit') === 'prodi' ? '' : 'hidden' ?>">
                <label class="block text-gray-700 dark:text-gray-200 mb-1 font-medium">
                    Induk Jurusan
                </label>
                <select name="parent_id"
                        class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 
                               dark:bg-gray-700 dark:text-white">
                    <option value="">-- Pilih Jurusan --</option>
                    <?php foreach ($jurusan as $j): ?>
                        <option value="<?= $j['id'] ?>" <?= old('parent_id') == $j['id'] ? 'selected' : '' ?>>
                            <?= esc($j['nama_bidang']) ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>

            <!-- Action -->
            <div class="flex flex-col sm:flex-row justify-end gap-2 mt-4">
                <a href="<?= base_url('admin/bidang'); ?>" 
                   class="px-4 py-2 bg-gray-400 hover:bg-gray-500 text-white rounded-md font-medium text-center transition">
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

<script>
document.getElementById('jenis_unit').addEventListener('change', function () {
    const parentWrapper = document.getElementById('parent-wrapper');
    parentWrapper.classList.toggle('hidden', this.value !== 'prodi');
});
</script>

<?= $this->endSection() ?>
