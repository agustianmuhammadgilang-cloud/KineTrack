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
    <div class="bg-white rounded-xl shadow border border-gray-200 p-5">

        <h4 class="font-semibold text-gray-800 mb-1">
            <?= esc($d['judul']) ?>
        </h4>

        <p class="text-sm text-gray-500 mb-3">
            <?= esc($d['deskripsi']) ?>
        </p>

        <div class="flex items-center justify-between text-xs">
            <span class="px-3 py-1 rounded-full
                <?= $d['status'] === 'archived'
                    ? 'bg-green-100 text-green-700'
                    : 'bg-yellow-100 text-yellow-700' ?>">
                <?= strtoupper(str_replace('_', ' ', $d['status'])) ?>
            </span>

            <span class="text-gray-400">
                <?= date('d M Y', strtotime($d['created_at'])) ?>
            </span>

            <!-- VIEW -->
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
