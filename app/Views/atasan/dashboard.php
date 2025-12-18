<?= $this->extend('layout/atasan_template') ?>
<?= $this->section('content') ?>

<div class="p-4 sm:p-6 md:p-8 transition-all duration-300 dark:bg-gray-900">

    <h3 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-100">
        Dashboard Atasan
    </h3>

    <!-- INFORMASI ATASAN -->
    <div class="bg-white dark:bg-gray-800 shadow-md rounded-2xl p-6 mb-6 transition hover:shadow-xl">
        <h5 class="text-lg font-semibold mb-4 text-gray-700 dark:text-gray-200">
            Informasi Atasan
        </h5>

        <div class="space-y-1 text-gray-700 dark:text-gray-300">
            <p><span class="font-medium">Nama:</span> <?= esc($atasan['nama']) ?></p>
            <p><span class="font-medium">Jabatan:</span> <?= esc($atasan['nama_jabatan']) ?></p>
            <p><span class="font-medium">Bidang:</span> <?= esc($atasan['nama_bidang']) ?></p>
        </div>

        <a href="<?= base_url('atasan/profile') ?>"
           class="inline-block mt-4 bg-orange-500 hover:bg-orange-600 text-white font-semibold px-5 py-2 rounded-lg shadow transition">
            Pengaturan Profil
        </a>
    </div>

    <!-- STATISTIC CARDS -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-6">

        <!-- Pending (Abu-abu) -->
        <div class="group bg-gray-500 dark:bg-gray-600 shadow-md rounded-2xl p-6 text-center text-white transform transition-all hover:scale-105 hover:shadow-2xl relative overflow-hidden">
            <div class="absolute right-3 top-3 opacity-20 group-hover:opacity-50">
                <svg class="w-10 h-10 sm:w-12 sm:h-12" fill="none">
                    <?= heroicons_outline('clock') ?>
                </svg>
            </div>
            <h5 class="font-semibold mb-1">Pending</h5>
            <h2 class="text-3xl font-bold mt-1"><?= esc($pending) ?></h2>
        </div>

        <!-- Diterima (Biru) -->
        <div class="group bg-blue-500 dark:bg-blue-600 shadow-md rounded-2xl p-6 text-center text-white transform transition-all hover:scale-105 hover:shadow-2xl relative overflow-hidden">
            <div class="absolute right-3 top-3 opacity-20 group-hover:opacity-50">
                <svg class="w-10 h-10 sm:w-12 sm:h-12" fill="none">
                    <?= heroicons_outline('check-circle') ?>
                </svg>
            </div>
            <h5 class="font-semibold mb-1">Diterima</h5>
            <h2 class="text-3xl font-bold mt-1"><?= esc($approved) ?></h2>
        </div>

        <!-- Ditolak (Kuning) -->
        <div class="group bg-yellow-400 dark:bg-yellow-500 shadow-md rounded-2xl p-6 text-center text-white transform transition-all hover:scale-105 hover:shadow-2xl relative overflow-hidden">
            <div class="absolute right-3 top-3 opacity-20 group-hover:opacity-50">
                <svg class="w-10 h-10 sm:w-12 sm:h-12" fill="none">
                    <?= heroicons_outline('x-circle') ?>
                </svg>
            </div>
            <h5 class="font-semibold mb-1">Ditolak</h5>
            <h2 class="text-3xl font-bold mt-1"><?= esc($rejected) ?></h2>
        </div>

    </div>

    <!-- FOOTER -->
    <p class="text-center text-gray-500 dark:text-gray-400 mt-6 sm:mt-8 text-xs sm:text-sm">
        © <?= date('Y') ?> KINETRACK — Politeknik Negeri Bandung.
    </p>

</div>

<?= $this->endSection() ?>
