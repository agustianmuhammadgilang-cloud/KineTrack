<?= $this->extend('layout/staff_template') ?>
<?= $this->section('content') ?>

<div class="max-w-3xl mx-auto"
     x-data="wizardForm()">

    <!-- HEADER -->
    <div class="mb-8">
        <h4 class="text-2xl font-semibold text-gray-800">
            Upload Dokumen
        </h4>
        <p class="text-sm text-gray-500 mt-1">
            Lengkapi informasi dan unggah dokumen
        </p>
    </div>

    <!-- PROGRESS -->
    <div class="flex items-center gap-4 mb-6">
        <template x-for="n in 2">
            <div class="flex-1 h-2 rounded-full"
                 :class="step >= n ? 'bg-orange-500' : 'bg-gray-200'"></div>
        </template>
    </div>

    <!-- FORM -->
    <form action="<?= base_url('staff/dokumen/store') ?>"
          method="post"
          enctype="multipart/form-data"
          @submit="submitForm"
          class="bg-white rounded-xl shadow-sm border p-6 space-y-6">

        <!-- ================= STEP 1 ================= -->
        <div x-show="step === 1" x-transition>

            <div class="space-y-5">

                <!-- JUDUL -->
                <div>
                    <label class="text-sm font-medium">Judul Dokumen *</label>
                    <input type="text" name="judul" x-model="judul"
                           @input="validate"
                           class="w-full mt-1 rounded-lg border px-4 py-2.5
                                  focus:ring-orange-500 focus:border-orange-500">
                    <p x-show="errors.judul" class="text-xs text-red-500 mt-1">
                        Judul wajib diisi
                    </p>
                </div>

                <!-- DESKRIPSI -->
                <div>
                    <label class="text-sm font-medium">Deskripsi</label>
                    <textarea name="deskripsi" rows="3"
                              class="w-full mt-1 rounded-lg border px-4 py-2.5
                                     focus:ring-orange-500 focus:border-orange-500"></textarea>
                </div>

                <!-- KATEGORI -->
                <div>
                    <label class="text-sm font-medium">Kategori *</label>
                  <select name="kategori_id" x-model="kategori"
        @change="validate"
        class="w-full mt-1 rounded-lg border px-4 py-2.5">

            <option value="">Pilih kategori</option>

            <?php foreach ($kategori as $k): ?>
                <?php
                    switch ($k['status']) {
                        case 'aktif':
                            $label = '✅ Resmi';
                            $class = 'text-green-700';
                            break;
                        case 'pending':
                            $label = '⏳ Menunggu persetujuan admin';
                            $class = 'text-yellow-700';
                            break;
                        case 'rejected':
                            $label = '❌ Ditolak admin';
                            $class = 'text-red-700';
                            break;
                        default:
                            $label = '';
                            $class = '';
                    }
                ?>
                <option value="<?= $k['id'] ?>" class="<?= $class ?>">
                    <?= esc($k['nama_kategori']) ?> — <?= $label ?>
                </option>
            <?php endforeach; ?>

        </select>


                    <p x-show="errors.kategori" class="text-xs text-red-500 mt-1">
                        Pilih kategori
                    </p>
                </div>

                <!-- JENIS -->
                <div>
                    <label class="text-sm font-medium">Jenis Dokumen *</label>
                    <select name="scope" class="w-full mt-1 rounded-lg border px-4 py-2.5">
    <option value="personal">Dokumen Pribadi</option>
    <option value="unit">Dokumen Unit</option>
    <option value="public">Dokumen Publik</option>
</select>
                </div>
            </div>
        </div>

        <!-- ================= STEP 2 ================= -->
        <div x-show="step === 2" x-transition>

            <label class="text-sm font-medium mb-2 block">
                Upload File *
            </label>

            <!-- DRAG DROP -->
            <div @dragover.prevent="drag=true"
                 @dragleave="drag=false"
                 @drop.prevent="handleDrop($event)"
                 :class="drag ? 'border-orange-500 bg-orange-50' : ''"
                 class="border-2 border-dashed rounded-xl p-6 text-center transition">

                <input type="file" name="file" x-ref="file"
                       @change="handleFile"
                       class="hidden">

                <div x-show="!file">
                    <p class="text-gray-600 text-sm">
                        Drag & drop file di sini atau
                    </p>
                    <button type="button"
                            @click="$refs.file.click()"
                            class="mt-2 text-orange-600 font-medium">
                        Pilih file
                    </button>
                </div>

                <!-- PREVIEW -->
                <div x-show="file" class="flex items-center justify-between">
                    <div>
                        <p class="font-medium text-gray-700"
                           x-text="file.name"></p>
                        <p class="text-xs text-gray-500"
                           x-text="(file.size/1024/1024).toFixed(2) + ' MB'"></p>
                    </div>

                    <button type="button"
                            @click="removeFile"
                            class="text-red-500 text-sm">
                        Hapus
                    </button>
                </div>
            </div>
        </div>

        <!-- ACTION -->
        <div class="flex justify-between pt-6 border-t">

            <button type="button"
                    x-show="step > 1"
                    @click="step--"
                    class="text-gray-500">
                ← Kembali
            </button>

            <div class="flex gap-3 ml-auto">

                <button type="button"
                        x-show="step === 1"
                        @click="nextStep"
                        class="bg-orange-500 hover:bg-orange-600
                               text-white px-6 py-2.5 rounded-lg">
                    Lanjut
                </button>

                <button type="submit"
                        x-show="step === 2"
                        :disabled="loading"
                        class="bg-orange-500 hover:bg-orange-600
                               text-white px-6 py-2.5 rounded-lg
                               flex items-center gap-2">

                    <svg x-show="loading"
                         class="w-4 h-4 animate-spin"
                         fill="none" stroke="currentColor">
                        <circle cx="12" cy="12" r="10" opacity="0.3"/>
                        <path d="M12 2a10 10 0 0110 10"/>
                    </svg>

                    <span x-text="loading ? 'Mengirim...' : 'Kirim Dokumen'"></span>
                </button>
            </div>
        </div>

    </form>
</div>

<script>
function wizardForm() {
    return {
        step: 1,
        drag: false,
        file: null,
        loading: false,

        judul: '',
        kategori: '',
        errors: {},

        validate() {
            this.errors = {};
            if (!this.judul) this.errors.judul = true;
            if (!this.kategori) this.errors.kategori = true;
        },

        nextStep() {
            this.validate();
            if (Object.keys(this.errors).length === 0) {
                this.step = 2;
            }
        },

        handleFile(e) {
            this.file = e.target.files[0];
        },

        handleDrop(e) {
            this.drag = false;
            this.file = e.dataTransfer.files[0];
            this.$refs.file.files = e.dataTransfer.files;
        },

        removeFile() {
            this.file = null;
            this.$refs.file.value = '';
        },

        submitForm(e) {
            if (!this.file) {
                e.preventDefault();
                alert('File wajib diupload');
                return;
            }
            this.loading = true;
        }
    }
}
</script>

<?= $this->endSection() ?>
