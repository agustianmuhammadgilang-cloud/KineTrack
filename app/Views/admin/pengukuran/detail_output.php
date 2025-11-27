<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<h3 class="text-2xl font-bold text-[var(--polban-blue)] mb-6">
    Detail Pengukuran - Indikator
</h3>

<!-- Informasi Indikator -->
<div class="bg-white shadow-md rounded-xl p-6 border border-gray-200 mb-6">

    <h4 class="text-xl font-semibold text-gray-800 mb-4">
        Informasi Indikator
    </h4>

    <p class="text-gray-600 mb-1">
        <strong>Sasaran Strategis:</strong> <?= esc($indikator['nama_sasaran']) ?>
    </p>

    <p class="text-gray-600 mb-1">
        <strong>Nama Indikator:</strong> <?= esc($indikator['nama_indikator']) ?>
    </p>

    <p class="text-gray-600 mb-1">
        <strong>Satuan:</strong> <?= esc($indikator['satuan'] ?? '-') ?>
    </p>

    <p class="text-gray-600 mb-1">
        <strong>Target PK (<?= esc($tahun) ?>):</strong> <?= esc($indikator['target_pk'] ?? '-') ?>
    </p>

    <p class="text-gray-600 mb-4">
        <strong>Target Per Triwulan:</strong><br>
        • TW I : <?= esc($indikator['target_tw1'] ?? '-') ?><br>
        • TW II : <?= esc($indikator['target_tw2'] ?? '-') ?><br>
        • TW III : <?= esc($indikator['target_tw3'] ?? '-') ?><br>
        • TW IV : <?= esc($indikator['target_tw4'] ?? '-') ?>
    </p>

    <p class="text-gray-700 text-sm italic">
        <strong>Periode:</strong> Tahun <?= esc($tahun) ?> — Triwulan <?= esc($tw) ?>
    </p>
</div>


<!-- TABEL PENGUKURAN STAFF -->
<div class="bg-white shadow-md rounded-xl p-6 border border-gray-200">

    <h4 class="text-xl font-semibold text-gray-800 mb-4">
        Input Pengukuran Staff
    </h4>

    <?php if (empty($pengukuran)): ?>
        <p class="text-gray-600 text-sm">Belum ada pengukuran yang diinput staff.</p>

    <?php else: ?>
        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-300 rounded-lg overflow-hidden">
                <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="p-3 border">Staff</th>
                        <th class="p-3 border">Realisasi</th>
                        <th class="p-3 border">Progress</th>
                        <th class="p-3 border">Kendala</th>
                        <th class="p-3 border">Strategi</th>
                        <th class="p-3 border">File Dukung</th>
                        <th class="p-3 border">Tanggal Input</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($pengukuran as $p): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="p-3 border"><?= esc($p['user_nama']) ?></td>
                            <td class="p-3 border"><?= esc($p['realisasi']) ?></td>
                            <td class="p-3 border"><?= $p['progress'] ? esc($p['progress']) : '-' ?></td>
                            <td class="p-3 border"><?= esc($p['kendala'] ?: '-') ?></td>
                            <td class="p-3 border"><?= esc($p['strategi'] ?: '-') ?></td>

                            <td class="p-3 border text-center">
                                <?php if ($p['file_dukung']): ?>
                                    <a href="<?= base_url('uploads/pengukuran/' . $p['file_dukung']) ?>"
                                       target="_blank"
                                       class="text-blue-600 hover:underline">
                                        Lihat File
                                    </a>
                                <?php else: ?>
                                    <span class="text-gray-500">-</span>
                                <?php endif; ?>
                            </td>

                            <td class="p-3 border">
                                <?= esc(date('d M Y H:i', strtotime($p['created_at']))) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    <?php endif; ?>
</div>

<?= $this->endSection() ?>