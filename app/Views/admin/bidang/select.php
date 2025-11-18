<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<div class="mb-6">
    <h3 class="text-2xl font-semibold text-gray-800 dark:text-gray-100 mb-2">📊 Pilih Bidang untuk Analisis</h3>
    <p class="text-gray-500 dark:text-gray-400">Silakan pilih bidang berikut untuk melihat detail kinerja pegawai.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <?php foreach ($bidang as $b): ?>
    <a href="<?= base_url('admin/bidang/detail/'.$b['id']) ?>" class="block">
        <div class="bg-white dark:bg-gray-800 border-l-4 border-orange-500 shadow-md rounded-lg p-5 hover:shadow-xl hover:-translate-y-1 transition cursor-pointer">
            <h4 class="text-lg font-semibold text-blue-900 dark:text-blue-400"><?= esc($b['nama_bidang']) ?></h4>
            <p class="text-gray-500 dark:text-gray-400 mt-1 text-sm">Klik untuk melihat analisis lengkap bidang ini</p>
        </div>
    </a>
    <?php endforeach; ?>

    <?php if (count($bidang) == 0): ?>
        <div class="col-span-full text-gray-500 dark:text-gray-400">Belum ada bidang ditambahkan.</div>
    <?php endif ?>
</div>

<?= $this->endSection() ?>
