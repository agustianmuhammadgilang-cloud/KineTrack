<?= $this->extend('layout/staff_template') ?>
<?= $this->section('content') ?>

<h3 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-100">Dashboard Staff</h3>

<!-- Informasi Profil Staff -->
<div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mb-6 transition-colors">
    <h5 class="text-lg font-semibold mb-3 text-gray-700 dark:text-gray-200">Informasi Anda</h5>
    <p><span class="font-medium">Nama:</span> <?= esc($staff['nama']) ?></p>
    <p><span class="font-medium">Jabatan:</span> <?= esc($staff['nama_jabatan']) ?></p>
    <p><span class="font-medium">Bidang:</span> <?= esc($staff['nama_bidang']) ?></p>

    <a href="<?= base_url('staff/profile') ?>" 
       class="mt-4 inline-block bg-orange-500 hover:bg-orange-600 text-white font-semibold px-4 py-2 rounded shadow transition-all">
       Pengaturan Profil
    </a>
</div>

<!-- Laporan Staff -->
<div class="flex justify-between items-center mb-4">
    <h4 class="text-xl font-semibold text-gray-700 dark:text-gray-200">Laporan Saya</h4>
    <a href="<?= base_url('staff/laporan/create'); ?>" 
       class="bg-green-500 hover:bg-green-600 text-white font-semibold px-4 py-2 rounded shadow transition-all">
       + Buat Laporan
    </a>
</div>

<?php if(session()->getFlashdata('success')): ?>
<div class="bg-green-100 text-green-800 p-4 rounded-lg mb-4 shadow">
    <?= session()->getFlashdata('success') ?>
</div>
<?php endif; ?>

<div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4 overflow-x-auto transition-colors">
    <table class="min-w-full table-auto">
        <thead class="bg-blue-800 text-white">
            <tr>
                <th class="px-4 py-2">#</th>
                <th class="px-4 py-2">Judul</th>
                <th class="px-4 py-2">Tanggal</th>
                <th class="px-4 py-2">Status</th>
                <th class="px-4 py-2">Bukti</th>
                <th class="px-4 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
            <?php $no=1; foreach($laporan as $l): ?>
            <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                <td class="px-4 py-2"><?= $no++ ?></td>
                <td class="px-4 py-2"><?= esc($l['judul']) ?></td>
                <td class="px-4 py-2"><?= $l['tanggal'] ?></td>

                <td class="px-4 py-2">
                    <?php if($l['status']=='pending'): ?>
                        <span class="bg-gray-400 text-white px-2 py-1 rounded text-sm">Pending</span>
                    <?php elseif($l['status']=='approved'): ?>
                        <span class="bg-green-500 text-white px-2 py-1 rounded text-sm">Diterima</span>
                    <?php else: ?>
                        <span class="bg-red-500 text-white px-2 py-1 rounded text-sm">Ditolak</span>
                    <?php endif; ?>
                </td>

                <td class="px-4 py-2">
                    <?php if($l['file_bukti']): ?>
                        <a href="<?= base_url('uploads/bukti/'.$l['file_bukti']) ?>" target="_blank" 
                           class="bg-blue-500 hover:bg-blue-600 text-white text-xs px-2 py-1 rounded transition-all">View</a>
                    <?php else: ?>
                        <span class="text-gray-400 text-xs">-</span>
                    <?php endif ?>
                </td>

                <td class="px-4 py-2">
                    <?php if($l['status']=='rejected'): ?>
                        <a href="<?= base_url('staff/laporan/rejected/'.$l['id']) ?>" 
                           class="bg-yellow-500 hover:bg-yellow-600 text-white text-xs px-2 py-1 rounded transition-all">Lihat</a>
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
