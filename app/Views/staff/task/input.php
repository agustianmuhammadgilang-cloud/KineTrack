<?= $this->extend('layout/staff_template') ?>
<?= $this->section('content') ?>

<h3 class="text-2xl font-bold text-[var(--polban-blue)] mb-6">
    Input Pengukuran Indikator
</h3>

<?php
use App\Models\PicModel;
use App\Models\IndikatorModel;
use App\Models\SasaranModel;

$picModel = new PicModel();
$pic = $picModel->getPicByIndikator($indikator_id);

$indikatorModel = new IndikatorModel();
$indikator = $indikatorModel->find($indikator_id);

$sasaranModel = new SasaranModel();
$sasaran = $sasaranModel->find($indikator['sasaran_id'] ?? null);
?>

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
                    <span class="text-sm text-gray-600">
                        <?= esc($p['nama_bidang']) ?> / <?= esc($p['nama_jabatan']) ?>
                    </span>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>

<!-- SASARAN STRATEGIS & INDIKATOR -->
<div class="bg-white shadow-md rounded-xl p-5 mb-6 border border-gray-200">
    <h4 class="text-lg font-semibold text-gray-800 mb-3">Sasaran Strategis & Indikator</h4>

    <?php if ($sasaran): ?>
        <p class="text-gray-700 mb-1">
            <span class="font-semibold">Sasaran Strategis:</span> <?= esc($sasaran['nama_sasaran']) ?>
        </p>
        <p class="text-gray-700 mb-1">
            <span class="font-semibold">Indikator Kinerja:</span> <?= esc($indikator['nama_indikator'] ?? '-') ?>
        </p>
    <?php else: ?>
        <p class="text-gray-600 text-sm">Sasaran strategis tidak ditemukan.</p>
    <?php endif; ?>
</div>

<!-- FORM INPUT -->
<div class="bg-white shadow-md rounded-xl p-6 border border-gray-200">
    <form action="<?= base_url('staff/task/store') ?>" 
          method="post" 
          enctype="multipart/form-data"
          class="space-y-5">

        <input type="hidden" name="indikator_id" value="<?= $indikator_id ?>">

        <!-- TARGET PK -->
        <label class="block font-medium mb-1 text-gray-700">Target PK</label>
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <p class="text-lg font-bold text-blue-900">
                <?= esc($indikator['target_pk'] ?? '-') ?>
            </p>
        </div>

        <!-- Progress -->
        <div>
            <label class="block font-medium mb-1 text-gray-700">Progress (%)</label>
            <input type="number" name="progress" min="0" max="100"
                   class="w-full rounded-lg border border-gray-300 px-3 py-2
                          focus:ring-2 focus:ring-[var(--polban-blue)] focus:outline-none">
        </div>

        <!-- Realisasi -->
        <div>
            <label class="block font-medium mb-1 text-gray-700">Realisasi</label>
            <input type="text" name="realisasi" required
                   class="w-full rounded-lg border border-gray-300 px-3 py-2 
                          focus:ring-2 focus:ring-[var(--polban-blue)] focus:outline-none">
        </div>

        <!-- Kendala -->
        <div>
            <label class="block font-medium mb-1 text-gray-700">Kendala/Permasalahan</label>
            <textarea name="kendala" rows="3"
                class="w-full rounded-lg border border-gray-300 px-3 py-2
                       focus:ring-2 focus:ring-[var(--polban-blue)] focus:outline-none"></textarea>
        </div>

        <!-- Strategi -->
        <div>
            <label class="block font-medium mb-1 text-gray-700">Strategi/Tindak Lanjut</label>
            <textarea name="strategi" rows="3"
                class="w-full rounded-lg border border-gray-300 px-3 py-2
                       focus:ring-2 focus:ring-[var(--polban-blue)] focus:outline-none"></textarea>
        </div>

        <!-- File Dukung -->
        <div>
            <label class="block font-medium mb-1 text-gray-700">File Dukung</label>
            <input type="file" name="file_dukung"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 cursor-pointer
                       focus:ring-2 focus:ring-[var(--polban-blue)] focus:outline-none">
        </div>

        <!-- Submit -->
        <button type="submit"
            class="px-5 py-2 bg-[var(--polban-blue)] text-white rounded-lg font-medium shadow 
                   hover:bg-blue-700 transition">
            Simpan
        </button>

    </form>
</div>

<?= $this->endSection() ?>
