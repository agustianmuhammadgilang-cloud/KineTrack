<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<!-- HEADER -->
<div class="mb-8">
    <h1 class="text-2xl font-bold text-[#1D2F83] flex items-center gap-3">
        <!-- Heroicon Folder Open -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#F58025]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M3 7h4l2 3h10a2 2 0 012 2v5a2 2 0 01-2 2H3V7z"/>
        </svg>
        Dokumen Tervalidasi
    </h1>
    <p class="text-sm text-gray-500 mt-1">
        Daftar kategori dokumen yang telah tervalidasi dan siap diakses
    </p>
</div>

<!-- GRID -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

<?php if (empty($kategori)): ?>
    <div class="col-span-full bg-white rounded-2xl border border-dashed p-10 text-center text-gray-400">
        <!-- Heroicon Inbox -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto mb-4 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M20 13V5a2 2 0 00-2-2H6a2 2 0 00-2 2v8m16 0l-2 5H6l-2-5m16 0H4"/>
        </svg>
        Belum ada dokumen tervalidasi
    </div>
<?php endif ?>

<?php foreach ($kategori as $k): ?>

    <!-- CARD -->
    <a href="<?= base_url('admin/dokumen-tervalidasi/' . $k['id']) ?>"
       class="group bg-white rounded-3xl shadow-md hover:shadow-2xl transition 
              border border-gray-100 hover:border-[#1D2F83]/40 p-6 relative overflow-hidden transform hover:-translate-y-1 duration-300">

        <!-- Decorative Accent -->
        <div class="absolute top-0 right-0 w-20 h-20 bg-[#1D2F83]/5 rounded-bl-full"></div>

        <!-- Icon -->
        <div class="flex items-center justify-center w-12 h-12 rounded-xl
                    bg-[#1D2F83]/10 text-[#1D2F83] mb-4">
            <!-- Heroicon Document -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12h6m-6 4h6m2 4H7a2 2 0 01-2-2V6a2 2 0 012-2h7l5 5v11a2 2 0 01-2 2z"/>
            </svg>
        </div>

        <!-- Title -->
        <h2 class="text-lg font-semibold text-gray-800 group-hover:text-[#1D2F83] transition">
            <?= esc($k['nama_kategori']) ?>
        </h2>

        <!-- Description -->
        <p class="text-sm text-gray-500 mt-1 line-clamp-2">
            <?= esc($k['deskripsi']) ?: 'Tidak ada deskripsi kategori' ?>
        </p>

        <!-- Footer -->
        <div class="mt-6 flex items-center justify-between">
            <span class="text-xs text-gray-400">
                ID Kategori: <?= $k['id'] ?>
            </span>

            <span class="inline-flex items-center gap-1 text-xs font-semibold
                         bg-[#F58025] text-white px-3 py-1 rounded-full">
                <?= $k['total'] ?> Dokumen
            </span>
        </div>

        <!-- Hover Indicator -->
        <div class="absolute inset-x-0 bottom-0 h-1 bg-[#F58025] scale-x-0 
                    group-hover:scale-x-100 transition-transform origin-left"></div>
    </a>

<?php endforeach ?>

</div>

<?= $this->endSection() ?>
