<?= $this->extend('layout/staff_template') ?>
<?= $this->section('content') ?>

<h3 class="text-2xl font-bold text-[var(--polban-blue)] mb-6">
    Input Pengukuran Indikator — TW <?= esc($tw) ?>
</h3>

<!-- PIC Info -->
<div class="bg-white shadow-md rounded-xl p-5 mb-6 border border-gray-200">
    <h4 class="text-lg font-semibold text-gray-800 mb-3">PIC Terkait</h4>

    <p class="text-gray-700">
        <span class="font-semibold"><?= esc($pic['nama']) ?></span>
        (<?= esc($pic['email']) ?>)
    </p>
    <p class="text-sm text-gray-600">
        <?= esc($pic['nama_bidang']) ?> / <?= esc($pic['nama_jabatan']) ?>
    </p>
</div>

<!-- Sasaran & Indikator -->
<div class="bg-white shadow-md rounded-xl p-5 mb-6 border border-gray-200">
    <h4 class="text-lg font-semibold text-gray-800 mb-3">Sasaran Strategis & Indikator</h4>

    <p class="text-gray-700 mb-1">
        <span class="font-semibold">Sasaran Strategis:</span> <?= esc($sasaran['nama_sasaran']) ?>
    </p>
    <p class="text-gray-700 mb-1">
        <span class="font-semibold">Indikator:</span> <?= esc($indikator['nama_indikator']) ?>
    </p>
    <p class="text-gray-700 mb-1">
        <span class="font-semibold">Satuan:</span> <?= esc($indikator['satuan']) ?>
    </p>
    <p class="text-gray-700 mb-1">
        <span class="font-semibold">Target PK (<?= esc($tahun) ?>):</span> <?= esc($indikator['target_pk']) ?>
    </p>
</div>

<!-- FORM INPUT -->
<div class="bg-white shadow-md rounded-xl p-6 border border-gray-200">
    <form action="<?= base_url('staff/task/store') ?>" method="post" enctype="multipart/form-data" class="space-y-5">

        <!-- HIDDEN INPUTS -->
        <input type="hidden" name="indikator_id" value="<?= esc($indikator_id) ?>">
        <input type="hidden" name="triwulan" value="<?= esc($tw) ?>">
        <input type="hidden" name="tahun" value="<?= esc($tahun) ?>">

        <!-- Realisasi -->
        <div>
            <label class="block font-medium mb-1 text-gray-700">Realisasi</label>
            <input type="number" name="realisasi" step="any" min="0" required
                   class="w-full rounded-lg border border-gray-300 px-3 py-2
                          focus:ring-2 focus:ring-[var(--polban-blue)] focus:outline-none">
        </div>

        <!-- Progress -->
        <div>
            <label class="block font-medium mb-1 text-gray-700">Progress / Kegiatan</label>
            <textarea name="progress" rows="3"
                      class="w-full rounded-lg border border-gray-300 px-3 py-2
                             focus:ring-2 focus:ring-[var(--polban-blue)] focus:outline-none"></textarea>
        </div>

        <!-- Kendala -->
        <div>
            <label class="block font-medium mb-1 text-gray-700">Kendala / Permasalahan</label>
            <textarea name="kendala" rows="3"
                      class="w-full rounded-lg border border-gray-300 px-3 py-2
                             focus:ring-2 focus:ring-[var(--polban-blue)] focus:outline-none"></textarea>
        </div>

        <!-- Strategi -->
        <div>
            <label class="block font-medium mb-1 text-gray-700">Strategi / Tindak Lanjut</label>
            <textarea name="strategi" rows="3"
                      class="w-full rounded-lg border border-gray-300 px-3 py-2
                             focus:ring-2 focus:ring-[var(--polban-blue)] focus:outline-none"></textarea>
        </div>

        <!-- File Dukung -->
        <div>
            <label class="block font-medium mb-1 text-gray-700">File Dukung (Opsional)</label>
            <input type="file" name="file_dukung"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 cursor-pointer
                          focus:ring-2 focus:ring-[var(--polban-blue)] focus:outline-none">
        </div>

        <button type="submit"
                class="px-5 py-2 bg-[var(--polban-blue)] text-white rounded-lg font-medium shadow
                       hover:bg-blue-700 transition">
            Simpan
        </button>
    </form>
</div>

<?= $this->endSection() ?>
