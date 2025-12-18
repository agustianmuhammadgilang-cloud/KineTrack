<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<!-- Header -->
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
    <div class="flex flex-col gap-1">
        <h1 class="text-2xl font-bold text-[#1D2F83] flex items-center gap-3">
            <!-- Heroicon Folder Open -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#F58025]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M3 7h4l2 3h10a2 2 0 012 2v5a2 2 0 01-2 2H3V7z"/>
            </svg>
            Kategori Dokumen
        </h1>
        <p class="text-sm text-gray-500">Kelola kategori dokumen kinerja</p>
    </div>

    <button onclick="document.getElementById('modal-create').showModal()"
            class="inline-flex items-center gap-2 bg-[#F58025] hover:bg-orange-600 text-white px-4 py-2 rounded-lg shadow transition">
        <!-- Heroicon Plus -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Tambah Kategori
    </button>
</div>

<?php if (session()->getFlashdata('success')): ?>
<div class="mb-4 p-4 bg-green-50 text-green-700 rounded-lg border border-green-200">
    <?= session()->getFlashdata('success') ?>
</div>
<?php endif ?>

<!-- Table Card -->
<div class="bg-white rounded-3xl shadow overflow-hidden">
<table class="w-full text-sm">
<thead class="bg-gray-100 text-gray-700 uppercase text-xs">
<tr>
    <th class="p-4 text-left w-12">No</th>
    <th class="p-4 text-left">Nama</th>
    <th class="p-4 text-left">Deskripsi</th>
    <th class="p-4 text-center w-32">Status</th>
    <th class="p-4 text-center w-40">Aksi</th>
</tr>
</thead>

<tbody class="divide-y divide-gray-100">
<?php foreach ($kategori as $i => $k): ?>
<tr class="hover:bg-gray-50 transition">
    <td class="p-4"><?= $i + 1 ?></td>

    <td class="p-4 font-semibold text-gray-800"><?= esc($k['nama_kategori']) ?></td>

    <td class="p-4 text-gray-600">
        <?= esc($k['deskripsi']) ?: '<span class="italic text-gray-400">Tidak ada deskripsi</span>' ?>
    </td>

    <td class="p-4 text-center">
        <span class="inline-flex items-center gap-1 px-3 py-1 text-xs rounded-full
            <?= $k['status']==='aktif'
                ? 'bg-green-100 text-green-700'
                : 'bg-gray-200 text-gray-600' ?>">
            <?= $k['status']==='aktif'
                ? '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Aktif'
                : '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg> Nonaktif' ?>
        </span>
    </td>

    <td class="p-4 text-center space-x-4">
        <!-- Edit -->
        <button onclick="document.getElementById('modal-edit-<?= $k['id'] ?>').showModal()"
                class="inline-flex items-center gap-1 text-blue-600 hover:underline">
            <!-- Heroicon Pencil -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5h2M12 7v10m-1 4h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            Edit
        </button>

        <!-- Toggle -->
        <a href="<?= base_url('admin/kategori-dokumen/toggle/'.$k['id']) ?>"
           onclick="return confirm('Ubah status kategori?')"
           class="inline-flex items-center gap-1 text-orange-600 hover:underline">
            <?= $k['status']==='aktif'
                ? '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg> Nonaktifkan'
                : '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Aktifkan' ?>
        </a>
    </td>
</tr>

<!-- MODAL EDIT -->
<dialog id="modal-edit-<?= $k['id'] ?>" class="rounded-3xl w-full max-w-lg shadow-2xl backdrop:bg-black/50 p-0 overflow-hidden">
    <form method="post" action="<?= base_url('admin/kategori-dokumen/update/'.$k['id']) ?>" class="flex flex-col bg-white rounded-3xl">
        <?= csrf_field() ?>

        <div class="p-8 space-y-6">
            <h3 class="text-2xl font-bold text-[#1D2F83] flex items-center gap-2">
                <!-- Heroicon Pencil -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#F58025]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5h2M12 7v10m-1 4h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Edit Kategori
            </h3>

            <div>
                <label class="text-sm font-medium text-gray-700">Nama Kategori</label>
                <input type="text" name="nama_kategori" required
                       value="<?= esc($k['nama_kategori']) ?>"
                       class="w-full mt-2 border rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#F58025] focus:border-[#F58025]">
            </div>

            <div>
                <label class="text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea name="deskripsi" rows="3"
                          class="w-full mt-2 border rounded-lg px-3 py-2"><?= esc($k['deskripsi']) ?></textarea>
            </div>
        </div>

        <div class="px-8 py-6 border-t flex justify-end gap-3">
            <button type="button" onclick="this.closest('dialog').close()" class="px-5 py-2 border rounded-lg text-gray-600 hover:bg-gray-100">
                Batal
            </button>
            <button type="submit" class="px-5 py-2 bg-[#F58025] hover:bg-orange-600 text-white rounded-lg shadow">
                Simpan
            </button>
        </div>
    </form>
</dialog>

<?php endforeach ?>
</tbody>
</table>
</div>

<!-- MODAL CREATE -->
<dialog id="modal-create" class="rounded-3xl w-full max-w-lg shadow-2xl backdrop:bg-black/50 p-0 overflow-hidden">
    <form method="post" action="<?= base_url('admin/kategori-dokumen/store') ?>" class="flex flex-col bg-white rounded-3xl">
        <?= csrf_field() ?>

        <div class="p-8 space-y-6">
            <h3 class="text-2xl font-bold text-[#1D2F83] flex items-center gap-2">
                <!-- Heroicon Plus -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#F58025]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Kategori
            </h3>

            <div>
                <label class="text-sm font-medium text-gray-700">Nama Kategori</label>
                <input type="text" name="nama_kategori" required
                       class="w-full mt-2 border rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#F58025] focus:border-[#F58025]">
            </div>

            <div>
                <label class="text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea name="deskripsi" rows="3"
                          class="w-full mt-2 border rounded-lg px-3 py-2"></textarea>
            </div>
        </div>

        <div class="px-8 py-6 border-t flex justify-end gap-3">
            <button type="button" onclick="this.closest('dialog').close()" class="px-5 py-2 border rounded-lg text-gray-600 hover:bg-gray-100">
                Batal
            </button>
            <button type="submit" class="px-5 py-2 bg-[#F58025] hover:bg-orange-600 text-white rounded-lg shadow">
                Simpan
            </button>
        </div>
    </form>
</dialog>

<?= $this->endSection() ?>
