<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<h2 class="text-3xl font-bold text-[var(--polban-blue)] mb-6">Pengaturan Profil</h2>

<!-- Alert -->
<?php if(session()->getFlashdata('success')): ?>
<div class="p-3 mb-4 bg-green-100 text-green-700 rounded-lg">
    <?= session()->getFlashdata('success') ?>
</div>
<?php endif; ?>

<div class="bg-white shadow border border-gray-200 rounded-xl p-6 
            max-w-xl w-full mx-auto sm:w-full">

    <form action="<?= base_url('admin/profile/update') ?>" method="post" enctype="multipart/form-data"
          class="space-y-5">

        <!-- NAMA -->
        <div>
            <label class="block font-medium mb-1">Nama</label>
            <input type="text" name="nama" value="<?= esc($admin['nama'] ?? '') ?>"
                   class="w-full border rounded-lg p-2 focus:ring-2 
                          focus:ring-[var(--polban-blue)]/50"
                   required>
        </div>

        <!-- EMAIL -->
        <div>
            <label class="block font-medium mb-1">Email</label>
            <input type="email" name="email" value="<?= esc($admin['email'] ?? '') ?>"
                   class="w-full border rounded-lg p-2 focus:ring-2 
                          focus:ring-[var(--polban-blue)]/50"
                   required>
        </div>

        <!-- PASSWORD -->
        <div>
            <label class="block font-medium mb-1">Password Baru (opsional)</label>
            <input type="password" name="password"
                   class="w-full border rounded-lg p-2 focus:ring-2 
                          focus:ring-[var(--polban-blue)]/50"
                   placeholder="Biarkan kosong jika tidak ingin mengubah password">
        </div>

        <!-- FOTO -->
        <div>
            <label class="block font-medium mb-1">Foto Profil (opsional)</label>
            <input type="file" name="foto"
                   class="w-full border rounded-lg p-2 bg-gray-50">
        </div>

        <?php if (!empty($admin['foto'])): ?>
        <div class="flex justify-center sm:justify-start">
            <img src="<?= base_url('uploads/admin/'.$admin['foto']) ?>"
                 class="w-24 h-24 rounded-full border shadow object-cover mt-2">
        </div>
        <?php endif; ?>

        <!-- BUTTON -->
        <div class="pt-2">
            <button
                class="px-5 py-2 bg-[var(--polban-blue)] text-white rounded-lg shadow 
                       hover:bg-blue-900 transition w-full sm:w-auto">
                Simpan Perubahan
            </button>
        </div>

    </form>
</div>

<?= $this->endSection() ?>
