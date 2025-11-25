<?= $this->extend('layout/staff_template') ?>
<?= $this->section('content') ?>

<h3 class="text-2xl font-bold text-[var(--polban-blue)] mb-6">
    Input Pengukuran Indikator - TW <?= esc($tw) ?>
</h3>

<!-- PIC Info -->
<div class="bg-white shadow-md rounded-xl p-5 mb-6 border border-gray-200">
    <h4 class="text-lg font-semibold text-gray-800 mb-3">PIC Terkait</h4>
    <?php if (empty($pic)): ?>
        <p class="text-gray-600 text-sm">Tidak ada PIC terdaftar.</p>
    <?php else: ?>
        <ul class="space-y-2">
            <?php foreach($pic as $p): ?>
                <li class="text-gray-700">
                    <span class="font-semibold"><?= esc($p['nama']) ?></span>
                    (<?= esc($p['email']) ?>) — 
                    <span class="text-sm text-gray-600"><?= esc($p['nama_bidang']) ?> / <?= esc($p['nama_jabatan']) ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>

<!-- Sasaran & Indikator -->
<div class="bg-white shadow-md rounded-xl p-5 mb-6 border border-gray-200">
    <h4 class="text-lg font-semibold text-gray-800 mb-3">Sasaran Strategis & Indikator</h4>
    <?php if ($sasaran && $indikator): ?>
        <p class="text-gray-700 mb-1">
            <span class="font-semibold">Sasaran Strategis:</span> <?= esc($sasaran['nama_sasaran']) ?>
        </p>
        <p class="text-gray-700 mb-1">
            <span class="font-semibold">Indikator Kinerja:</span> <?= esc($indikator['nama_indikator']) ?>
        </p>
        <p class="text-gray-700 mb-1">
            <span class="font-semibold">Target PK:</span> <?= esc($indikator['target_pk']) ?>
        </p>
    <?php else: ?>
        <p class="text-gray-600 text-sm">Sasaran strategis atau indikator tidak ditemukan.</p>
    <?php endif; ?>
</div>

<!-- Form Input -->
<div class="bg-white shadow-md rounded-xl p-6 border border-gray-200">
    <form action="<?= base_url('staff/task/store') ?>" method="post" enctype="multipart/form-data" class="space-y-5">
        <?= csrf_field() ?> <!-- Tambahkan CSRF protection -->

        <input type="hidden" name="indikator_id" value="<?= esc($indikator_id) ?>">
        <input type="hidden" name="tw" value="<?= esc($tw) ?>">
        <input type="hidden" name="tahun_id" value="<?= esc($tahun_id) ?>">

        <!-- Progress -->
        <div>
            <label class="block font-medium mb-1 text-gray-700">Progress (%)</label>
            <input type="number" name="progress" min="0" max="100" required
                   class="w-full rounded-lg border border-gray-300 px-3 py-2
                          focus:ring-2 focus:ring-[var(--polban-blue)] focus:outline-none"
                   value="<?= old('progress') ?>">
        </div>

        <!-- Realisasi -->
        <div>
            <label class="block font-medium mb-1 text-gray-700">Realisasi</label>
            <input type="text" name="realisasi" required
                   class="w-full rounded-lg border border-gray-300 px-3 py-2
                          focus:ring-2 focus:ring-[var(--polban-blue)] focus:outline-none"
                   value="<?= old('realisasi') ?>">
        </div>

        <!-- Kendala -->
        <div>
            <label class="block font-medium mb-1 text-gray-700">Kendala / Permasalahan</label>
            <textarea name="kendala" rows="3"
                      class="w-full rounded-lg border border-gray-300 px-3 py-2
                             focus:ring-2 focus:ring-[var(--polban-blue)] focus:outline-none"><?= old('kendala') ?></textarea>
        </div>

        <!-- Strategi -->
        <div>
            <label class="block font-medium mb-1 text-gray-700">Strategi / Tindak Lanjut</label>
            <textarea name="strategi" rows="3"
                      class="w-full rounded-lg border border-gray-300 px-3 py-2
                             focus:ring-2 focus:ring-[var(--polban-blue)] focus:outline-none"><?= old('strategi') ?></textarea>
        </div>

        <!-- File Dukung -->
        <div>
            <label class="block font-medium mb-1 text-gray-700">File Dukung</label>
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
