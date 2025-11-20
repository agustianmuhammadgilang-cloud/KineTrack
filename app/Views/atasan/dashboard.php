<?= $this->extend('layout/atasan_template') ?>
<?= $this->section('content') ?>

<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

    <h3 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-100">Dashboard Atasan</h3>

    <!-- Informasi Profil -->
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mb-6 transition-colors">
        <h5 class="text-lg font-semibold mb-3 text-gray-700 dark:text-gray-200">Informasi Atasan</h5>
        <p><span class="font-medium">Nama:</span> <?= esc($atasan['nama']) ?></p>
        <p><span class="font-medium">Jabatan:</span> <?= esc($atasan['nama_jabatan']) ?></p>
        <p><span class="font-medium">Bidang:</span> <?= esc($atasan['nama_bidang']) ?></p>

        <a href="<?= base_url('atasan/profile') ?>" 
           class="mt-4 inline-block bg-orange-500 hover:bg-orange-600 text-white font-semibold px-4 py-2 rounded shadow transition-all">
           Pengaturan Profil
        </a>
    </div>

    <!-- Statistik Laporan -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 text-center transition-colors">
            <h4 class="text-gray-500 font-semibold mb-2">Pending</h4>
            <h2 class="text-3xl font-bold text-gray-800 dark:text-gray-100"><?= esc($pending) ?></h2>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 text-center transition-colors">
            <h4 class="text-green-500 font-semibold mb-2">Diterima</h4>
            <h2 class="text-3xl font-bold text-gray-800 dark:text-gray-100"><?= esc($approved) ?></h2>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 text-center transition-colors">
            <h4 class="text-red-500 font-semibold mb-2">Ditolak</h4>
            <h2 class="text-3xl font-bold text-gray-800 dark:text-gray-100"><?= esc($rejected) ?></h2>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
