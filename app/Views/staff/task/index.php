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
                        // Ambil dari controller
                        $twInfo = $ind['tw_status'][$tw];

                        // ================
                        // Fallback Format
                        // (jika data lama berupa boolean)
                        // ================
                        if (is_bool($twInfo)) {
                            $isOpen = $twInfo;
                            $source = $twInfo ? 'admin' : 'closed';
                        } else {
                            // Format baru
                            $isOpen = $twInfo['is_open'];
                            $source = $twInfo['source'];
                        }

                        // ====================
                        // Badge warna
                        // ====================
                        if (!$isOpen) {
                            $badge = "bg-red-500 text-white";
                        } elseif ($source === 'auto') {
                            $badge = "bg-blue-600 text-white";
                        } else {
                            $badge = "bg-green-600 text-white";
                        }
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

                        <?php if ($isOpen): ?>
                            <a href="<?= base_url('staff/task/input/'.$ind['indikator_id'].'/'.$tw) ?>"
                                class="block mt-2 bg-[var(--polban-blue)] text-white py-1 rounded hover:bg-blue-700 transition text-sm">
                                Isi Pengukuran
                            </a>
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
