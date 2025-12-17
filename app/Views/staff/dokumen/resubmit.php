<?= $this->extend('layout/staff_template') ?>
<?= $this->section('content') ?>

<div class="max-w-xl mx-auto">

    <h4 class="text-xl font-semibold mb-4">Revisi Dokumen</h4>

    <!-- Catatan Penolakan -->
    <div class="bg-red-100 border border-red-400 p-4 mb-6 rounded">
        <strong class="block mb-1">Catatan Penolakan:</strong>
        <p class="text-red-700"><?= esc($dokumen['catatan']) ?></p>
    </div>

    <form action="<?= base_url('staff/dokumen/resubmit/'.$dokumen['id']) ?>"
          method="post" enctype="multipart/form-data"
          class="space-y-4 bg-white p-6 rounded shadow">

        <?= csrf_field() ?>

        <!-- Judul -->
        <div>
            <label class="block mb-1 font-medium">Judul</label>
            <input type="text"
                   name="judul"
                   value="<?= esc($dokumen['judul']) ?>"
                   class="w-full border px-3 py-2 rounded"
                   required>
        </div>

        <!-- Deskripsi -->
        <div>
            <label class="block mb-1 font-medium">Deskripsi</label>
            <textarea name="deskripsi"
                      class="w-full border px-3 py-2 rounded"
                      rows="4"><?= esc($dokumen['deskripsi']) ?></textarea>
        </div>

        <!-- File -->
        <div>
            <label class="block mb-1 font-medium">Upload File Baru</label>
            <input type="file"
                   name="file"
                   class="w-full border px-3 py-2 rounded"
                   required>
        </div>

        <!-- Action -->
        <div class="flex gap-3">
            <button type="submit"
                    class="bg-orange-600 hover:bg-orange-700 text-white px-5 py-2 rounded">
                Kirim Ulang
            </button>

            <a href="<?= base_url('staff/dokumen') ?>"
               class="px-5 py-2 border rounded text-gray-600 hover:bg-gray-100">
                Batal
            </a>
        </div>

    </form>
</div>

<?= $this->endSection() ?>
