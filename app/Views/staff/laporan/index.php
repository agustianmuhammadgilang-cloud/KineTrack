<?= $this->extend('layout/staff_template') ?>
<?= $this->section('content') ?>

<h3 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-100">
    Dashboard Staff
</h3>

<!-- Informasi Profil -->
<div class="bg-white dark:bg-gray-800 shadow rounded-xl p-6 mb-6 transition-all">
    <h5 class="text-lg font-semibold mb-3 text-gray-700 dark:text-gray-200">
        Informasi Anda
    </h5>

    <div class="space-y-1 text-gray-700 dark:text-gray-300">
        <p><span class="font-medium">Nama:</span> <?= esc($staff['nama']) ?></p>
        <p><span class="font-medium">Jabatan:</span> <?= esc($staff['nama_jabatan']) ?></p>
        <p><span class="font-medium">Bidang:</span> <?= esc($staff['nama_bidang']) ?></p>
    </div>

    <a href="<?= base_url('staff/profile') ?>" 
       class="mt-4 inline-block bg-orange-500 hover:bg-orange-600 text-white font-semibold px-4 py-2 rounded-lg shadow transition-all">
       Pengaturan Profil
    </a>
</div>

<!-- Header Laporan -->
<div class="flex flex-col sm:flex-row justify-between sm:items-center gap-3 mb-4">
    <h4 class="text-xl font-semibold text-gray-700 dark:text-gray-200">
        Laporan Saya
    </h4>

    <a href="<?= base_url('staff/laporan/create'); ?>" 
       class="bg-green-500 hover:bg-green-600 text-white font-semibold px-4 py-2 rounded-lg shadow transition-all text-center">
       + Buat Laporan
    </a>
</div>

<!-- Flash Message -->
<?php if(session()->getFlashdata('success')): ?>
<div class="bg-green-100 border border-green-300 text-green-800 p-4 rounded-lg mb-4 shadow">
    <?= session()->getFlashdata('success') ?>
</div>
<?php endif; ?>

<!-- Tabel Responsive -->
<div class="bg-white dark:bg-gray-800 shadow rounded-xl p-4 transition-all overflow-x-auto">
    <table class="min-w-full table-auto border-collapse">
        <thead class="bg-blue-800 text-white text-sm">
            <tr>
                <th class="px-4 py-2 text-left">#</th>
                <th class="px-4 py-2 text-left">Judul</th>
                <th class="px-4 py-2 text-left">Tanggal</th>
                <th class="px-4 py-2 text-left">Status</th>
                <th class="px-4 py-2 text-left">Bukti</th>
                <th class="px-4 py-2 text-left">Aksi</th>
            </tr>
        </thead>

        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
            <?php $no=1; foreach($laporan as $l): ?>
            <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                <td class="px-4 py-2"><?= $no++ ?></td>
                <td class="px-4 py-2"><?= esc($l['judul']) ?></td>
                <td class="px-4 py-2"><?= $l['tanggal'] ?></td>

                <!-- Status -->
                <td class="px-4 py-2">
                    <?php if($l['status']=='pending'): ?>
                        <span class="bg-gray-400 text-white px-2 py-1 rounded text-sm">Pending</span>
                    <?php elseif($l['status']=='approved'): ?>
                        <span class="bg-green-500 text-white px-2 py-1 rounded text-sm">Diterima</span>
                    <?php else: ?>
                        <span class="bg-red-500 text-white px-2 py-1 rounded text-sm">Ditolak</span>
                    <?php endif; ?>
                </td>

                <!-- File Bukti -->
                <td class="px-4 py-2">
                    <?php if($l['file_bukti']): ?>
                        <a href="<?= base_url('uploads/bukti/'.$l['file_bukti']) ?>" target="_blank" 
                           class="bg-blue-500 hover:bg-blue-600 text-white text-xs px-3 py-1 rounded transition-all">
                           View
                        </a>
                    <?php else: ?>
                        <span class="text-gray-400 text-xs">-</span>
                    <?php endif ?>
                </td>

                <!-- Aksi -->
                <td class="px-4 py-2">
                    <?php if($l['status']=='rejected'): ?>
                        <a href="<?= base_url('staff/laporan/rejected/'.$l['id']) ?>" 
                           class="bg-yellow-500 hover:bg-yellow-600 text-white text-xs px-3 py-1 rounded transition-all">
                           Lihat
                        </a>
                    <?php else: ?>
                        <span class="text-gray-400 text-xs">-</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
