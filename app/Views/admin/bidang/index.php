<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
    <h4 class="text-xl font-semibold text-gray-800 dark:text-gray-100">Manajemen Unit Kerja</h4>
    <a href="<?= base_url('admin/bidang/create'); ?>" 
       class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-md font-medium shadow transition w-full sm:w-auto text-center">
       + Tambah Unit Kerja
    </a>
</div>

<?php if(session()->getFlashdata('success')): ?>
<div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
    <?= session()->getFlashdata('success') ?>
</div>
<?php endif; ?>

<div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
        <thead class="bg-blue-900 text-white">
            <tr>
                <th class="px-4 py-2 text-left w-16">No</th>
                <th class="px-4 py-2 text-left">Nama Unit Kerja</th>
                <th class="px-4 py-2 w-48 text-center">Tipe</th>
                <th class="px-4 py-2 w-48 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
    <?php $no = 1; ?>
    <?php foreach($jurusan as $j): ?>
        <!-- Jurusan -->
        <tr class="bg-gray-100 dark:bg-gray-700 font-semibold">
            <td class="px-4 py-2"><?= $no++ ?></td>
            <td class="px-4 py-2"><?= esc($j['nama_bidang']) ?></td>
            <td class="px-4 py-2 text-center">Jurusan</td>
            <td class="px-4 py-2 flex flex-col sm:flex-row justify-center gap-2">
                <a href="<?= base_url('admin/bidang/edit/'.$j['id']) ?>" 
                   class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-md text-sm font-medium text-center transition">
                   Edit
                </a>
                <a href="<?= base_url('admin/bidang/delete/'.$j['id']) ?>" 
                   onclick="return confirm('Hapus unit kerja ini?')" 
                   class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md text-sm font-medium text-center transition">
                   Hapus
                </a>
            </td>
        </tr>

        <!-- Prodi -->
        <?php foreach($prodi as $p): ?>
            <?php if($p['parent_id'] == $j['id']): ?>
            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                <td class="px-4 py-2"></td>
                <td class="px-8 py-2 font-normal text-gray-700 dark:text-gray-300">↳ <?= esc($p['nama_bidang']) ?></td>
                <td class="px-4 py-2 text-center">Prodi</td>
                <td class="px-4 py-2 flex flex-col sm:flex-row justify-center gap-2">
                    <a href="<?= base_url('admin/bidang/edit/'.$p['id']) ?>" 
                       class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-md text-sm font-medium text-center transition">
                       Edit
                    </a>
                    <a href="<?= base_url('admin/bidang/delete/'.$p['id']) ?>" 
                       onclick="return confirm('Hapus unit kerja ini?')" 
                       class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md text-sm font-medium text-center transition">
                       Hapus
                    </a>
                </td>
            </tr>
            <?php endif; ?>
        <?php endforeach; ?>

    <?php endforeach; ?>
        </tbody>
        
    </table>
</div>

<?= $this->endSection() ?>
