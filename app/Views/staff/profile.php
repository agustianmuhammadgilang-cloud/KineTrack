<?= $this->extend('layout/staff_template') ?>
<?= $this->section('content') ?>

<h3 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-100">Pengaturan Profil</h3>

<?php if(session()->getFlashdata('success')): ?>
<div class="bg-green-100 text-green-800 p-4 rounded-lg mb-4 shadow">
    <?= session()->getFlashdata('success') ?>
</div>
<?php endif; ?>

<div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 transition-colors">

    <form action="<?= base_url('staff/profile/update') ?>" method="POST" class="space-y-4">

        <div>
            <label class="block font-medium text-gray-700 dark:text-gray-200">Nama</label>
            <input type="text" name="nama" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-orange-500 focus:border-orange-500" 
                   value="<?= esc($user['nama']) ?>" required>
        </div>

        <div>
            <label class="block font-medium text-gray-700 dark:text-gray-200">Email</label>
            <input type="email" name="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-orange-500 focus:border-orange-500"
                   value="<?= esc($user['email']) ?>" required>
        </div>

        <div>
            <label class="block font-medium text-gray-700 dark:text-gray-200">Password Baru (opsional)</label>
            <input type="password" name="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-orange-500 focus:border-orange-500">
            <p class="text-sm text-gray-500 mt-1">Kosongkan jika tidak ingin mengganti.</p>
        </div>

        <div class="flex gap-3 mt-4">
            <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white font-semibold px-4 py-2 rounded shadow transition-all">
                Simpan Perubahan
            </button>
            <a href="<?= base_url('staff') ?>" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold px-4 py-2 rounded shadow transition-all">
                Kembali
            </a>
        </div>

    </form>

</div>

<?= $this->endSection() ?>
