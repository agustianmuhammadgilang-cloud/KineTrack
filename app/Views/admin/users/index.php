<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<h4 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-6">
    Manajemen User
</h4>

<a href="<?= base_url('admin/users/create'); ?>" 
   class="inline-block mb-4 bg-orange-500 hover:bg-orange-600 text-white font-medium py-2 px-4 rounded-lg shadow-md transition">
   + Tambah User
</a>

<a href="<?= base_url('admin/users/export-pdf') ?>"
   class="inline-block mb-4 ml-2 bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg shadow-md transition">
   ⬇ Export PDF
</a>


<!-- NOTIFIKASI (TAMBAHAN, TANPA UBAH LOGIKA FORM) -->
<?php if (session()->getFlashdata('error')): ?>
    <div class="mb-4 p-3 rounded-lg bg-red-100 text-red-700 font-semibold">
        <?= session()->getFlashdata('error') ?>
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

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg">

        <div class="bg-blue-900 text-white px-4 py-2 rounded-t-lg font-semibold">
            📁 <?= esc($unitName) ?>
        </div>

        <div class="p-4 space-y-2">

            <?php
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

                    <div class="flex items-center gap-2">
                        <span class="px-2 py-1 text-xs rounded bg-red-500 text-white">
                            Atasan
                        </span>

                        <?php if ($a['role'] !== 'admin'): ?>
                            <a href="<?= base_url('admin/users/edit/'.$a['id']) ?>"
                               class="text-xs bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded">
                                Edit
                            </a>

                            <form action="<?= base_url('admin/users/delete/'.$a['id']) ?>" 
                                  method="post" 
                                  onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                <?= csrf_field() ?>
                                <button type="submit"
                                        class="text-xs bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">
                                    Hapus
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
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

                    <div class="flex items-center gap-2">
                        <span class="px-2 py-1 text-xs rounded bg-gray-400 text-white">
                            Staff
                        </span>

                        <?php if ($s['role'] !== 'admin'): ?>
                            <a href="<?= base_url('admin/users/edit/'.$s['id']) ?>"
                               class="text-xs bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded">
                                Edit
                            </a>

                            <form action="<?= base_url('admin/users/delete/'.$s['id']) ?>" 
                                  method="post"
                                  onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                <?= csrf_field() ?>
                                <button type="submit"
                                        class="text-xs bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">
                                    Hapus
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>

        </div>
    </div>

<?php endforeach; ?>

</div>

<?= $this->endSection() ?>
