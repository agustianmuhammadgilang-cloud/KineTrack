<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4 md:gap-0">
    <h4 class="text-xl font-semibold text-gray-800 dark:text-gray-100">Manajemen Jabatan</h4>
    <a href="<?= base_url('admin/jabatan/create'); ?>" 
       class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-md font-medium shadow transition text-center w-full md:w-auto">
       + Tambah Jabatan
    </a>
</div>

<?php if(session()->getFlashdata('success')): ?>
<div class="bg-green-100 text-green-800 px-4 py-2 rounded-md mb-4">
    <?= session()->getFlashdata('success') ?>
</div>
<?php endif; ?>

<div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-x-auto">
    <table class="min-w-[400px] w-full table-auto divide-y divide-gray-200 dark:divide-gray-700">
        <thead class="bg-blue-900 dark:bg-blue-700 text-white">
            <tr>
                <th class="px-4 py-2 text-left w-16">No</th>
                <th class="px-4 py-2 text-left">Nama Jabatan</th>
                <th class="px-4 py-2 w-44 text-left">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
            <?php $no=1; foreach($jabatan as $j): ?>
            <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                <td class="px-4 py-2"><?= $no++ ?></td>
                <td class="px-4 py-2"><?= esc($j['nama_jabatan']) ?></td>
                <td class="px-4 py-2 flex flex-col sm:flex-row gap-2">
                    <a href="<?= base_url('admin/jabatan/edit/'.$j['id']) ?>" 
                       class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded-md text-sm text-center transition">
                       Edit
                    </a>
                    <a href="<?= base_url('admin/jabatan/delete/'.$j['id']) ?>" 
                       onclick="return confirm('Hapus jabatan ini?')" 
                       class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md text-sm text-center transition">
                       Hapus
                    </a>
                </td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
