<?= $this->extend('layout/atasan_template') ?>
<?= $this->section('content') ?>

<h3 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-100">Pengaturan Profil</h3>

<?php if(session()->getFlashdata('success')): ?>
<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
    <?= session()->getFlashdata('success') ?>
</div>
<?php endif; ?>

<div class="bg-white shadow rounded-lg p-6">

    <form action="<?= base_url('atasan/profile/update') ?>" method="POST" class="space-y-4">

        <div>
            <label class="block font-medium mb-1">Nama</label>
            <input type="text" name="nama" class="w-full border rounded px-3 py-2 focus:ring focus:ring-orange-300" 
                   value="<?= esc($user['nama']) ?>" required>
        </div>

        <div>
            <label class="block font-medium mb-1">Email</label>
            <input type="email" name="email" class="w-full border rounded px-3 py-2 focus:ring focus:ring-orange-300"
                   value="<?= esc($user['email']) ?>" required>
        </div>

        <div>
            <label class="block font-medium mb-1">Password Baru (opsional)</label>
            <input type="password" name="password" class="w-full border rounded px-3 py-2 focus:ring focus:ring-orange-300">
            <p class="text-sm text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengganti.</p>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white font-semibold px-4 py-2 rounded shadow transition-all">
                Simpan Perubahan
            </button>
            <a href="<?= base_url('atasan') ?>" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold px-4 py-2 rounded shadow transition-all">
                Kembali
            </a>
        </div>

    </form>

</div>

<?= $this->endSection() ?>
