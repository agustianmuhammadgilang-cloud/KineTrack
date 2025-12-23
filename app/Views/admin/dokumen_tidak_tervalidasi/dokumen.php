<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<a href="<?= base_url('admin/dokumen-tidak-tervalidasi') ?>"
   class="inline-flex items-center gap-1 text-sm text-red-700 hover:text-red-500 mb-5">
    ← Kembali ke kategori
</a>

<div class="mb-6">
    <h1 class="text-3xl font-extrabold text-red-700">
        <?= esc($kategori['nama_kategori']) ?>
        <span class="ml-2 px-2 py-1 text-xs font-semibold text-white bg-red-500 rounded-full">
            <?= count($dokumen) ?> Dokumen
        </span>
    </h1>

    <p class="text-sm text-gray-500 mt-1">
        Dokumen disetujui Kajur namun kategori belum divalidasi admin
    </p>
</div>

<div class="grid gap-4">

<?php if (empty($dokumen)): ?>
    <div class="bg-white rounded-3xl shadow-xl p-10 text-center text-gray-400 italic">
        Tidak ada dokumen pada kategori ini
    </div>
<?php endif ?>

<?php foreach ($dokumen as $d): ?>
<div class="bg-white rounded-3xl shadow-lg p-6 border border-gray-100">
    <div class="flex justify-between items-center">

        <div>
            <div class="text-lg font-semibold"><?= esc($d['judul']) ?></div>
            <div class="text-sm text-gray-500">
                Unit: <?= esc($d['nama_bidang'] ?? '-') ?> |
                ACC: <?= date('d M Y', strtotime($d['updated_at'])) ?>
            </div>
        </div>

        <a href="<?= base_url('uploads/dokumen/' . $d['file_path']) ?>"
           target="_blank"
           class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg">
            Lihat
        </a>

    </div>
</div>
<?php endforeach ?>

</div>

<?= $this->endSection() ?>
