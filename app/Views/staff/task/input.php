<?= $this->extend('layout/staff_template') ?>
<?= $this->section('content') ?>

<h3 class="text-2xl font-bold text-[var(--polban-blue)] mb-6">
    Input Pengukuran Indikator — TW <?= esc($tw) ?>
</h3>

<!-- PIC Info -->
<div class="bg-white shadow-md rounded-xl p-5 mb-6 border border-gray-200">
    <h4 class="text-lg font-semibold text-gray-800 mb-3">PIC Terkait</h4>

    <p class="text-gray-700">
        <span class="font-semibold"><?= esc($pic['nama']) ?></span>
        (<?= esc($pic['email']) ?>)
    </p>
    <p class="text-sm text-gray-600">
        <?= esc($pic['nama_bidang']) ?> / <?= esc($pic['nama_jabatan']) ?>
    </p>
</div>

<!-- Sasaran & Indikator -->
<div class="bg-white shadow-md rounded-xl p-5 mb-6 border border-gray-200">
    <h4 class="text-lg font-semibold text-gray-800 mb-3">Sasaran Strategis & Indikator</h4>

    <p class="text-gray-700 mb-1">
        <span class="font-semibold">Sasaran Strategis:</span> <?= esc($sasaran['nama_sasaran']) ?>
    </p>
    <p class="text-gray-700 mb-1">
        <span class="font-semibold">Indikator:</span> <?= esc($indikator['nama_indikator']) ?>
    </p>
    <p class="text-gray-700 mb-1">
        <span class="font-semibold">Satuan:</span> <?= esc($indikator['satuan']) ?>
    </p>
    <p class="text-gray-700 mb-1">
        <span class="font-semibold">Target PK (<?= esc($tahun) ?>):</span> <?= esc($indikator['target_pk']) ?>
    </p>
</div>

<!-- Informasi Target TW -->
<div class="bg-blue-50 border border-blue-200 p-5 rounded-xl mb-6">
    <h4 class="font-semibold text-blue-800 mb-3">Informasi Target Triwulan</h4>

    <div class="grid grid-cols-2 gap-3 text-gray-700">
        <p><span class="font-semibold">Target TW 1:</span> <?= esc($target_tw[1] ?? '-') ?></p>
        <p><span class="font-semibold">Target TW 2:</span> <?= esc($target_tw[2] ?? '-') ?></p>
        <p><span class="font-semibold">Target TW 3:</span> <?= esc($target_tw[3] ?? '-') ?></p>
        <p><span class="font-semibold">Target TW 4:</span> <?= esc($target_tw[4] ?? '-') ?></p>
    </div>

    <p class="mt-3 text-sm text-blue-700">
        Triwulan yang sedang dibuka: <strong>TW <?= esc($tw) ?></strong>
    </p>
</div>

<!-- FORM INPUT -->
<div class="bg-white shadow-md rounded-xl p-6 border border-gray-200">
    <form action="<?= base_url('staff/task/store') ?>" method="post" enctype="multipart/form-data" class="space-y-5">

        <!-- HIDDEN INPUTS -->
        <input type="hidden" name="indikator_id" value="<?= esc($indikator_id) ?>">
        <input type="hidden" name="triwulan" value="<?= esc($tw) ?>">
        <input type="hidden" name="tahun" value="<?= esc($tahun) ?>">

        <!-- Realisasi -->
        <div>
            <label class="block font-medium mb-1 text-gray-700">Realisasi</label>
            <input type="number" name="realisasi" step="any" min="0" required
                   class="w-full rounded-lg border border-gray-300 px-3 py-2
                          focus:ring-2 focus:ring-[var(--polban-blue)] focus:outline-none">
        </div>

        <!-- Progress -->
        <div>
            <label class="block font-medium mb-1 text-gray-700">Progress / Kegiatan</label>
            <textarea name="progress" rows="3"
                      class="w-full rounded-lg border border-gray-300 px-3 py-2
                             focus:ring-2 focus:ring-[var(--polban-blue)] focus:outline-none"></textarea>
        </div>

        <!-- Kendala -->
        <div>
            <label class="block font-medium mb-1 text-gray-700">Kendala / Permasalahan</label>
            <textarea name="kendala" rows="3"
                      class="w-full rounded-lg border border-gray-300 px-3 py-2
                             focus:ring-2 focus:ring-[var(--polban-blue)] focus:outline-none"></textarea>
        </div>

        <!-- Strategi -->
        <div>
            <label class="block font-medium mb-1 text-gray-700">Strategi / Tindak Lanjut</label>
            <textarea name="strategi" rows="3"
                      class="w-full rounded-lg border border-gray-300 px-3 py-2
                             focus:ring-2 focus:ring-[var(--polban-blue)] focus:outline-none"></textarea>
        </div>

        <!-- MULTIPLE FILE UPLOAD -->
        <!-- MULTIPLE FILE UPLOAD -->
<div x-data="fileUpload()" class="space-y-2">
    <label class="block font-medium mb-1 text-gray-700">File Dukung (Boleh lebih dari 1 file)</label>

    <!-- DROPZONE -->
    <div
        class="flex flex-col items-center justify-center w-full p-5 border-2 border-dashed border-gray-300 rounded-xl cursor-pointer bg-gray-50 hover:bg-gray-100 transition"
        @click="$refs.input.click()"
        @dragover.prevent="drag = true"
        @dragleave.prevent="drag = false"
        @drop.prevent="handleDrop($event)"
        :class="drag ? 'border-blue-500 bg-blue-50' : ''"
    >
        <svg class="w-10 h-10 text-gray-400 mb-2" fill="none" stroke="currentColor" stroke-width="1.8"
             viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M3 15a4 4 0 004 4h10a4 4 0 004-4M7 10l5-5m0 0l5 5m-5-5v12"/>
        </svg>

        <p class="text-gray-600 text-sm">
            <span class="font-semibold">Klik</span> atau <span class="font-semibold">Drag & Drop</span> file ke sini
        </p>

        <input type="file" name="file_dukung[]" multiple class="hidden" x-ref="input" @change="handleFileSelect">
    </div>

    <!-- FILE LIST -->
    <template x-if="files.length > 0">
        <ul class="space-y-2 mt-3">
            <template x-for="(file, index) in files" :key="index">
                <li class="flex items-center justify-between bg-white p-3 rounded-lg shadow border">
                    <div class="flex items-center space-x-3">
                        <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" stroke-width="1.8"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M3 7a2 2 0 012-2h10l4 4v9a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                        </svg>
                        <p class="text-gray-700 text-sm" x-text="file.name"></p>
                    </div>

                    <button type="button" @click="removeFile(index)"
                            class="text-red-600 hover:text-red-800 text-sm font-medium">
                        Hapus
                    </button>
                </li>
            </template>
        </ul>
    </template>
</div>

<!-- Alpine Script -->

        <button type="submit"
                class="px-5 py-2 bg-[var(--polban-blue)] text-white rounded-lg font-medium shadow
                       hover:bg-blue-700 transition">
            Simpan
        </button>
    </form>
</div>

<?= $this->endSection() ?>
