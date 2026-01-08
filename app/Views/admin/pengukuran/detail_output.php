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

<!-- Tombol Back -->
<a href="<?= base_url('admin/pengukuran/output?tahun_id='.$tahun.'&triwulan='.$tw) ?>"
   class="inline-block mb-4 bg-[var(--polban-blue)] text-white px-4 py-2 rounded-lg shadow hover:bg-blue-800 transition">
    Kembali
</a>



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
                        <th class="p-3 border">Aksi</th>
                    </tr>
                </thead>

                <tbody>
<?php foreach ($pengukuran as $p): ?>
    <tr class="hover:bg-gray-50">

        <!-- STAFF -->
        <td class="p-3 border"><?= esc($p['user_nama']) ?></td>

        <!-- REALISASI -->
        <td class="p-3 border"><?= esc($p['realisasi']) ?></td>

        <!-- PROGRESS -->
        <td class="p-3 border"><?= $p['progress'] ? esc($p['progress']) : '-' ?></td>

        <!-- KENDALA -->
        <td class="p-3 border"><?= esc($p['kendala'] ?: '-') ?></td>

        <!-- STRATEGI -->
        <td class="p-3 border"><?= esc($p['strategi'] ?: '-') ?></td>

        <!-- FILE DUKUNG -->
        <td class="p-3 border text-center">
            <?php
                $files = json_decode($p['file_dukung'], true);

                // BACKWARD COMPATIBILITY: jika single string
                if (is_string($p['file_dukung']) && !is_array($files)) {
                    $files = [$p['file_dukung']];
                }
            ?>

            <?php if (!empty($files) && is_array($files)): ?>
                <ul class="text-left space-y-1">
                    <?php foreach ($files as $i => $f): ?>
                        <li>
                            <a href="<?= base_url('uploads/pengukuran/' . $f) ?>"
                               target="_blank"
                               class="text-blue-600 hover:underline">
                                File <?= $i + 1 ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <span class="text-gray-500">-</span>
            <?php endif; ?>
        </td>

        <!-- TANGGAL INPUT -->
        <td class="p-3 border">
            <?= esc(date('d M Y H:i', strtotime($p['created_at']))) ?>
        </td>

        <!-- AKSI -->
        <td class="p-3 border text-center">
            <div class="flex items-center justify-center gap-3">

                <!-- EDIT -->
                <a href="<?= base_url('admin/pengukuran/edit/' . $p['id']) ?>"
                   class="p-2 bg-[var(--polban-blue)] text-white rounded-lg shadow hover:bg-blue-800 transition"
                   title="Edit">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.8" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16.862 3.487a2.25 2.25 0 113.182 3.182L7.5 19.213 3 21l1.787-4.5L16.862 3.487z" />
                    </svg>
                </a>

                <!-- DELETE -->
                <a href="<?= base_url('admin/pengukuran/delete/' . $p['id']) ?>"
                   onclick="return confirm('Yakin ingin menghapus data ini?')"
                   class="p-2 bg-red-600 text-white rounded-lg shadow hover:bg-red-700 transition"
                   title="Hapus">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.8" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M6 7h12M9 7v10m6-10v10M4 7h16l-1 12a2 2 0 01-2 2H7a2 2 0 01-2-2L4 7zm5-3h6a1 1 0 011 1v1H8V5a1 1 0 011-1z" />
                    </svg>
                </a>

                <!-- PDF -->
                <a href="<?= base_url('admin/pengukuran/pdf/' . $p['id']) ?>"
                   class="p-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 transition"
                   title="Export PDF">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.8" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 10.5V6m0 0l-1.5 1.5M12 6l1.5 1.5m-6 4.5h9m-9 3h6m4.5-8.25V18a2.25 2.25 0 01-2.25 2.25H7.5A2.25 2.25 0 015.25 18V6.75A2.25 2.25 0 017.5 4.5h6.75L18 7.5z" />
                    </svg>
                </a>

            </div>
        </td>

    </tr>
<?php endforeach; ?>
</tbody>

            </table>
        </div>

    <?php endif; ?>
</div>

<?= $this->endSection() ?>