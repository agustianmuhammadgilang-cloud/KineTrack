<?= $this->extend('layout/staff_template') ?>
<?= $this->section('content') ?>

<div class="max-w-2xl mx-auto">

    <div class="mb-6">
        <h4 class="text-2xl font-semibold text-gray-800">Upload Dokumen</h4>
        <p class="text-sm text-gray-500">Unggah dokumen untuk diproses oleh atasan</p>
    </div>

    <div class="bg-white shadow rounded-lg p-6">
        <form action="<?= base_url('staff/dokumen/store') ?>" method="post" enctype="multipart/form-data" class="space-y-5">

            <!-- JUDUL -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Judul Dokumen</label>
                <input type="text" name="judul" required
                       class="w-full border-gray-300 rounded-lg px-3 py-2 focus:ring-orange-500 focus:border-orange-500">
            </div>

            <!-- DESKRIPSI -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                <textarea name="deskripsi" rows="3"
                          class="w-full border-gray-300 rounded-lg px-3 py-2 focus:ring-orange-500 focus:border-orange-500"></textarea>
            </div>

            <!-- KATEGORI DOKUMEN (BARU) -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Kategori Dokumen <span class="text-red-500">*</span>
                </label>

                <select name="kategori_id" required
                        class="w-full border-gray-300 rounded-lg px-3 py-2 focus:ring-orange-500 focus:border-orange-500">
                    <option value="">-- Pilih Kategori --</option>

                    <?php foreach ($kategori as $k): ?>
                        <option value="<?= $k['id'] ?>">
                            <?= esc($k['nama_kategori']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <!-- JENIS DOKUMEN -->
<div>
    <label class="block text-sm font-medium text-gray-700 mb-1">
        Jenis Dokumen <span class="text-red-500">*</span>
    </label>

    <select name="scope" required
            class="w-full border-gray-300 rounded-lg px-3 py-2 focus:ring-orange-500 focus:border-orange-500">
        <option value="unit">Dokumen Unit</option>
        <option value="personal">Dokumen Pribadi</option>
    </select>

    <p class="text-xs text-gray-500 mt-1">
        Dokumen pribadi hanya dapat dilihat oleh Anda sendiri.
    </p>
</div>


                <p class="text-xs text-gray-500 mt-1">
                    Kategori tidak tersedia?
                    <a href="<?= base_url('staff/kategori/ajukan') ?>"
                       class="text-orange-600 hover:underline">
                        Ajukan kategori baru
                    </a>
                </p>
            </div>

            <!-- FILE -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">File Dokumen</label>
                <input type="file" name="file" required
                       class="w-full border border-dashed border-gray-300 rounded-lg p-3 text-sm">
            </div>

            <!-- ACTION -->
            <div class="flex items-center justify-between pt-4">
                <a href="<?= base_url('staff/dokumen') ?>" class="text-gray-500 hover:text-gray-700">
                    ← Kembali
                </a>

                <button class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded-lg shadow">
                    Kirim Dokumen
                </button>
            </div>

        </form>
    </div>
</div>

<?= $this->endSection() ?>
