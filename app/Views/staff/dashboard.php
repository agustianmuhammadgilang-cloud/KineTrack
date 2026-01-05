<?= $this->extend('layout/staff_template') ?>
<?= $this->section('content') ?>

<div class="min-h-screen bg-gray-50 px-6 py-8">

    <!-- HEADER -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800">
            Dashboard Kinerja Saya
        </h1>
        <p class="text-sm text-gray-500 mt-1">
            Ringkasan tugas, dokumen, dan status kinerja Anda
        </p>

        <div class="mt-4 flex flex-wrap gap-2 text-sm">
            <?php if (!empty($tahunAktif)): ?>
                <span class="px-3 py-1 rounded-full bg-blue-50 text-blue-700 border border-blue-200">
                    Tahun <?= esc($tahunAktif['tahun']) ?>
                </span>
            <?php endif; ?>

            <?php if (!empty($twAktif)): ?>
                <span class="px-3 py-1 rounded-full bg-green-50 text-green-700 border border-green-200">
                    TW <?= esc($twAktif['tw']) ?> • AKTIF
                </span>
            <?php endif; ?>
        </div>
    </div>

    <!-- SUMMARY CARDS -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">

        <!-- TUGAS PIC -->
        <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm flex items-start justify-between">
            <div>
                <p class="text-sm text-gray-500">Tugas PIC Aktif</p>
                <h3 class="text-3xl font-bold text-gray-800 mt-2">
                    <?= esc($totalPicAktif ?? 0) ?>
                </h3>
                <p class="text-xs text-gray-500 mt-1">
                    Indikator yang menjadi tanggung jawab Anda
                </p>
                <a href="<?= site_url('staff/task') ?>"
                   class="inline-block mt-4 text-sm font-medium text-blue-600 hover:underline">
                    Lihat daftar tugas →
                </a>
            </div>

            <!-- HEROICON -->
            <div class="p-3 rounded-lg bg-blue-50 text-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M9 12h6m-6 4h6M7 8h10M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
        </div>

        <!-- DOKUMEN REVISI -->
        <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm flex items-start justify-between">
            <div>
                <p class="text-sm text-gray-500">Dokumen Perlu Revisi</p>
                <h3 class="text-3xl font-bold text-red-600 mt-2">
                    <?= esc($dokumenRevisi ?? 0) ?>
                </h3>
                <p class="text-xs text-gray-500 mt-1">
                    Dokumen yang ditolak dan perlu diperbaiki
                </p>
                <a href="<?= site_url('staff/dokumen') ?>"
                   class="inline-block mt-4 text-sm font-medium text-red-600 hover:underline">
                    Lihat dokumen →
                </a>
            </div>

            <!-- HEROICON -->
            <div class="p-3 rounded-lg bg-red-50 text-red-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 9v3m0 4h.01M10.29 3.86L1.82 18a1.5 1.5 0 001.29 2.25h17.78a1.5 1.5 0 001.29-2.25L13.71 3.86a1.5 1.5 0 00-2.42 0z"/>
                </svg>
            </div>
        </div>

    </div>

    <!-- QUICK ACTION -->
    <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
        <h4 class="font-semibold text-gray-800 mb-4">
            Aksi Cepat
        </h4>

        <div class="flex flex-wrap gap-4">
            <a href="<?= site_url('staff/task') ?>"
               class="px-5 py-2.5 rounded-lg bg-blue-600 text-white text-sm font-medium hover:bg-blue-700 transition">
                Isi Pengukuran
            </a>

            <a href="<?= site_url('staff/dokumen/create') ?>"
               class="px-5 py-2.5 rounded-lg bg-green-600 text-white text-sm font-medium hover:bg-green-700 transition">
                Upload Dokumen
            </a>

            <a href="<?= site_url('staff/dokumen') ?>"
               class="px-5 py-2.5 rounded-lg bg-gray-100 text-gray-800 text-sm font-medium hover:bg-gray-200 transition">
                Dokumen Saya
            </a>
        </div>
    </div>

    <!-- FOOTER -->
    <p class="text-center text-xs text-gray-400 mt-12">
        © <?= date('Y') ?> KINETRACK — Politeknik Negeri Bandung
    </p>

</div>

<?= $this->endSection() ?>
