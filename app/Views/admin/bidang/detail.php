<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<div class="max-w-6xl mx-auto">
    <h3 class="text-2xl font-semibold text-gray-800 dark:text-gray-100 mb-6">
        Detail Bidang: <?= esc($bidang['nama_bidang']) ?>
    </h3>

    <?php if(isset($atasan) && $atasan): ?>
        <div class="mb-4 flex items-center justify-between">
            <div>
                <strong>Atasan:</strong> <?= esc($atasan['nama']) ?> (<?= esc($atasan['email'] ?? '') ?>)
            </div>
            <a href="<?= base_url('admin/bidang/detail/export/bidang/'.$bidang['id']) ?>" 
               class="px-3 py-1 border border-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition text-sm">
               Export Bidang (PDF)
            </a>
        </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <?php if(empty($pegawai)): ?>
            <div class="col-span-1 md:col-span-3">
                <div class="p-4 bg-blue-50 dark:bg-gray-700 text-blue-800 rounded-md">
                    Tidak ada pegawai di bidang ini.
                </div>
            </div>
        <?php endif; ?>

        <?php foreach($pegawai as $p): ?>
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-4 flex flex-col">
                <h5 class="text-lg font-semibold text-gray-800 dark:text-gray-100"><?= esc($p['nama']) ?></h5>
                <small class="text-gray-500 dark:text-gray-400"><?= esc($p['jabatan']) ?></small>

                <div class="mt-2">
                    <?php if($p['ranking'] == 1): ?>
                        <span class="inline-block bg-yellow-400 text-black text-xs px-2 py-1 rounded">Ranking 1 🥇</span>
                    <?php elseif($p['ranking'] == 2): ?>
                        <span class="inline-block bg-gray-400 text-black text-xs px-2 py-1 rounded">Ranking 2 🥈</span>
                    <?php elseif($p['ranking'] == 3): ?>
                        <span class="inline-block bg-red-500 text-white text-xs px-2 py-1 rounded">Ranking 3 🥉</span>
                    <?php else: ?>
                        <span class="inline-block bg-blue-500 text-white text-xs px-2 py-1 rounded">Ranking <?= $p['ranking'] ?></span>
                    <?php endif; ?>
                </div>

                <p class="mt-3 mb-1 text-sm text-gray-700 dark:text-gray-300">
                    Laporan Bulan Ini: <b><?= $p['total_laporan'] ?></b>
                </p>

                <div class="w-full bg-gray-200 dark:bg-gray-600 h-2 rounded-full mb-2">
                    <div class="bg-orange-500 h-2 rounded-full" style="width: <?= min($p['progress'],100) ?>%"></div>
                </div>
                <small class="text-gray-600 dark:text-gray-300">
                    Status: 
                    <?php if($p['status']=='Naik'): ?>
                        <span class="text-green-500 font-semibold">Naik ↑</span>
                    <?php elseif($p['status']=='Turun'): ?>
                        <span class="text-red-500 font-semibold">Turun ↓</span>
                    <?php else: ?>
                        <span class="text-gray-500 font-semibold">Stabil</span>
                    <?php endif; ?>
                </small>

                <a href="<?= base_url('admin/bidang/pegawai/'.$p['id']) ?>" 
                   class="mt-3 bg-orange-500 hover:bg-orange-600 text-white text-sm font-medium py-2 rounded transition text-center">
                   Lihat Detail
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?= $this->endSection() ?>
