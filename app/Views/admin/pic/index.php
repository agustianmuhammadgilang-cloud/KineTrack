<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<h3 class="text-2xl font-bold text-[var(--polban-blue)] mb-6">Daftar PIC</h3>

<!-- Flash Message -->
<?php if(session()->getFlashdata('success')): ?>
<div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded mb-6 shadow">
    <?= session()->getFlashdata('success') ?>
</div>
<?php endif; ?>

<!-- Tambah PIC Button -->
<div class="mb-4">
    <a href="<?= base_url('admin/pic/create') ?>" 
       class="bg-[var(--polban-orange)] hover:bg-orange-600 text-white font-semibold px-4 py-2 rounded shadow transition-all">
       Tambah PIC Baru
    </a>
</div>

<!-- Table -->
<div class="overflow-x-auto bg-white dark:bg-gray-800 shadow rounded-lg">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
        <thead class="bg-[var(--polban-blue)] text-white">
            <tr>
                <th class="px-4 py-2 text-left text-sm font-semibold">ID</th>
                <th class="px-4 py-2 text-left text-sm font-semibold">Indikator</th>
                <th class="px-4 py-2 text-left text-sm font-semibold">PIC</th>
                <th class="px-4 py-2 text-left text-sm font-semibold">Bidang / Jabatan</th>
                <th class="px-4 py-2 text-left text-sm font-semibold">Tahun</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
            <?php foreach($pic_list as $p): ?>
            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                <td class="px-4 py-2 text-sm"><?= esc($p['id']) ?></td>
                <td class="px-4 py-2 text-sm"><?= esc($p['indikator_id']) ?></td>
                <td class="px-4 py-2 text-sm"><?= esc($p['user_id']) ?></td>
                <td class="px-4 py-2 text-sm"><?= esc($p['bidang_id']) ?> / <?= esc($p['jabatan_id']) ?></td>
                <td class="px-4 py-2 text-sm"><?= esc($p['tahun_id']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
