<?= $this->extend('layout/staff_template') ?>
<?= $this->section('content') ?>

<h3 class="text-2xl font-bold text-[var(--polban-blue)] mb-6">
    Tugas Pengukuran Kinerja Anda
</h3>

<?php if (empty($tasksGrouped)): ?>
    <div class="bg-white p-6 rounded-lg shadow border border-gray-200 text-gray-600">
        Tidak ada indikator yang ditugaskan kepada Anda.
    </div>
<?php else: ?>

<?php foreach ($tasksGrouped as $sasaran => $indikatorList): ?>
<div class="mb-6 bg-white shadow-md rounded-xl border border-gray-200 p-5">

    <h4 class="text-lg font-bold text-[var(--polban-blue)] mb-4 border-b pb-2">
        <?= esc($sasaran) ?>
    </h4>

    <?php foreach ($indikatorList as $ind): ?>
        <div class="mb-4 p-4 border rounded-lg hover:shadow transition bg-gray-50">

            <p class="font-semibold text-gray-800"><?= esc($ind['nama_indikator']) ?></p>
            <p class="text-sm text-gray-600 mb-3">Tahun <?= $ind['tahun'] ?></p>

            <!-- TW STATUS BAR -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">

                <?php foreach ([1,2,3,4] as $tw): ?>

                    <?php
                        // Ambil data TW
                        $twInfo = $ind['tw_status'][$tw];

                        // Normalisasi format
                        if (is_bool($twInfo)) {
                            $isOpen = $twInfo;
                            $source = $twInfo ? 'admin' : 'closed';
                        } else {
                            $isOpen = $twInfo['is_open'];
                            $source = $twInfo['source'];
                        }

                        // Badge warna status TW
                        if (!$isOpen) {
                            $badge = "bg-red-500 text-white";
                        } elseif ($source === 'auto') {
                            $badge = "bg-blue-600 text-white";
                        } else {
                            $badge = "bg-green-600 text-white";
                        }

                        // Data pengukuran TW (DIAMBIL dari controller, jangan sentuh logika lama)
                        $measure = $ind['pengukuran'][$tw] ?? null;
                        $hasFilled = $measure !== null;

                        // Target TW (jika ada)
                        $targetTW = $ind['target_tw'][$tw] ?? null;

                        // Hitung progress TW
                        $realisasi = $measure['realisasi'] ?? 0;
                        $percent = ($targetTW > 0) ? ($realisasi / $targetTW) * 100 : 0;
                    ?>

                    <div class="p-3 rounded-lg border bg-white text-center shadow-sm">
                        <p class="font-semibold mb-1">TW <?= $tw ?></p>

                        <span class="px-3 py-1 text-xs rounded-full <?= $badge ?>">
                            <?php if (!$isOpen): ?>
                                Dikunci
                            <?php elseif ($source === 'auto'): ?>
                                Aktif Otomatis
                            <?php else: ?>
                                Dibuka Admin
                            <?php endif; ?>
                        </span>

                        <!-- CASE 1: BELUM MENGISI -->
                        <?php if (!$hasFilled): ?>

                            <?php if ($isOpen): ?>
                                <a href="<?= base_url('staff/task/input/'.$ind['indikator_id'].'/'.$tw) ?>"
                                   class="block mt-2 bg-[var(--polban-blue)] text-white py-1 rounded hover:bg-blue-700 transition text-sm">
                                    Isi Pengukuran
                                </a>
                            <?php else: ?>
                                <p class="text-xs text-gray-500 italic mt-2">
                                    Belum mengisi
                                </p>
                            <?php endif; ?>

                        <?php else: ?>

                            <!-- CASE 2: SUDAH MENGISI -->
                            <div class="mt-2 text-center">
                                <p class="text-sm font-medium text-gray-700">
                                    Realisasi: <strong><?= $realisasi ?></strong>
                                </p>
                                <p class="text-xs text-gray-600">Target: <?= $targetTW ?></p>

                                <p class="mt-1 text-sm <?= ($percent >= 100 ? 'text-green-600' : 'text-orange-600') ?>">
                                    Progress: <strong><?= round($percent) ?>%</strong>
                                </p>
                            </div>

                            <!-- MENU BARU: REPORT / LIHAT PROGRESS -->
                            <?php if ($percent >= 100): ?>
                                <!-- Report -->
                                <a href="<?= base_url('staff/task/report/'.$ind['indikator_id'].'/'.$tw) ?>"
                                   class="block mt-3 bg-green-600 text-white py-1.5 rounded hover:bg-green-700 transition text-sm">
                                    Lihat Report
                                </a>
                            <?php else: ?>
                                <!-- Lihat Progress -->
                                <a href="<?= base_url('staff/task/progress/'.$ind['indikator_id'].'/'.$tw) ?>"
                                   class="block mt-3 bg-yellow-500 text-white py-1.5 rounded hover:bg-yellow-600 transition text-sm">
                                    Lihat Progress
                                </a>
                            <?php endif; ?>

                        <?php endif; ?>

                    </div>

                <?php endforeach; ?>

            </div>
        </div>
    <?php endforeach; ?>

</div>
<?php endforeach; ?>

<?php endif; ?>

<?= $this->endSection() ?>
