<?= $this->extend('layout/atasan_template') ?>
<?= $this->section('content') ?>

<h3 class="text-2xl font-bold text-[var(--polban-blue)] mb-6">
    Lihat Progress — TW <?= esc($tw) ?>
</h3>

<!-- CARD UTAMA -->
<div class="bg-white p-6 rounded-xl shadow border border-gray-200 space-y-6">

    <!-- INFORMASI INDIKATOR -->
    <div class="border-b pb-4">
        <h4 class="text-lg font-bold text-[var(--polban-blue)] mb-3">Informasi Indikator</h4>

        <p class="text-gray-700"><span class="font-semibold">Indikator:</span> <?= esc($indikator['nama_indikator']) ?></p>
        <p class="text-gray-700"><span class="font-semibold">Satuan:</span> <?= esc($indikator['satuan']) ?></p>

        <p class="text-gray-700 mt-1">
            <span class="font-semibold">Target TW <?= esc($tw) ?>:</span>
            <?= esc($target) ?>
        </p>

        <p class="text-gray-700 mt-1">
            <span class="font-semibold">Realisasi:</span>
            <?= esc($measure['realisasi']) ?>
        </p>

        <!-- Jika realisasi lebih besar dari target -->
        <?php if ($measure['realisasi'] > $target): ?>
            <p class="text-green-700 font-semibold mt-1">
                +<?= esc($measure['realisasi'] - $target) ?> (Nilai Tambah)
            </p>
        <?php endif; ?>
    </div>

    <!-- PROGRESS BAR -->
    <div class="">
        <h4 class="text-lg font-bold text-[var(--polban-blue)] mb-2">Progress</h4>

        <div class="w-full bg-gray-200 rounded-full h-4 overflow-hidden">
            <div class="h-full
                        <?php if ($percent >= 100): ?>
                            bg-green-600
                        <?php else: ?>
                            bg-yellow-500
                        <?php endif; ?>"
                 style="width: <?= min($percent, 100) ?>%;"></div>
        </div>

        <p class="text-sm text-gray-700 mt-2">
            <span class="font-semibold"><?= round($percent) ?>%</span> — Progress terhadap target TW.
        </p>
    </div>

    <!-- DETAIL PROGRESS -->
    <div class="">
        <h4 class="text-lg font-bold text-[var(--polban-blue)] mb-2">Detail Progress</h4>

        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200 space-y-4">

            <div>
                <p class="font-semibold text-gray-700">Progress / Kegiatan</p>
                <p class="text-gray-600"><?= nl2br(esc($measure['progress'])) ?: '-' ?></p>
            </div>

            <div>
                <p class="font-semibold text-gray-700">Kendala / Permasalahan</p>
                <p class="text-gray-600"><?= nl2br(esc($measure['kendala'])) ?: '-' ?></p>
            </div>

            <div>
                <p class="font-semibold text-gray-700">Strategi / Tindak Lanjut</p>
                <p class="text-gray-600"><?= nl2br(esc($measure['strategi'])) ?: '-' ?></p>
            </div>

        </div>
    </div>

    <!-- FILE DUKUNG -->
    <div>
        <h4 class="text-lg font-bold text-[var(--polban-blue)] mb-2">File Dukung</h4>

        <?php
            $files = json_decode($measure['file_dukung'], true);
        ?>

        <?php if (empty($files)): ?>
            <p class="text-gray-600 italic">Tidak ada file dukung diunggah.</p>
        <?php else: ?>
            <ul class="space-y-2">
                <?php foreach ($files as $file): ?>
                    <li class="flex items-center justify-between bg-white border p-3 rounded-lg shadow-sm">
                        <div class="flex items-center space-x-3">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" stroke-width="1.5"
                                 viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M3 7a2 2 0 012-2h10l4 4v9a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                            </svg>
                            <span class="text-gray-700 text-sm"><?= esc($file) ?></span>
                        </div>

                        <a href="<?= base_url('uploads/pengukuran/'.$file) ?>"
                           target="_blank"
                           class="text-[var(--polban-blue)] hover:underline text-sm font-medium">
                            Lihat
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>

</div>

<!-- BACK BUTTON -->
<div class="mt-6">
    <a href="<?= base_url('atasan/task') ?>"
       class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
        ← Kembali
    </a>
</div>

<?= $this->endSection() ?>
