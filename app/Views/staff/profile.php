<?= $this->extend('layout/staff_template') ?>
<?= $this->section('content') ?>

<h3 class="text-2xl md:text-3xl font-bold mb-6 text-gray-800 dark:text-gray-100">
    Pengaturan Profil
</h3>

<?php if(session()->getFlashdata('success')): ?>
<div class="bg-green-100 text-green-800 p-4 rounded-lg mb-6 shadow-md">
    <?= session()->getFlashdata('success') ?>
</div>
<?php endif; ?>

<div class="bg-white dark:bg-gray-800 shadow-md rounded-xl p-6 md:p-8 transition-colors">

    <!-- 🔑 PENTING: enctype -->
    <form
        action="<?= base_url('staff/profile/update') ?>"
        method="POST"
        enctype="multipart/form-data"
        class="space-y-5">

        <!-- NAMA -->
        <div class="flex flex-col">
            <label class="font-semibold mb-1">
                Nama
            </label>
            <input 
                type="text" 
                name="nama"
                value="<?= esc($user['nama']) ?>"
                required
                class="w-full rounded-lg border px-3 py-2">
        </div>

        <!-- EMAIL -->
        <div class="flex flex-col">
            <label class="font-semibold mb-1">
                Email
            </label>
            <input 
                type="email" 
                name="email"
                value="<?= esc($user['email']) ?>"
                required
                class="w-full rounded-lg border px-3 py-2">
        </div>

        <!-- PASSWORD -->
        <div class="flex flex-col">
            <label class="font-semibold mb-1">
                Password Baru (opsional)
            </label>
            <input 
                type="password" 
                name="password"
                class="w-full rounded-lg border px-3 py-2">
            <p class="text-sm text-gray-500 mt-1">
                Kosongkan jika tidak ingin mengganti.
            </p>
        </div>

        <!-- ================= TTD DIGITAL (UPLOAD GAMBAR) ================= -->
        <div class="flex flex-col">
            <label class="font-semibold mb-2">
                Tanda Tangan Digital (PNG / JPG)
            </label>

            <?php if (!empty($user['ttd_digital'])): ?>
                <div class="mb-3">
                    <p class="text-sm text-gray-500 mb-1">TTD saat ini:</p>
                    <img
                        src="<?= base_url('uploads/ttd/'.$user['ttd_digital']) ?>"
                        alt="TTD"
                        class="h-24 border rounded">
                </div>
            <?php endif; ?>

            <input
                type="file"
                name="ttd_digital"
                accept="image/png, image/jpeg"
                class="border rounded-lg p-2 bg-white">

            <p class="text-sm text-gray-500 mt-1">
                Digunakan sebagai tanda tangan resmi pada laporan PDF.
            </p>
        </div>

        <!-- BUTTONS -->
        <div class="flex flex-col md:flex-row gap-3 pt-4">
            <button 
                type="submit"
                class="bg-orange-500 hover:bg-orange-600 text-white font-semibold px-5 py-2.5 rounded-lg">
                Simpan Perubahan
            </button>

            <a 
                href="<?= base_url('staff') ?>"
                class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold px-5 py-2.5 rounded-lg">
                Kembali
            </a>
        </div>

    </form>

</div>

<?= $this->endSection() ?>
