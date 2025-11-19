<?= $this->extend('layout/atasan_template') ?>
<?= $this->section('content') ?>

<h3 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-100">
    Pengaturan Profil
</h3>

<?php if(session()->getFlashdata('success')): ?>
<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4 shadow-sm">
    <?= session()->getFlashdata('success') ?>
</div>
<?php endif; ?>

<div class="bg-white shadow rounded-xl p-6">

    <form action="<?= base_url('atasan/profile/update') ?>" method="POST" 
          class="space-y-5">

        <!-- Nama -->
        <div class="space-y-1">
            <label class="block font-semibold text-gray-700">Nama</label>
            <input type="text" 
                   name="nama"
                   value="<?= esc($user['nama']) ?>"
                   required
                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-orange-400 focus:border-orange-400 transition">
        </div>

        <!-- Email -->
        <div class="space-y-1">
            <label class="block font-semibold text-gray-700">Email</label>
            <input type="email" 
                   name="email"
                   value="<?= esc($user['email']) ?>"
                   required
                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-orange-400 focus:border-orange-400 transition">
        </div>

        <!-- Password -->
        <div class="space-y-1">
            <label class="block font-semibold text-gray-700">Password Baru (opsional)</label>
            <input type="password" 
                   name="password"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-orange-400 focus:border-orange-400 transition">
            <p class="text-sm text-gray-500">Biarkan kosong jika tidak ingin mengganti password.</p>
        </div>

        <!-- Actions -->
        <div class="flex flex-col sm:flex-row gap-3 pt-3">
            <button type="submit" 
                    class="w-full sm:w-auto bg-orange-500 hover:bg-orange-600 text-white font-semibold px-5 py-2.5 rounded-lg shadow transition">
                Simpan Perubahan
            </button>

            <a href="<?= base_url('atasan') ?>"
               class="w-full sm:w-auto text-center bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold px-5 py-2.5 rounded-lg shadow transition">
                Kembali
            </a>
        </div>

    </form>

</div>

<?= $this->endSection() ?>
