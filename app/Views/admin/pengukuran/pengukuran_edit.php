<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<h3 class="text-2xl font-bold text-[var(--polban-blue)] mb-6">
    Edit Pengukuran
</h3>

<form action="<?= base_url('admin/pengukuran/update/' . $data['id']) ?>" method="post" enctype="multipart/form-data" class="space-y-5 bg-white p-6 rounded-xl shadow border border-gray-200">

    <!-- Realisasi -->
    <div>
        <label class="block font-semibold mb-1 text-gray-700">Realisasi</label>
        <input type="number" name="realisasi" value="<?= esc($data['realisasi']) ?>" required
               class="w-full rounded-lg border border-gray-300 px-3 py-2
                      focus:ring-2 focus:ring-[var(--polban-blue)] focus:outline-none">
    </div>

    <!-- Progress -->
    <div>
        <label class="block font-semibold mb-1 text-gray-700">Progress / Kegiatan</label>
        <textarea name="progress" rows="3"
                  class="w-full rounded-lg border border-gray-300 px-3 py-2
                         focus:ring-2 focus:ring-[var(--polban-blue)] focus:outline-none"><?= esc($data['progress']) ?></textarea>
    </div>

    <!-- Kendala -->
    <div>
        <label class="block font-semibold mb-1 text-gray-700">Kendala / Permasalahan</label>
        <textarea name="kendala" rows="3"
                  class="w-full rounded-lg border border-gray-300 px-3 py-2
                         focus:ring-2 focus:ring-[var(--polban-blue)] focus:outline-none"><?= esc($data['kendala']) ?></textarea>
    </div>

    <!-- Strategi -->
    <div>
        <label class="block font-semibold mb-1 text-gray-700">Strategi / Tindak Lanjut</label>
        <textarea name="strategi" rows="3"
                  class="w-full rounded-lg border border-gray-300 px-3 py-2
                         focus:ring-2 focus:ring-[var(--polban-blue)] focus:outline-none"><?= esc($data['strategi']) ?></textarea>
    </div>

    <!-- File Dukung -->
    <div>
        <label class="block font-semibold mb-1 text-gray-700">File Dukung / Data Pendukung</label>
        <input type="file" name="file_dukung"
               class="w-full border border-gray-300 rounded-lg px-3 py-2 cursor-pointer
                      focus:ring-2 focus:ring-[var(--polban-blue)] focus:outline-none">
        <p class="text-sm text-gray-500 mt-1">File saat ini: <?= esc($data['file_dukung'] ?: '-') ?></p>
    </div>

    <button type="submit"
            class="px-5 py-2 bg-[var(--polban-blue)] text-white rounded-lg font-medium shadow
                   hover:bg-blue-800 transition">
        Simpan
    </button>

</form>

<?= $this->endSection() ?>