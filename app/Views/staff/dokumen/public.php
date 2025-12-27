<?= $this->extend('layout/staff_template') ?>
<?= $this->section('content') ?>

<!-- HEADER -->
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-10">
    <div>
        <h4 class="text-2xl font-semibold text-gray-800">
            Dokumen Publik
        </h4>
        <p class="text-sm text-gray-500 mt-1">
            Arsip dokumen resmi yang dapat diakses oleh seluruh unit kerja
        </p>
    </div>
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
            Belum ada dokumen publik
        </p>
        <p class="text-sm text-gray-500 mt-1">
            Dokumen yang telah dipublikasikan akan muncul di sini
        </p>
    </div>

<?php else: ?>

<!-- GRID -->
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

<?php foreach ($dokumen as $d): ?>

<?php
    // PUBLIC → selalu archived
    $statusClass = 'bg-green-100 text-green-700';
    $statusText  = 'Publik';
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

            <span class="px-3 py-1 rounded-full text-xs font-medium <?= $statusClass ?>">
                <?= $statusText ?>
            </span>
        </div>

        <p class="text-xs text-gray-500 mt-2">
            <?= date('d M Y', strtotime($d['created_at'])) ?>
        </p>
    </div>

    <!-- BODY -->
    <div class="p-5 flex-1 space-y-3">

        <p class="text-sm text-gray-600 line-clamp-3">
            <?= esc($d['deskripsi'] ?? 'Tidak ada deskripsi') ?>
        </p>

        <!-- METADATA (SAMA PERSIS DENGAN UNIT) -->
        <div class="flex flex-wrap gap-4 text-sm text-gray-500">

            <span>
                <strong>Kategori:</strong>
                <?= esc($d['nama_kategori'] ?? '-') ?>
            </span>

            <span>
                <strong>Pengirim:</strong>
                <?= esc($d['nama_pengirim'] ?? '-') ?>
            </span>

            <span>
                <strong>Jabatan:</strong>
                <?= esc($d['nama_jabatan'] ?? '-') ?>
            </span>

            <span>
                <strong>Unit:</strong>
                <?= esc($d['nama_unit'] ?? '-') ?>
            </span>

        </div>

    </div>

    <!-- FOOTER -->
    <div class="p-4 border-t flex justify-end">

        <a href="<?= base_url('uploads/dokumen/'.$d['file_path']) ?>"
           target="_blank"
           class="inline-flex items-center gap-2
                  bg-gray-100 hover:bg-gray-200
                  text-gray-700 px-4 py-2
                  rounded-xl text-sm transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Lihat Dokumen
        </a>

    </div>

</div>

<?php endforeach; ?>

</div>
<?php endif; ?>

<?= $this->endSection() ?>
