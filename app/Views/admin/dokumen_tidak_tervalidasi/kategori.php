<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<!-- HEADER -->
<div class="mb-8">
    <h1 class="text-2xl font-bold text-red-700 flex items-center gap-3">
        <!-- Icon Warning Folder -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500"
             fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                  d="M3 7h4l2 3h10a2 2 0 012 2v5a2 2 0 01-2 2H3V7z"/>
        </svg>
        Dokumen Tidak Tervalidasi
    </h1>

    <p class="text-sm text-gray-500 mt-1">
        Dokumen yang sudah disetujui Ketua Jurusan namun kategorinya belum disahkan admin
    </p>
</div>

<!-- GRID -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

<?php if (empty($kategori)): ?>
    <div class="col-span-full bg-white rounded-2xl border border-dashed p-10 text-center text-gray-400">
        Belum ada dokumen tidak tervalidasi
    </div>
<?php endif ?>

<?php foreach ($kategori as $k): ?>
<a href="<?= base_url('admin/dokumen-tidak-tervalidasi/' . $k['id']) ?>"
   class="group bg-white rounded-3xl shadow-md hover:shadow-2xl transition 
          border border-red-100 hover:border-red-400/40 p-6 relative overflow-hidden">

    <div class="absolute top-0 right-0 w-20 h-20 bg-red-100 rounded-bl-full"></div>

    <div class="flex items-center justify-center w-12 h-12 rounded-xl
                bg-red-100 text-red-600 mb-4">
        📁
    </div>

    <h2 class="text-lg font-semibold text-gray-800">
        <?= esc($k['nama_kategori']) ?>
    </h2>

    <p class="text-sm text-gray-500 mt-1">
        <?= esc($k['deskripsi']) ?: 'Kategori belum tervalidasi admin' ?>
    </p>

    <div class="mt-6 flex items-center justify-between">
        <span class="text-xs text-gray-400">
            ID: <?= $k['id'] ?>
        </span>

        <span class="inline-flex items-center gap-1 text-xs font-semibold
                     bg-red-500 text-white px-3 py-1 rounded-full">
            <?= $k['total'] ?> Dokumen
        </span>
    </div>
</a>
<?php endforeach ?>

</div>

<?= $this->endSection() ?>
