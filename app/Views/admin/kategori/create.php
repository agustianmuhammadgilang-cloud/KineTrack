<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<h1 class="text-2xl font-bold text-[#1D2F83] mb-6">
    <?= isset($kategori) ? '✏️ Edit' : '➕ Tambah' ?> Kategori Dokumen
</h1>

<div class="bg-white rounded-xl shadow p-6 max-w-xl">
<form method="post"
      action="<?= isset($kategori)
        ? base_url('admin/kategori-dokumen/update/'.$kategori['id'])
        : base_url('admin/kategori-dokumen/store') ?>"
      class="space-y-5">

<div>
    <label class="text-sm font-medium text-gray-700">Nama Kategori</label>
    <input type="text" name="nama_kategori" required
           value="<?= esc($kategori['nama_kategori'] ?? '') ?>"
           class="w-full mt-1 border rounded-lg px-3 py-2 focus:ring-[#F58025] focus:border-[#F58025]">
</div>

<div>
    <label class="text-sm font-medium text-gray-700">Deskripsi</label>
    <textarea name="deskripsi" rows="3"
              class="w-full mt-1 border rounded-lg px-3 py-2"><?= esc($kategori['deskripsi'] ?? '') ?></textarea>
</div>

<div class="flex justify-end gap-3 pt-2">
    <a href="<?= base_url('admin/kategori-dokumen') ?>"
       class="px-4 py-2 border rounded-lg text-gray-600">
        Batal
    </a>
    <button class="px-5 py-2 bg-[#F58025] text-white rounded-lg shadow">
        Simpan
    </button>
</div>

</form>
</div>

<?= $this->endSection() ?>
