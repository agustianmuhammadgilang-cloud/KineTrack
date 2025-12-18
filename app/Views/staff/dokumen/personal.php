<?= $this->extend('layout/staff_template') ?>
<?= $this->section('content') ?>

<!-- HEADER -->
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
    <div>
        <h4 class="text-2xl font-bold text-[var(--polban-blue)]">
            Dokumen Saya
        </h4>
        <p class="text-sm text-gray-500 mt-1">
            Dokumen bersifat personal dan hanya dapat diakses oleh Anda
        </p>
    </div>

    <a href="<?= base_url('staff/dokumen/create') ?>"
       class="inline-flex items-center gap-2 bg-[var(--polban-orange)] 
              hover:bg-orange-600 text-white px-5 py-2.5 rounded-lg shadow transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
             viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M12 4v16m8-8H4"/>
        </svg>
        Upload Dokumen Personal
    </a>
</div>

<!-- EMPTY STATE -->
<?php if (empty($dokumen)): ?>
    <div class="bg-white border border-dashed border-gray-300 rounded-xl p-10 text-center">
        <div class="mx-auto w-16 h-16 flex items-center justify-center rounded-full bg-gray-100 mb-4">
            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M12 4v16m8-8H4"/>
            </svg>
        </div>
        <p class="text-gray-600 font-medium">Belum ada dokumen personal</p>
        <p class="text-sm text-gray-500 mt-1">
            Upload dokumen personal pertama Anda
        </p>
    </div>
<?php else: ?>

<!-- GRID CARD -->
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

    <div class="bg-white rounded-xl shadow border border-gray-200 
                hover:shadow-md transition flex flex-col">

        <!-- CARD HEADER -->
        <div class="p-5 border-b">
            <div class="flex items-start justify-between gap-3">
                <h5 class="font-semibold text-gray-800 leading-snug line-clamp-2">
                    <?= esc($d['judul']) ?>
                </h5>

                <span class="px-3 py-1 rounded-full text-xs font-semibold <?= $class ?>">
                    <?= $label ?>
                </span>
            </div>

            <p class="text-xs text-gray-500 mt-2">
                <?= date('d M Y', strtotime($d['created_at'])) ?>
            </p>
        </div>

        <!-- CARD BODY -->
        <div class="p-5 flex-1">
            <p class="text-sm text-gray-600 line-clamp-3">
                <?= esc($d['deskripsi'] ?? 'Tidak ada deskripsi') ?>
            </p>

            <?php if (!empty($d['catatan'])): ?>
                <div class="mt-4 p-3 bg-red-50 border border-red-100 rounded text-xs text-red-700">
                    <strong>Catatan:</strong><br>
                    <?= esc($d['catatan']) ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- CARD FOOTER -->
        <div class="p-4 border-t flex justify-end">
            <?php if (in_array($d['status'], ['rejected_kaprodi', 'rejected_kajur'])): ?>
                <a href="<?= base_url('staff/dokumen/resubmit/'.$d['id']) ?>"
                   class="inline-flex items-center gap-1 text-sm 
                          bg-yellow-500 hover:bg-yellow-600 
                          text-white px-4 py-2 rounded transition">
                    Revisi
                </a>
            <?php else: ?>
                <span class="text-xs text-gray-400 italic">
                    Tidak ada aksi
                </span>
            <?php endif; ?>
        </div>

    </div>

<?php endforeach; ?>
</div>

<?php endif; ?>

<?= $this->endSection() ?>
