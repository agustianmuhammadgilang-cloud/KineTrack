<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<!-- BACK -->
<a href="<?= base_url('admin/dokumen-tervalidasi') ?>"
   class="inline-flex items-center gap-1 text-sm text-[#1D2F83] hover:text-[#F58025] transition mb-5">
    <!-- Heroicon Arrow Left -->
    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
         stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M15 19l-7-7 7-7"/>
    </svg>
    Kembali ke kategori
</a>

<!-- HEADER -->
<div class="mb-6">
    <h1 class="text-3xl font-extrabold text-[#1D2F83] flex items-center gap-3">
        <!-- Heroicon Folder -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-[#F58025]" fill="none" viewBox="0 0 24 24"
             stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M3 7h4l2 3h10a2 2 0 012 2v5a2 2 0 01-2 2H3V7z"/>
        </svg>
        <?= esc($kategori['nama_kategori']) ?>
        <span class="ml-2 px-2 py-1 text-xs font-semibold text-white bg-[#F58025] rounded-full">
            <?= count($dokumen) ?> Dokumen
        </span>
    </h1>
    <p class="text-sm text-gray-500 mt-1">
        Dokumen yang telah disetujui Ketua Jurusan
    </p>
</div>

<!-- FILTER -->
<div class="bg-white rounded-3xl shadow-xl p-6 mb-6 border border-gray-100">
<form method="get" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">

    <div>
        <label class="text-sm font-medium text-gray-600">Unit Kerja</label>
        <select name="bidang"
                class="w-full mt-1 border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#F58025] focus:border-[#F58025] transition shadow-sm">
            <option value="">Semua Unit</option>
            <?php foreach ($bidang as $b): ?>
                <option value="<?= $b['id'] ?>"
                    <?= request()->getGet('bidang') == $b['id'] ? 'selected' : '' ?>>
                    <?= esc($b['nama_bidang']) ?>
                </option>
            <?php endforeach ?>
        </select>
    </div>

    <div class="md:col-span-2">
        <label class="text-sm font-medium text-gray-600">Judul Dokumen</label>
        <input type="text"
               name="q"
               value="<?= esc(request()->getGet('q')) ?>"
               placeholder="Cari judul dokumen..."
               class="w-full mt-1 border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#F58025] focus:border-[#F58025] transition shadow-sm">
    </div>

    <button
        class="w-full bg-[#F58025] hover:bg-orange-600 text-white font-semibold rounded-lg py-2 shadow-md transition flex items-center justify-center gap-2">
        <!-- Heroicon Magnifying Glass -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
             stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1110.5 3a7.5 7.5 0 016.15 13.65z"/>
        </svg>
        Filter
    </button>
</form>
</div>

<!-- LIST DOKUMEN -->
<div class="grid gap-4">

<?php if (empty($dokumen)): ?>
    <div class="bg-white rounded-3xl shadow-xl p-10 text-center text-gray-400 italic">
        Tidak ada dokumen pada kategori ini
    </div>
<?php endif ?>

<?php foreach ($dokumen as $d): ?>
<div class="bg-white rounded-3xl shadow-lg p-6 hover:shadow-2xl transition duration-300 border border-gray-100">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

        <!-- INFO DOKUMEN -->
        <div class="flex-1">
            <div class="text-lg font-semibold text-gray-800"><?= esc($d['judul']) ?></div>
            <div class="text-sm text-gray-400 mt-1">ID Dokumen: <?= $d['id'] ?></div>
            <div class="text-sm text-gray-600 mt-1">
                Unit: <?= esc($d['nama_bidang'] ?? '-') ?> | ACC: <?= date('d M Y', strtotime($d['updated_at'])) ?>
            </div>
        </div>

        <!-- AKSI -->
        <div class="flex gap-4 mt-4 md:mt-0">
            <a href="<?= base_url('uploads/dokumen/' . $d['file_path']) ?>"
               target="_blank"
               class="px-4 py-2 bg-[#1D2F83] hover:bg-[#16326c] text-white rounded-lg shadow transition flex items-center gap-2">
                <!-- Heroicon Eye -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
                Lihat
            </a>

            <button
                onclick="document.getElementById('edit<?= $d['id'] ?>').showModal()"
                class="px-4 py-2 bg-[#F58025] hover:bg-orange-600 text-white rounded-lg shadow transition flex items-center gap-2">
                <!-- Heroicon Pencil -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M11 5h2M12 7v10m-1 4h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Edit
            </button>
        </div>
    </div>
</div>

<!-- MODAL EDIT -->
<dialog id="edit<?= $d['id'] ?>"
        class="rounded-3xl w-full max-w-2xl shadow-2xl backdrop:bg-black/40 p-0 overflow-hidden animate-fadeIn">

    <form method="post"
          action="<?= base_url('admin/dokumen-tervalidasi/update-kategori/' . $d['id']) ?>"
          class="flex flex-col bg-white rounded-3xl overflow-hidden">

        <?= csrf_field() ?>

        <div class="p-8 flex flex-col gap-6">
            <h3 class="text-2xl font-bold text-[#1D2F83]">Edit Kategori Dokumen</h3>
            <p class="text-sm text-gray-500">Dokumen: <b><?= esc($d['judul']) ?></b></p>

            <div>
                <label class="text-sm font-medium text-gray-700">Pilih Kategori Baru</label>
                <select name="kategori_id"
                        class="w-full mt-2 border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#F58025] focus:border-[#F58025] transition shadow-sm">
                    <?php foreach ($kategoriList as $k): ?>
                        <option value="<?= $k['id'] ?>" <?= $k['id'] == $kategori['id'] ? 'selected' : '' ?>>
                            <?= esc($k['nama_kategori']) ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>
        </div>

        <!-- TOMBOL -->
        <div class="px-8 py-6 border-t border-gray-200 flex justify-end gap-3 bg-gray-50">
            <button type="button"
                    onclick="this.closest('dialog').close()"
                    class="px-5 py-2 border rounded-lg text-gray-600 hover:bg-gray-100 transition">
                Batal
            </button>

            <button type="submit"
                    class="px-5 py-2 bg-[#F58025] hover:bg-orange-600 text-white rounded-lg shadow-md transition flex items-center gap-1">
                Simpan
            </button>
        </div>
    </form>
</dialog>

<?php endforeach ?>

</div>

<?= $this->endSection() ?>
