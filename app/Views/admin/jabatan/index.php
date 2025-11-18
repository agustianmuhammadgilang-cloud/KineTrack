<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<div class="flex justify-between items-center mb-6">
    <h4 class="text-xl font-semibold text-gray-800 dark:text-gray-100">Manajemen Jabatan</h4>
    <a href="<?= base_url('admin/jabatan/create'); ?>" 
       class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-md font-medium shadow transition">
       + Tambah Jabatan
    </a>
</div>

<?php if(session()->getFlashdata('success')): ?>
<div class="bg-green-100 text-green-800 px-4 py-2 rounded-md mb-4">
    <?= session()->getFlashdata('success') ?>
</div>
<?php endif; ?>

<div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-x-auto">
    <table class="min-w-full table-auto divide-y divide-gray-200 dark:divide-gray-700">
        <thead class="bg-blue-900 dark:bg-blue-700 text-white">
            <tr>
                <th class="px-4 py-2 text-left w-16">No</th>
                <th class="px-4 py-2 text-left">Nama Jabatan</th>
                <th class="px-4 py-2 w-44 text-left">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
            <?php $no=1; foreach($jabatan as $j): ?>
            <tr>
                <td class="px-4 py-2"><?= $no++ ?></td>
                <td class="px-4 py-2"><?= esc($j['nama_jabatan']) ?></td>
                <td class="px-4 py-2 flex gap-2">
                    <a href="<?= base_url('admin/jabatan/edit/'.$j['id']) ?>" 
                       class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded-md text-sm transition">
                       Edit
                    </a>
                    <a href="<?= base_url('admin/jabatan/delete/'.$j['id']) ?>" 
                       onclick="return confirm('Hapus jabatan ini?')" 
                       class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md text-sm transition">
                       Hapus
                    </a>
                </td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
