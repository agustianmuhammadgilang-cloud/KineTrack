<?= $this->extend('layout/staff_template') ?>
<?= $this->section('content') ?>

<div class="max-w-lg mx-auto">

    <!-- HEADER -->
    <div class="mb-8 text-center">
        <h4 class="text-2xl font-semibold text-gray-800">
            Ajukan Kategori Dokumen
        </h4>
        <p class="text-sm text-gray-500 mt-1">
            Kategori akan direview oleh admin sebelum digunakan
        </p>
    </div>

    <!-- ERROR -->
    <?php if (session()->getFlashdata('error')): ?>
        <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <!-- CARD -->
    <div class="bg-white rounded-2xl shadow-sm border p-6">

        <form action="<?= base_url('staff/kategori/ajukan/store') ?>"
              method="post"
              class="space-y-6">

            <!-- NAMA -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Nama Kategori <span class="text-red-500">*</span>
                </label>
                <input type="text"
                       name="nama_kategori"
                       required
                       placeholder="Contoh: Kerja Sama, Sarana Prasarana"
                       class="w-full rounded-lg border px-4 py-2.5
                              focus:ring-orange-500 focus:border-orange-500">
                <p class="text-xs text-gray-500 mt-1">
                    Gunakan nama yang singkat dan jelas
                </p>
            </div>

            <!-- DESKRIPSI -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Deskripsi (Opsional)
                </label>
                <textarea name="deskripsi"
                          rows="3"
                          placeholder="Kategori ini digunakan untuk dokumen apa?"
                          class="w-full rounded-lg border px-4 py-2.5
                                 focus:ring-orange-500 focus:border-orange-500"></textarea>
            </div>

            <!-- ACTION -->
            <div class="flex flex-col-reverse sm:flex-row sm:justify-between gap-3 pt-4 border-t">

                <a href="<?= base_url('staff/dokumen/create') ?>"
                   class="inline-flex justify-center items-center
                          text-sm text-gray-500 hover:text-gray-700 transition">
                    ← Kembali ke Upload Dokumen
                </a>

                <button type="submit"
                        class="inline-flex justify-center items-center gap-2
                               bg-orange-500 hover:bg-orange-600
                               text-white px-6 py-2.5 rounded-xl
                               shadow-sm transition">

                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 5v14M5 12h14"/>
                    </svg>

                    Ajukan Kategori
                </button>
            </div>

        </form>

    </div>

</div>

<?= $this->endSection() ?>
