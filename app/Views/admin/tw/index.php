<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<h3 class="text-2xl font-bold text-[var(--polban-blue)] mb-6">Manajemen Triwulan</h3>

<div class="space-y-6">
    <?php foreach ($data as $row): ?>
        <div class="bg-white shadow-md rounded-lg p-5 border border-gray-200">

            <h4 class="font-semibold text-lg mb-3"><?= $row['tahun'] ?></h4>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <?php foreach ($row['tw'] as $t): ?>

                    <div class="border p-4 rounded-lg text-center shadow-sm">

                        <p class="font-semibold mb-2">TW <?= $t['tw'] ?></p>

                        <!-- STATUS TW -->
                        <span class="inline-block mb-3
                            <?= $t['is_open_effective'] ? 'text-green-600' : 'text-red-600' ?>">
                            <?= $t['is_open_effective'] ? 'Dibuka' : 'Dikunci' ?>
                        </span>

                        <?php
                            // aman meskipun key tidak ada
                            $isAutoOpenNow = $t['is_auto_open_now'] ?? 0; 
                            $autoOpen = ($t['auto_mode'] == 1 && $isAutoOpenNow == 1);
                        ?>

                        <?php if ($autoOpen): ?>
                            <!-- AUTO MODE -->
                            <div class="text-sm text-blue-600 font-medium">
                                (Terbuka Otomatis)
                            </div>

                        <?php else: ?>
                            <!-- MANUAL TOGGLE -->
                            <a href="<?= base_url('admin/tw/toggle/' . $t['id']) ?>"
                                class="px-4 py-2 rounded-lg text-white font-semibold
                                    <?= $t['is_open_effective'] ? 'bg-red-500 hover:bg-red-600' : 'bg-green-500 hover:bg-green-600' ?>">
                                
                                <?= $t['is_open_effective'] ? 'Kunci' : 'Buka' ?>
                            </a>
                        <?php endif; ?>

                    </div>

                <?php endforeach; ?>
            </div>

        </div>
    <?php endforeach; ?>
</div>

<?= $this->endSection() ?>
