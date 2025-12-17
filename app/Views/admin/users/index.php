<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<h4 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-6">
    Manajemen User
</h4>

<a href="<?= base_url('admin/users/create'); ?>" 
   class="inline-block mb-4 bg-orange-500 hover:bg-orange-600 text-white font-medium py-2 px-4 rounded-lg shadow-md transition">
   + Tambah User
</a>

<?php if(session()->getFlashdata('success')): ?>
<div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4 shadow-sm">
    <?= session()->getFlashdata('success') ?>
</div>
<?php endif; ?>

<?php
// =============================
// GROUP USER BY UNIT KERJA
// =============================
$groupedUsers = [];

foreach ($users as $u) {
    $unit = $u['nama_bidang'] ?? 'Tanpa Unit';
    $groupedUsers[$unit][] = $u;
}
?>

<div class="space-y-6">

<?php foreach ($groupedUsers as $unitName => $unitUsers): ?>

    <!-- UNIT KERJA -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg">

        <div class="bg-blue-900 text-white px-4 py-2 rounded-t-lg font-semibold">
            📁 <?= esc($unitName) ?>
        </div>

        <div class="p-4 space-y-2">

            <?php
            // Pisahkan atasan & staff
            $atasan = [];
            $staff  = [];

            foreach ($unitUsers as $u) {
                if ($u['role'] === 'atasan') {
                    $atasan[] = $u;
                } else {
                    $staff[] = $u;
                }
            }
            ?>

            <!-- ATASAN -->
            <?php foreach ($atasan as $a): ?>
                <div class="flex items-center justify-between bg-gray-100 dark:bg-gray-700 px-4 py-2 rounded">
                    <div>
                        <div class="font-semibold text-gray-800 dark:text-gray-100">
                            👤 <?= esc($a['nama']) ?>
                        </div>
                        <div class="text-sm text-gray-500">
                            <?= esc($a['nama_jabatan']) ?> · <?= esc($a['email']) ?>
                        </div>
                    </div>
                    <span class="px-2 py-1 text-xs rounded bg-red-500 text-white">
                        Atasan
                    </span>
                </div>
            <?php endforeach; ?>

            <!-- STAFF -->
            <?php foreach ($staff as $s): ?>
                <div class="ml-8 flex items-center justify-between bg-gray-50 dark:bg-gray-600 px-4 py-2 rounded border-l-4 border-orange-400">
                    <div>
                        <div class="font-medium text-gray-800 dark:text-gray-100">
                            └─ <?= esc($s['nama']) ?>
                        </div>
                        <div class="text-sm text-gray-500">
                            <?= esc($s['nama_jabatan']) ?> · <?= esc($s['email']) ?>
                        </div>
                    </div>
                    <span class="px-2 py-1 text-xs rounded bg-gray-400 text-white">
                        Staff
                    </span>
                </div>
            <?php endforeach; ?>

        </div>

    </div>

<?php endforeach; ?>

</div>

<?= $this->endSection() ?>
