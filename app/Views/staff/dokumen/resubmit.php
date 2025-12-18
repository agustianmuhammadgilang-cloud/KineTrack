<?= $this->extend('layout/staff_template') ?>
<?= $this->section('content') ?>

<div class="max-w-2xl mx-auto space-y-8">

    <!-- HEADER -->
    <div>
        <h4 class="text-2xl font-semibold text-gray-800">
            Revisi Dokumen
        </h4>
        <p class="text-sm text-gray-500 mt-1">
            Perbaiki dokumen sesuai catatan dari atasan
        </p>
    </div>

    <!-- CATATAN PENOLAKAN -->
    <div class="bg-red-50 border-l-4 border-red-500 rounded-lg p-5">
        <div class="flex items-start gap-3">
            <svg class="w-6 h-6 text-red-500 mt-1" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M12 9v2m0 4h.01M5.07 19h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.34 16c-.77 1.33.19 3 1.73 3z"/>
            </svg>

            <div>
                <h6 class="font-semibold text-red-700">
                    Catatan Penolakan
                </h6>
                <p class="text-sm text-red-700 mt-1 leading-relaxed">
                    <?= esc($dokumen['catatan']) ?>
                </p>
            </div>
        </div>
    </div>

    <!-- FORM -->
    <form action="<?= base_url('staff/dokumen/resubmit/'.$dokumen['id']) ?>"
          method="post"
          enctype="multipart/form-data"
          class="bg-white rounded-2xl shadow-sm border p-8 space-y-6">

        <?= csrf_field() ?>

        <!-- JUDUL -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Judul Dokumen
            </label>
            <input type="text"
                   name="judul"
                   value="<?= esc($dokumen['judul']) ?>"
                   required
                   class="w-full rounded-lg border-gray-300 px-4 py-2
                          focus:border-orange-500 focus:ring-orange-500">
        </div>

        <!-- DESKRIPSI -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Deskripsi
            </label>
            <textarea name="deskripsi"
                      rows="4"
                      class="w-full rounded-lg border-gray-300 px-4 py-2
                             focus:border-orange-500 focus:ring-orange-500"><?= esc($dokumen['deskripsi']) ?></textarea>
        </div>

        <!-- FILE -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Upload File Revisi
            </label>

            <div class="border border-dashed border-gray-300 rounded-xl p-4">
                <input type="file"
                       name="file"
                       required
                       class="w-full text-sm text-gray-600">
                <p class="text-xs text-gray-500 mt-2">
                    Pastikan file sudah diperbaiki sesuai catatan di atas.
                </p>
            </div>
        </div>

        <!-- ACTION -->
        <div class="flex items-center justify-between pt-6 border-t">

            <a href="<?= base_url('staff/dokumen') ?>"
               class="text-sm text-gray-500 hover:text-gray-700 transition">
                ← Kembali
            </a>

            <button type="submit"
                    class="inline-flex items-center gap-2
                           bg-[var(--polban-orange)]
                           hover:bg-orange-600
                           text-white px-6 py-2.5
                           rounded-lg shadow transition">
                Kirim Revisi
            </button>
        </div>

    </form>

</div>

<?= $this->endSection() ?>
