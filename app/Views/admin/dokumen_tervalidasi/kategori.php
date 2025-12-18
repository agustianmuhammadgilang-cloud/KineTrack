<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<h1 class="text-2xl font-bold text-[#1D2F83] mb-6 flex items-center gap-2">
    📁 Dokumen Tervalidasi
</h1>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
<?php foreach ($kategori as $k): ?>

    <!-- CARD -->
    <div class="bg-white rounded-2xl shadow hover:shadow-lg transition p-6 relative">

        <!-- CONTENT -->
        <a href="<?= base_url('admin/dokumen-tervalidasi/' . $k['id']) ?>">
            <h2 class="text-lg font-semibold text-gray-800">
                <?= esc($k['nama_kategori']) ?>
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                <?= esc($k['deskripsi']) ?: 'Tidak ada deskripsi' ?>
            </p>

            <div class="mt-4 flex justify-between items-center">
                <span class="text-xs text-gray-400">
                    ID: <?= $k['id'] ?>
                </span>

                <span class="bg-[#1D2F83] text-white text-xs px-3 py-1 rounded-full">
                    <?= $k['total'] ?> Dokumen
                </span>
            </div>
        </a>
    </div>


<?php endforeach ?>
</div>

<?= $this->endSection() ?>
