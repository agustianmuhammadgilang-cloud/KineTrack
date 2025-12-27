<?= $this->extend('layout/staff_template') ?>
<?= $this->section('content') ?>

<!-- HEADER -->
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-10">
    <div>
        <h4 class="text-2xl font-semibold text-gray-800">
            Dokumen Publik
        </h4>
        <p class="text-sm text-gray-500 mt-1">
            Dokumen resmi yang dapat diakses oleh seluruh unit
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

<!-- CARD -->
<div class="bg-white rounded-2xl border shadow-sm
            hover:shadow-md transition flex flex-col">

    <!-- HEADER -->
    <div class="p-5 border-b">
        <h5 class="font-semibold text-gray-800 line-clamp-2">
            <?= esc($d['judul']) ?>
        </h5>

        <div class="mt-2 flex flex-wrap gap-2 text-xs text-gray-500">
            <span class="bg-gray-100 px-2 py-1 rounded">
                <?= esc($d['nama_unit'] ?? '-') ?>
            </span>
            <span class="bg-gray-100 px-2 py-1 rounded">
                Tahun <?= date('Y', strtotime($d['created_at'])) ?>
            </span>
        </div>
    </div>

    <!-- BODY -->
    <div class="p-5 flex-1">
        <p class="text-sm text-gray-600 line-clamp-3">
            <?= esc($d['deskripsi'] ?? 'Tidak ada deskripsi') ?>
        </p>
    </div>

    <!-- FOOTER -->
    <div class="p-4 border-t flex items-center justify-between text-sm">

        <!-- PUBLISH DATE -->
        <span class="text-xs text-gray-500">
            <?= $d['published_at']
                ? 'Publish: '.date('d M Y', strtotime($d['published_at']))
                : 'Belum dipublish' ?>
        </span>

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
    </div>

</div>

<?php endforeach; ?>

</div>
<?php endif; ?>

<?= $this->endSection() ?>
