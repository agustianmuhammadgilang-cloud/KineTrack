<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-[#1D2F83]">
        📁 Kategori Dokumen
    </h1>

    <button onclick="document.getElementById('modal-create').showModal()"
            class="bg-[#F58025] hover:bg-orange-600 text-white px-4 py-2 rounded-lg shadow transition">
        + Tambah Kategori
    </button>
</div>

<?php if (session()->getFlashdata('success')): ?>
<div class="mb-4 p-4 bg-green-50 text-green-700 rounded-lg">
    <?= session()->getFlashdata('success') ?>
</div>
<?php endif ?>

<div class="bg-white rounded-xl shadow overflow-hidden">
<table class="w-full text-sm">
<thead class="bg-gray-100 text-gray-700">
<tr>
    <th class="p-4 text-left">No</th>
    <th class="p-4 text-left">Nama</th>
    <th class="p-4 text-left">Deskripsi</th>
    <th class="p-4 text-center">Status</th>
    <th class="p-4 text-center">Aksi</th>
</tr>
</thead>

<tbody class="divide-y divide-gray-100">
<?php foreach ($kategori as $i => $k): ?>
<tr class="hover:bg-gray-50 transition">
    <td class="p-4"><?= $i + 1 ?></td>
    <td class="p-4 font-semibold text-gray-800"><?= esc($k['nama_kategori']) ?></td>
    <td class="p-4 text-gray-600"><?= esc($k['deskripsi']) ?></td>
    <td class="p-4 text-center">
        <span class="px-3 py-1 text-xs rounded-full
            <?= $k['status']==='aktif' ? 'bg-green-100 text-green-700' : 'bg-gray-200 text-gray-600' ?>">
            <?= ucfirst($k['status']) ?>
        </span>
    </td>
    <td class="p-4 text-center space-x-3">
        <button onclick="document.getElementById('modal-edit-<?= $k['id'] ?>').showModal()"
                class="text-blue-600 hover:underline transition">
            Edit
        </button>
        <a href="<?= base_url('admin/kategori-dokumen/toggle/'.$k['id']) ?>"
           onclick="return confirm('Ubah status kategori?')"
           class="text-orange-600 hover:underline transition">
            <?= $k['status']==='aktif'?'Nonaktifkan':'Aktifkan' ?>
        </a>
    </td>
</tr>

<!-- MODAL EDIT -->
<dialog id="modal-edit-<?= $k['id'] ?>" class="rounded-2xl w-full max-w-lg shadow-2xl backdrop:bg-black/50 p-0 overflow-hidden">
    <form method="post"
          action="<?= base_url('admin/kategori-dokumen/update/'.$k['id']) ?>"
          class="flex flex-col bg-white rounded-2xl">
        <?= csrf_field() ?>

        <div class="p-8 flex flex-col gap-6">
            <h3 class="text-2xl font-bold text-[#1D2F83]">✏️ Edit Kategori</h3>

            <div>
                <label class="text-sm font-medium text-gray-700">Nama Kategori</label>
                <input type="text" name="nama_kategori" required
                       value="<?= esc($k['nama_kategori']) ?>"
                       class="w-full mt-2 border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#F58025] focus:border-[#F58025] transition">
            </div>

            <div>
                <label class="text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea name="deskripsi" rows="3"
                          class="w-full mt-2 border border-gray-300 rounded-lg px-3 py-2"><?= esc($k['deskripsi']) ?></textarea>
            </div>
        </div>

        <div class="px-8 py-6 border-t border-gray-200 flex justify-end gap-3">
            <button type="button" onclick="this.closest('dialog').close()"
                    class="px-5 py-2 border rounded-lg text-gray-600 hover:bg-gray-100 transition">Batal</button>
            <button type="submit"
                    class="px-5 py-2 bg-[#F58025] hover:bg-orange-600 text-white rounded-lg shadow transition">Simpan</button>
        </div>
    </form>
</dialog>

<?php endforeach ?>
</tbody>
</table>
</div>

<!-- MODAL CREATE -->
<dialog id="modal-create" class="rounded-2xl w-full max-w-lg shadow-2xl backdrop:bg-black/50 p-0 overflow-hidden">
    <form method="post"
          action="<?= base_url('admin/kategori-dokumen/store') ?>"
          class="flex flex-col bg-white rounded-2xl">
        <?= csrf_field() ?>

        <div class="p-8 flex flex-col gap-6">
            <h3 class="text-2xl font-bold text-[#1D2F83]">➕ Tambah Kategori</h3>

            <div>
                <label class="text-sm font-medium text-gray-700">Nama Kategori</label>
                <input type="text" name="nama_kategori" required
                       class="w-full mt-2 border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#F58025] focus:border-[#F58025] transition">
            </div>

            <div>
                <label class="text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea name="deskripsi" rows="3"
                          class="w-full mt-2 border border-gray-300 rounded-lg px-3 py-2"></textarea>
            </div>
        </div>

        <div class="px-8 py-6 border-t border-gray-200 flex justify-end gap-3">
            <button type="button" onclick="this.closest('dialog').close()"
                    class="px-5 py-2 border rounded-lg text-gray-600 hover:bg-gray-100 transition">Batal</button>
            <button type="submit"
                    class="px-5 py-2 bg-[#F58025] hover:bg-orange-600 text-white rounded-lg shadow transition">Simpan</button>
        </div>
    </form>
</dialog>

<?= $this->endSection() ?>
