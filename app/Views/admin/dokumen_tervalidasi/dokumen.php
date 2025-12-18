<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<!-- BACK -->
<a href="<?= base_url('admin/dokumen-tervalidasi') ?>"
   class="inline-flex items-center gap-1 text-sm text-blue-600 hover:underline mb-5">
    ← Kembali ke kategori
</a>

<!-- HEADER -->
<div class="mb-6">
    <h1 class="text-3xl font-extrabold text-[#1D2F83] flex items-center gap-2">
        📂 <?= esc($kategori['nama_kategori']) ?>
    </h1>
    <p class="text-sm text-gray-500">
        Dokumen yang telah disetujui Ketua Jurusan
    </p>
</div>

<!-- FILTER -->
<div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
<form method="get" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">

    <div>
        <label class="text-sm font-medium text-gray-600">Unit Kerja</label>
        <select name="bidang"
                class="w-full mt-1 border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#F58025] focus:border-[#F58025] transition">
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
               class="w-full mt-1 border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#F58025] focus:border-[#F58025] transition">
    </div>

    <button
        class="w-full bg-[#F58025] hover:bg-orange-600
               text-white font-medium rounded-lg py-2 shadow-lg transition">
        🔍 Filter
    </button>
</form>
</div>

<!-- TABLE -->
<div class="bg-white rounded-2xl shadow-lg overflow-hidden">
<table class="w-full text-sm">
<thead class="bg-gray-50 text-gray-700 uppercase text-xs">
<tr>
    <th class="px-6 py-4 text-left">Judul Dokumen</th>
    <th class="px-6 py-4 text-left">Unit</th>
    <th class="px-6 py-4 text-left">Tanggal ACC</th>
    <th class="px-6 py-4 text-center">Aksi</th>
</tr>
</thead>

<tbody class="divide-y divide-gray-100">

<?php if (empty($dokumen)): ?>
<tr>
    <td colspan="4" class="p-10 text-center text-gray-400 italic">
        📭 Tidak ada dokumen pada kategori ini
    </td>
</tr>
<?php endif ?>

<?php foreach ($dokumen as $d): ?>
<tr class="hover:bg-gray-50 transition duration-200">

    <td class="px-6 py-4">
        <div class="font-semibold text-gray-800">
            <?= esc($d['judul']) ?>
        </div>
        <div class="text-xs text-gray-400">
            ID Dokumen: <?= $d['id'] ?>
        </div>
    </td>

    <td class="px-6 py-4 text-gray-600">
        <?= esc($d['nama_bidang'] ?? '-') ?>
    </td>

    <td class="px-6 py-4 text-gray-600">
        <?= date('d M Y', strtotime($d['updated_at'])) ?>
    </td>

    <td class="px-6 py-4">
        <div class="flex justify-center gap-4 font-medium">
            <a href="<?= base_url('uploads/dokumen/' . $d['file_path']) ?>"
               target="_blank"
               class="text-blue-600 hover:underline hover:text-blue-800 transition">
                👁 Lihat
            </a>

            <button
                onclick="document.getElementById('edit<?= $d['id'] ?>').showModal()"
                class="text-orange-600 hover:underline hover:text-orange-800 transition">
                ✏ Edit
            </button>
        </div>
    </td>
</tr>

<!-- MODAL EDIT -->
<dialog id="edit<?= $d['id'] ?>"
        class="rounded-2xl w-full max-w-2xl shadow-2xl backdrop:bg-black/50 p-0 overflow-hidden">

    <form method="post"
          action="<?= base_url('admin/dokumen-tervalidasi/update-kategori/' . $d['id']) ?>"
          class="flex flex-col bg-white rounded-2xl">

        <?= csrf_field() ?>

        <div class="p-8 flex flex-col gap-6">
            <h3 class="text-2xl font-bold text-[#1D2F83]">
                Edit Kategori Dokumen
            </h3>
            <p class="text-sm text-gray-500">
                Dokumen: <b><?= esc($d['judul']) ?></b>
            </p>

            <div>
                <label class="text-sm font-medium text-gray-700">
                    Pilih Kategori Baru
                </label>

                <select name="kategori_id"
                        class="w-full mt-2 border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#F58025] focus:border-[#F58025] transition">
                    <?php foreach ($kategoriList as $k): ?>
                        <option value="<?= $k['id'] ?>"
                            <?= $k['id'] == $kategori['id'] ? 'selected' : '' ?>>
                            <?= esc($k['nama_kategori']) ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>
        </div>

        <!-- TOMBOL -->
        <div class="px-8 py-6 border-t border-gray-200 flex justify-end gap-3">
            <button type="button"
                    onclick="this.closest('dialog').close()"
                    class="px-5 py-2 border rounded-lg text-gray-600 hover:bg-gray-100 transition">
                Batal
            </button>

            <button type="submit"
                    class="px-5 py-2 bg-[#F58025] hover:bg-orange-600
                           text-white rounded-lg shadow-lg transition">
                Simpan
            </button>
        </div>
    </form>
</dialog>

<?php endforeach ?>

</tbody>
</table>
</div>

<?= $this->endSection() ?>
