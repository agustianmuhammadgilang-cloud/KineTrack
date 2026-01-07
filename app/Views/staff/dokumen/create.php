<?= $this->extend('layout/staff_template') ?>
<?= $this->section('content') ?>

<?php
$kategoriOptions = [];
foreach ($kategori as $k) {
    $statusClass = '';
    $statusIcon = '';
    switch ($k['status']) {
        case 'aktif':
            $statusClass = 'bg-green-50 text-green-600 border-green-100';
            $statusIcon = 'Resmi';
            break;
        case 'pending':
            $statusClass = 'bg-yellow-50 text-yellow-600 border-yellow-100';
            $statusIcon = 'Pending';
            break;
        case 'rejected':
            $statusClass = 'bg-red-50 text-red-600 border-red-100';
            $statusIcon = 'Ditolak';
            break;
    }
    $kategoriOptions[] = [
        'id' => $k['id'],
        'nama' => esc($k['nama_kategori']),
        'status_html' => "<span class='text-[10px] uppercase tracking-wider font-bold px-1.5 py-0.5 rounded border {$statusClass}'>{$statusIcon}</span>"
    ];
}
?>

<div class="max-w-xl mx-auto my-4" x-data="wizardForm(<?= esc(json_encode($kategoriOptions)) ?>)">

    <div class="mb-6">
        <h4 class="text-xl font-bold text-gray-800">Upload Dokumen</h4>
        <p class="text-xs text-gray-500 mt-0.5">Lengkapi form dan unggah berkas Anda.</p>
    </div>

    <div class="mb-6">
        <div class="flex items-center gap-2 h-1.5">
            <template x-for="n in 2">
                <div class="flex-1 h-full rounded-full transition-all duration-300"
                     :class="step >= n ? 'bg-orange-500' : 'bg-gray-200'"></div>
            </template>
        </div>
    </div>

    <form action="<?= base_url('staff/dokumen/store') ?>"
          method="post"
          enctype="multipart/form-data"
          @submit="submitForm"
          class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 space-y-4">

        <div x-show="step === 1" x-transition>
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Judul Dokumen <span class="text-red-500">*</span></label>
                    <input type="text" name="judul" x-model="judul" @input="validate"
                           placeholder="Nama dokumen..."
                           class="w-full rounded-lg border-gray-300 text-sm focus:ring-orange-500 py-2 px-3"
                           :class="errors.judul ? 'border-red-500' : ''">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Deskripsi</label>
                    <textarea name="deskripsi" rows="2" placeholder="Keterangan..."
                              class="w-full rounded-lg border-gray-300 text-sm focus:ring-orange-500 py-2 px-3"></textarea>
                </div>

                <div class="relative" @click.away="dropdownOpen = false">
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Kategori <span class="text-red-500">*</span></label>
                    <input type="hidden" name="kategori_id" x-model="kategori">
                    <button type="button" @click="dropdownOpen = !dropdownOpen"
                            class="w-full text-left bg-white border rounded-lg py-2 px-3 text-sm flex items-center justify-between transition-all"
                            :class="errors.kategori ? 'border-red-500' : 'border-gray-300 hover:border-orange-400'">
                        <span x-text="kategoriLabel || 'Pilih kategori...'" :class="!kategoriLabel ? 'text-gray-400' : 'text-gray-800'"></span>
                        <svg class="w-4 h-4 text-gray-400" :class="dropdownOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-width="2"/></svg>
                    </button>

                    <div x-show="dropdownOpen" class="absolute z-20 w-full mt-1 bg-white rounded-lg shadow-lg border border-gray-100 max-h-48 overflow-auto">
                        <ul class="py-1">
                            <template x-for="opt in optionsList" :key="opt.id">
                                <li @click="selectKategori(opt)" class="px-3 py-2 hover:bg-orange-50 cursor-pointer flex items-center justify-between text-sm">
                                    <span x-text="opt.nama"></span>
                                    <span x-html="opt.status_html"></span>
                                </li>
                            </template>
                        </ul>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Jenis Dokumen <span class="text-red-500">*</span></label>
                    <select name="scope" class="w-full rounded-lg border-gray-300 text-sm py-2 px-3 bg-white">
                        <option value="personal">Dokumen Pribadi</option>
                        <option value="unit">Dokumen Unit</option>
                        <option value="public">Dokumen Publik</option>
                    </select>
                </div>
            </div>
        </div>

        <div x-show="step === 2" x-transition>
            <label class="block text-xs font-semibold text-gray-700 mb-2 text-center">Upload File <span class="text-red-500">*</span></label>
            <div @dragover.prevent="drag=true" @dragleave="drag=false" @drop.prevent="handleDrop($event)"
                 :class="drag ? 'border-orange-500 bg-orange-50' : 'border-gray-300 bg-gray-50'"
                 class="border-2 border-dashed rounded-xl p-6 text-center transition-all cursor-pointer"
                 @click="$refs.file.click()">
                
                <input type="file" name="file" x-ref="file" @change="handleFile" class="hidden">

                <div x-show="!file">
                    <svg class="w-8 h-8 text-orange-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" stroke-width="2"/></svg>
                    <p class="text-sm font-medium text-gray-700">Pilih berkas</p>
                    <p class="text-[10px] text-gray-400 mt-1">Klik atau seret file ke sini</p>
                </div>

                <div x-show="file" class="flex items-center justify-between bg-white border rounded-lg p-2 shadow-sm" @click.stop>
                    <div class="flex items-center gap-2 overflow-hidden text-left">
                        <div class="bg-orange-50 p-1.5 rounded text-orange-500 shrink-0">
                             <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" stroke-width="2"/></svg>
                        </div>
                        <div class="truncate">
                            <p class="text-xs font-semibold text-gray-800 truncate" x-text="file?.name"></p>
                            <p class="text-[10px] text-gray-500" x-text="file ? (file.size/1024/1024).toFixed(2) + ' MB' : ''"></p>
                        </div>
                    </div>
                    <button type="button" @click="removeFile" class="text-gray-400 hover:text-red-500 p-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-width="2"/></svg>
                    </button>
                </div>
            </div>
        </div>

        <div class="flex justify-between items-center pt-4 border-t border-gray-50">
            <button type="button" x-show="step > 1" @click="step--" class="text-xs text-gray-500 font-medium px-3 py-2 hover:bg-gray-100 rounded-lg">← Kembali</button>
            <div x-show="step === 1"></div>
            
            <button type="button" x-show="step === 1" @click="nextStep"
                    class="bg-orange-500 hover:bg-orange-600 text-white text-sm font-bold px-5 py-2 rounded-lg shadow-sm transition-all transform active:scale-95">
                Lanjut
            </button>

            <button type="submit" x-show="step === 2" :disabled="loading"
                    class="bg-orange-500 hover:bg-orange-600 text-white text-sm font-bold px-5 py-2 rounded-lg shadow-sm flex items-center gap-2 disabled:opacity-50">
                <svg x-show="loading" class="w-3 h-3 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" class="opacity-25"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                <span x-text="loading ? 'Mengirim...' : 'Kirim Dokumen'"></span>
            </button>
        </div>
    </form>
</div>

<script>
function wizardForm(optionsData = []) {
    return {
        step: 1, drag: false, file: null, loading: false,
        judul: '', kategori: '', errors: {},
        optionsList: optionsData, dropdownOpen: false, kategoriLabel: '',

        selectKategori(option) {
            this.kategori = option.id;
            this.kategoriLabel = option.nama;
            this.dropdownOpen = false;
            this.validate();
        },
        validate() {
            this.errors = {};
            if (!this.judul) this.errors.judul = true;
            if (!this.kategori) this.errors.kategori = true;
        },
        nextStep() {
            this.validate();
            if (Object.keys(this.errors).length === 0) this.step = 2;
        },
        handleFile(e) { this.file = e.target.files[0]; },
        handleDrop(e) {
            this.drag = false;
            if (e.dataTransfer && e.dataTransfer.files.length > 0) {
                this.file = e.dataTransfer.files[0];
                this.$refs.file.files = e.dataTransfer.files;
            }
        },
        removeFile() { this.file = null; this.$refs.file.value = ''; },
        submitForm(e) {
            if (!this.file) { e.preventDefault(); alert('File wajib diupload'); return; }
            this.loading = true;
        }
    }
}
</script>
<?= $this->endSection() ?>