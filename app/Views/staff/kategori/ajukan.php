<?= $this->extend('layout/staff_template') ?>
<?= $this->section('content') ?>

<div class="max-w-xl mx-auto">

    <h4 class="text-xl font-semibold mb-6">📤 Ajukan Kategori Dokumen</h4>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <div class="bg-white rounded shadow p-6">
        <form action="<?= base_url('staff/kategori/ajukan/store') ?>" method="post" class="space-y-5">

            <div>
                <label class="block font-medium mb-1">Nama Kategori</label>
                <input type="text" name="nama_kategori" required
                       class="w-full border rounded px-3 py-2"
                       placeholder="Contoh: Kerja Sama, Sarana Prasarana">
            </div>

            <div>
                <label class="block font-medium mb-1">Deskripsi (opsional)</label>
                <textarea name="deskripsi" rows="3"
                          class="w-full border rounded px-3 py-2"
                          placeholder="Digunakan untuk dokumen apa?"></textarea>
            </div>

            <div class="flex gap-3">
                <button class="bg-orange-500 hover:bg-orange-600 text-white px-5 py-2 rounded">
                    Ajukan
                </button>

                <a href="<?= base_url('staff/dokumen/create') ?>"
                   class="bg-gray-400 hover:bg-gray-500 text-white px-5 py-2 rounded">
                    Kembali
                </a>
            </div>

        </form>
    </div>
</div>

<?= $this->endSection() ?>
