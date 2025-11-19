<?= $this->extend('layout/atasan_template') ?>
<?= $this->section('content') ?>

<h3 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-100">Laporan Masuk</h3>

<?php if(session()->getFlashdata('success')): ?>
<div class="bg-green-100 text-green-800 px-4 py-3 rounded mb-4 shadow">
    <?= session()->getFlashdata('success') ?>
</div>
<?php endif; ?>

<div class="bg-white shadow rounded-lg overflow-x-auto p-4">

<table class="min-w-full divide-y divide-gray-200">
    <thead class="bg-[var(--polban-blue)] text-white">
        <tr>
            <th class="px-4 py-2 text-left text-sm font-medium">No</th>
            <th class="px-4 py-2 text-left text-sm font-medium">Nama Staff</th>
            <th class="px-4 py-2 text-left text-sm font-medium">Judul</th>
            <th class="px-4 py-2 text-left text-sm font-medium">Tanggal</th>
            <th class="px-4 py-2 text-left text-sm font-medium">Status</th>
            <th class="px-4 py-2 text-left text-sm font-medium">Aksi</th>
        </tr>
    </thead>

    <tbody class="divide-y divide-gray-200">
    <?php $no=1; foreach($laporan as $l): 
        $user = model('UserModel')->find($l['user_id']);
    ?>
        <tr class="hover:bg-gray-50">
            <td class="px-4 py-2 text-sm"><?= $no++ ?></td>
            <td class="px-4 py-2 text-sm"><?= esc($user['nama']) ?></td>
            <td class="px-4 py-2 text-sm"><?= esc($l['judul']) ?></td>
            <td class="px-4 py-2 text-sm"><?= esc($l['tanggal']) ?></td>
            <td class="px-4 py-2 text-sm">
                <?php if($l['status']=='pending'): ?>
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-gray-300 text-gray-800">Pending</span>
                <?php elseif($l['status']=='approved'): ?>
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-green-500 text-white">Diterima</span>
                <?php else: ?>
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-red-500 text-white">Ditolak</span>
                <?php endif; ?>
            </td>
            <td class="px-4 py-2 text-sm">
                <a href="<?= base_url('atasan/laporan/detail/'.$l['id']) ?>" 
                   class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm font-medium transition-all">
                   Detail
                </a>
            </td>
        </tr>
    <?php endforeach ?>
    </tbody>
</table>

</div>

<?= $this->endSection() ?>
