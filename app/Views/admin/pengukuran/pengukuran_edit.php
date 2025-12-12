<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<h3 class="text-2xl font-bold text-[var(--polban-blue)] mb-6">
    Edit Pengukuran
</h3>

<form action="<?= base_url('admin/pengukuran/update/' . $data['id']) ?>"
      method="post" enctype="multipart/form-data"
      class="space-y-6 bg-white p-6 rounded-xl shadow border border-gray-200">

    <!-- REALISASI -->
    <div>
        <label class="block font-semibold mb-1 text-gray-700">Realisasi</label>
        <input type="number" name="realisasi" value="<?= esc($data['realisasi']) ?>" required
               class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-[var(--polban-blue)] focus:outline-none">
    </div>

    <!-- PROGRESS -->
    <div>
        <label class="block font-semibold mb-1 text-gray-700">Progress / Kegiatan</label>
        <textarea name="progress" rows="3"
                  class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-[var(--polban-blue)] focus:outline-none"><?= esc($data['progress']) ?></textarea>
    </div>

    <!-- KENDALA -->
    <div>
        <label class="block font-semibold mb-1 text-gray-700">Kendala / Permasalahan</label>
        <textarea name="kendala" rows="3"
                  class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-[var(--polban-blue)] focus:outline-none"><?= esc($data['kendala']) ?></textarea>
    </div>

    <!-- STRATEGI -->
    <div>
        <label class="block font-semibold mb-1 text-gray-700">Strategi / Tindak Lanjut</label>
        <textarea name="strategi" rows="3"
                  class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-[var(--polban-blue)] focus:outline-none"><?= esc($data['strategi']) ?></textarea>
    </div>


    <!-- FILE DUKUNG -->
    <?php 
        $files = json_decode($data['file_dukung'], true);
        if (is_string($data['file_dukung']) && !is_array($files)) {
            $files = [$data['file_dukung']];
        }
    ?>

    <div>
        <label class="block font-semibold mb-2 text-gray-700">File Dukung / Data Pendukung</label>

        <!-- LIST FILE LAMA -->
        <?php if (!empty($files)): ?>
            <div class="space-y-2 mb-3 bg-gray-50 p-3 rounded-lg border">
                <p class="font-semibold text-gray-700 mb-2">File Lama:</p>

                <?php foreach ($files as $i => $f): ?>
                    <div class="flex items-center justify-between bg-white border rounded-lg p-2">
                        <a href="<?= base_url('uploads/pengukuran/' . $f) ?>"
                           target="_blank"
                           class="text-blue-600 hover:underline">
                            <?= esc($f) ?>
                        </a>

                        <a href="<?= base_url('admin/pengukuran/deleteFile/' . $data['id'] . '/' . $i) ?>"
                           onclick="return confirm('Hapus file ini?')"
                           class="text-red-600 hover:text-red-800 text-sm font-medium">
                            Hapus
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-gray-500 mb-2">Belum ada file pendukung.</p>
        <?php endif; ?>

        <!-- UPLOAD FILE BARU -->
        <label class="text-gray-700 font-medium">Tambah File Baru</label>
        <input type="file" name="file_dukung[]" multiple
               class="w-full border border-gray-300 rounded-lg px-3 py-2 cursor-pointer focus:ring-2 focus:ring-[var(--polban-blue)] focus:outline-none">

        <p class="text-sm text-gray-500 mt-1">Anda dapat mengupload lebih dari satu file.</p>
    </div>


    <!-- SUBMIT -->
    <button type="submit"
            class="px-5 py-2 bg-[var(--polban-blue)] text-white rounded-lg font-medium shadow hover:bg-blue-800 transition">
        Simpan Perubahan
    </button>

</form>

<?= $this->endSection() ?>
