<?= $this->extend('layout/atasan_template') ?>
<?= $this->section('content') ?>

<h3 class="text-2xl font-bold text-[var(--polban-blue)] mb-6">
    Dokumen Unit
</h3>

<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

<?php if (empty($dokumen)): ?>
    <div class="col-span-full text-center text-gray-500">
        Tidak ada dokumen unit.
    </div>
<?php endif; ?>

<?php foreach ($dokumen as $d): ?>

<?php
    $statusClass = $d['status'] === 'archived'
        ? 'bg-green-100 text-green-700'
        : 'bg-yellow-100 text-yellow-700';
?>

<div class="bg-white rounded-2xl border shadow-sm hover:shadow-md transition flex flex-col">

    <!-- HEADER -->
    <div class="p-5 border-b">
        <div class="flex items-start justify-between gap-3">
            <h4 class="font-semibold text-gray-800 line-clamp-2">
                <?= esc($d['judul']) ?>
            </h4>

            <span class="px-3 py-1 rounded-full text-xs font-medium <?= $statusClass ?>">
                <?= strtoupper(str_replace('_', ' ', $d['status'])) ?>
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

        <div class="flex flex-wrap gap-4 text-sm text-gray-500">

            <!-- KATEGORI -->
            <span>
                <strong>Kategori:</strong>
                <?= esc($d['nama_kategori'] ?? '-') ?>
            </span>

            <!-- PENGIRIM -->
            <span>
                <strong>Pengirim:</strong>
                <?= esc($d['nama_pengirim'] ?? '-') ?>
            </span>

            <!-- JABATAN -->
            <span>
                <strong>Jabatan:</strong>
                <?= esc($d['nama_jabatan'] ?? '-') ?>
            </span>

            <!-- UNIT -->
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

<?= $this->endSection() ?>
