<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<div class="max-w-6xl mx-auto">
    <h3 class="text-2xl font-semibold text-gray-800 dark:text-gray-100 mb-6">
        <?= esc($pegawai['nama']) ?> — Detail Kinerja
    </h3>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <!-- Profil Pegawai -->
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-5 flex flex-col">
            <h5 class="text-lg font-semibold mb-3">Profil</h5>

            <p class="text-gray-700 dark:text-gray-300"><b>Nama:</b> <?= esc($pegawai['nama']) ?></p>
            <p class="text-gray-700 dark:text-gray-300"><b>Jabatan:</b> <?= esc($pegawai['nama_jabatan']) ?></p>
            <p class="text-gray-700 dark:text-gray-300"><b>Bidang:</b> <?= esc($pegawai['nama_bidang']) ?></p>

            <hr class="my-3 border-gray-300 dark:border-gray-600">

            <p class="text-gray-700 dark:text-gray-300"><b>Diterima:</b> <?= $approved ?></p>
            <p class="text-gray-700 dark:text-gray-300"><b>Ditolak:</b> <?= $rejected ?></p>
            <p class="text-gray-700 dark:text-gray-300"><b>Progress:</b> <?= $progress ?>%</p>
            <p class="text-gray-700 dark:text-gray-300"><b>Total Jam Kerja:</b> 
                <?php if($hours > 0): ?>
                    <?= floor($hours/60) ?> jam <?= $hours % 60 ?> menit
                <?php else: ?>
                    -
                <?php endif; ?>
            </p>

            <a href="<?= base_url('admin/bidang/detail/export/'.$pegawai['id']) ?>" 
               class="mt-3 bg-orange-500 hover:bg-orange-600 text-white font-medium py-2 rounded text-center transition">
               Export PDF Pegawai
            </a>
        </div>

        <!-- Riwayat Laporan -->
        <div class="md:col-span-2 bg-white dark:bg-gray-800 shadow-md rounded-lg p-5">
            <h5 class="text-lg font-semibold mb-3">Riwayat Laporan Bulan Ini</h5>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-blue-800 text-white">
                        <tr>
                            <th class="px-3 py-2 text-left text-sm font-medium">Judul</th>
                            <th class="px-3 py-2 text-left text-sm font-medium">Tanggal</th>
                            <th class="px-3 py-2 text-left text-sm font-medium">Status</th>
                            <th class="px-3 py-2 text-left text-sm font-medium">Catatan Atasan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        <?php if(empty($laporan)): ?>
                            <tr>
                                <td colspan="4" class="px-3 py-2 text-center text-gray-500 dark:text-gray-400">
                                    Belum ada laporan.
                                </td>
                            </tr>
                        <?php endif; ?>
                        <?php foreach($laporan as $l): ?>
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-3 py-2 text-gray-700 dark:text-gray-300"><?= esc($l['judul']) ?></td>
                                <td class="px-3 py-2 text-gray-700 dark:text-gray-300"><?= esc($l['tanggal']) ?></td>
                                <td class="px-3 py-2">
                                    <?php if($l['status']=='approved'): ?>
                                        <span class="inline-block bg-green-500 text-white text-xs px-2 py-1 rounded">Diterima</span>
                                    <?php elseif($l['status']=='pending'): ?>
                                        <span class="inline-block bg-gray-400 text-white text-xs px-2 py-1 rounded">Pending</span>
                                    <?php else: ?>
                                        <span class="inline-block bg-red-500 text-white text-xs px-2 py-1 rounded">Ditolak</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-3 py-2 text-gray-700 dark:text-gray-300">
                                    <?= esc($l['catatan_atasan'] ?: '-') ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<?= $this->endSection() ?>
