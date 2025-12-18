<?= $this->extend('layout/staff_template') ?>
<?= $this->section('content') ?>

<!-- HEADER -->
<div class="mb-8">
    <h4 class="text-2xl font-semibold text-gray-800">
        Arsip Dokumen
    </h4>
    <p class="text-sm text-gray-500">
        Dokumen yang telah disetujui dan diarsipkan
    </p>
</div>

<!-- EMPTY STATE -->
<?php if (empty($dokumen)): ?>
    <div class="bg-white rounded-2xl border p-10 text-center">
        <svg class="w-12 h-12 mx-auto text-gray-300 mb-4"
             fill="none" stroke="currentColor" stroke-width="1.5">
            <path d="M12 8v8m0 0l3-3m-3 3l-3-3"/>
        </svg>

        <p class="text-gray-600 font-medium">
            Belum ada dokumen yang diarsipkan
        </p>
        <p class="text-sm text-gray-500 mt-1">
            Dokumen akan muncul di sini setelah disetujui
        </p>
    </div>

<?php else: ?>

<!-- LIST -->
<div class="space-y-4">

    <?php foreach ($dokumen as $d): ?>
        <div class="bg-white rounded-2xl border p-5
                    flex items-center justify-between
                    hover:shadow-sm transition">

            <!-- LEFT -->
            <div>
                <h5 class="font-medium text-gray-800">
                    <?= esc($d['judul']) ?>
                </h5>

                <p class="text-sm text-gray-500 mt-1 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M8 7V3m8 4V3M3 11h18"/>
                    </svg>
                    <?= date('d M Y', strtotime($d['updated_at'])) ?>
                </p>
            </div>

            <!-- ACTION -->
            <a href="<?= base_url('uploads/dokumen/'.$d['file_path']) ?>"
               target="_blank"
               class="inline-flex items-center gap-2
                      bg-gray-100 hover:bg-orange-500
                      text-gray-700 hover:text-white
                      px-4 py-2 rounded-xl
                      transition">

                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 5v10m0 0l-3-3m3 3l3-3"/>
                </svg>

                <span class="text-sm font-medium hidden sm:inline">
                    Download
                </span>
            </a>

        </div>
    <?php endforeach ?>

</div>

<?php endif ?>

<?= $this->endSection() ?>
