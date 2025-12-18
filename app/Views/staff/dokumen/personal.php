<?= $this->extend('layout/staff_template') ?>
<?= $this->section('content') ?>

<!-- HEADER -->
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-10">
    <div>
        <h4 class="text-2xl font-semibold text-gray-800">
            Dokumen Personal
        </h4>
        <p class="text-sm text-gray-500 mt-1">
            Arsip dokumen pribadi yang hanya dapat Anda akses
        </p>
    </div>

    <a href="<?= base_url('staff/dokumen/create') ?>"
       class="inline-flex items-center gap-2
              bg-orange-500 hover:bg-orange-600
              text-white px-5 py-2.5 rounded-xl shadow transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
             viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M12 4v16m8-8H4"/>
        </svg>
        Upload Dokumen
    </a>
</div>

<!-- EMPTY STATE -->
<?php if (empty($dokumen)): ?>
    <div class="bg-white border border-dashed rounded-2xl p-12 text-center">
        <div class="mx-auto w-16 h-16 flex items-center justify-center
                    rounded-full bg-gray-100 mb-4">
            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M12 4v16m8-8H4"/>
            </svg>
        </div>

        <p class="text-gray-700 font-medium">
            Belum ada dokumen personal
        </p>
        <p class="text-sm text-gray-500 mt-1">
            Dokumen yang Anda upload untuk kebutuhan pribadi akan muncul di sini
        </p>
    </div>

<?php else: ?>

<!-- GRID -->
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

<?php foreach ($dokumen as $d): ?>

<?php
$statusMap = [
    'pending_kaprodi'  => ['Menunggu Kaprodi', 'bg-yellow-100 text-yellow-800'],
    'pending_kajur'    => ['Menunggu Kajur', 'bg-blue-100 text-blue-800'],
    'rejected_kaprodi' => ['Ditolak Kaprodi', 'bg-red-100 text-red-800'],
    'rejected_kajur'   => ['Ditolak Kajur', 'bg-red-100 text-red-800'],
    'archived'         => ['Disetujui', 'bg-green-100 text-green-800'],
];
[$label, $class] = $statusMap[$d['status']];
?>

<!-- CARD -->
<div class="bg-white rounded-2xl border shadow-sm
            hover:shadow-md transition flex flex-col">

    <!-- HEADER -->
    <div class="p-5 border-b">
        <div class="flex items-start justify-between gap-3">
            <h5 class="font-semibold text-gray-800 line-clamp-2">
                <?= esc($d['judul']) ?>
            </h5>

            <span class="px-3 py-1 rounded-full text-xs font-medium <?= $class ?>">
                <?= $label ?>
            </span>
        </div>

        <p class="text-xs text-gray-500 mt-2">
            <?= date('d M Y', strtotime($d['created_at'])) ?>
        </p>
    </div>

    <!-- BODY -->
    <div class="p-5 flex-1">
        <p class="text-sm text-gray-600 line-clamp-3">
            <?= esc($d['deskripsi'] ?? 'Tidak ada deskripsi') ?>
        </p>

        <?php if (!empty($d['catatan'])): ?>
            <div class="mt-4 p-3 bg-red-50 border border-red-100 rounded-lg text-xs text-red-700">
                <strong>Catatan:</strong><br>
                <?= esc($d['catatan']) ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- FOOTER -->
    <div class="p-4 border-t flex items-center justify-between">

        <!-- VIEW FILE -->
        <a href="<?= base_url('uploads/dokumen/'.$d['file_path']) ?>"
           target="_blank"
           class="inline-flex items-center gap-2
                  text-sm text-gray-600 hover:text-orange-600 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Lihat File
        </a>

        <!-- ACTION -->
        <?php if (in_array($d['status'], ['rejected_kaprodi', 'rejected_kajur'])): ?>
            <a href="<?= base_url('staff/dokumen/resubmit/'.$d['id']) ?>"
               class="text-sm bg-yellow-500 hover:bg-yellow-600
                      text-white px-4 py-2 rounded-lg transition">
                Revisi
            </a>
        <?php endif; ?>
    </div>

</div>

<?php endforeach; ?>

</div>
<?php endif; ?>

<?= $this->endSection() ?>
