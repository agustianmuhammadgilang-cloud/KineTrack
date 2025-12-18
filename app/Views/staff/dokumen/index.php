<?= $this->extend('layout/staff_template') ?>
<?= $this->section('content') ?>

<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
    <div>
        <h4 class="text-2xl font-semibold text-gray-800">Dokumen Saya</h4>
        <p class="text-sm text-gray-500 mt-1">
            Riwayat pengajuan dokumen kinerja Anda
        </p>
    </div>

    <a href="<?= base_url('staff/dokumen/create') ?>"
       class="inline-flex items-center gap-2
              bg-orange-500 hover:bg-orange-600
              text-white px-5 py-2.5 rounded-xl shadow-sm transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M12 5v14M5 12h14"/>
        </svg>
        Upload Dokumen
    </a>
</div>

<?php if (empty($dokumen)): ?>
    <!-- EMPTY STATE -->
    <div class="bg-white rounded-2xl p-10 text-center border border-dashed">
        <div class="flex justify-center mb-4">
            <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5">
                <path d="M12 8v8m4-4H8"/>
            </svg>
        </div>
        <h5 class="text-lg font-medium text-gray-700">
            Belum ada dokumen
        </h5>
        <p class="text-sm text-gray-500 mt-1">
            Upload dokumen pertama Anda untuk memulai
        </p>
    </div>
<?php else: ?>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
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

        <!-- CARD -->
        <div class="bg-white rounded-2xl border shadow-sm
                    hover:shadow-md transition p-6
                    flex flex-col justify-between">

            <!-- HEADER -->
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h5 class="text-lg font-semibold text-gray-800">
                        <?= esc($d['judul']) ?>
                    </h5>
                    <p class="text-xs text-gray-500 mt-1">
                        Diajukan pada <?= date('d M Y', strtotime($d['created_at'])) ?>
                    </p>
                </div>

                <span class="px-3 py-1 rounded-full text-xs font-semibold <?= $class ?>">
                    <?= $label ?>
                </span>
            </div>

            <!-- CATATAN -->
            <div class="mt-4 text-sm text-gray-600">
                <span class="font-medium text-gray-700">Catatan:</span><br>
                <?= esc($d['catatan'] ?? 'Tidak ada catatan') ?>
            </div>

            <!-- ACTION -->
            <div class="mt-6 flex justify-end">
                <?php if (in_array($d['status'], ['rejected_kaprodi', 'rejected_kajur'])): ?>
                    <a href="<?= base_url('staff/dokumen/resubmit/'.$d['id']) ?>"
                       class="inline-flex items-center gap-2
                              bg-yellow-500 hover:bg-yellow-600
                              text-white px-4 py-2 rounded-lg text-sm transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M4 4v6h6M20 20v-6h-6"/>
                        </svg>
                        Revisi Dokumen
                    </a>
                <?php endif ?>
            </div>

        </div>

    <?php endforeach ?>
</div>

<?php endif; ?>

<?= $this->endSection() ?>
