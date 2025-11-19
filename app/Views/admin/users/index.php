<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-3">
    <h4 class="text-xl font-semibold text-gray-800 dark:text-gray-100">Manajemen User</h4>
    <a href="<?= base_url('admin/users/create'); ?>" 
       class="bg-orange-500 hover:bg-orange-600 text-white font-medium py-2 px-4 rounded-lg shadow-md transition w-full md:w-auto text-center">
       + Tambah User
    </a>
</div>

<?php if(session()->getFlashdata('success')): ?>
<div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4 shadow-sm">
    <?= session()->getFlashdata('success') ?>
</div>
<?php endif; ?>

<div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
        <thead class="bg-blue-900 text-white">
            <tr>
                <th class="px-4 py-2 text-left text-sm font-medium">No</th>
                <th class="px-4 py-2 text-left text-sm font-medium">Nama</th>
                <th class="px-4 py-2 text-left text-sm font-medium">Email</th>
                <th class="px-4 py-2 text-left text-sm font-medium">Jabatan</th>
                <th class="px-4 py-2 text-left text-sm font-medium">Bidang</th>
                <th class="px-4 py-2 text-left text-sm font-medium">Role</th>
                <th class="px-4 py-2 text-left text-sm font-medium">Aksi</th>
            </tr>
        </thead>

        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
            <?php $no=1; foreach($users as $u): ?>
            <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                <td class="px-4 py-2 text-sm"><?= $no++ ?></td>
                <td class="px-4 py-2 text-sm"><?= esc($u['nama']) ?></td>
                <td class="px-4 py-2 text-sm"><?= esc($u['email']) ?></td>
                <td class="px-4 py-2 text-sm"><?= esc($u['nama_jabatan']) ?></td>
                <td class="px-4 py-2 text-sm"><?= esc($u['nama_bidang']) ?></td>
                <td class="px-4 py-2 text-sm"><?= esc($u['role']) ?></td>
                <td class="px-4 py-2 text-sm flex flex-wrap gap-2">
                    <a href="<?= base_url('admin/users/edit/'.$u['id']) ?>" 
                       class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded-md text-sm transition flex-1 text-center md:flex-none">
                       Edit
                    </a>
                    <a href="<?= base_url('admin/users/delete/'.$u['id']) ?>" 
                       onclick="return confirm('Hapus user ini?')" 
                       class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md text-sm transition flex-1 text-center md:flex-none">
                       Hapus
                    </a>
                </td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
