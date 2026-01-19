<?= $this->extend('layout/staff_template') ?>
<?= $this->section('content') ?>

<?php
$kategoriOptions = [];
foreach ($kategori as $k) {
    $statusClass = '';
    $statusIcon = '';
    switch ($k['status']) {
        case 'aktif':
            $statusClass = 'bg-emerald-50 text-emerald-600 border-emerald-100';
            $statusIcon = 'Resmi';
            break;
        case 'pending':
            $statusClass = 'bg-amber-50 text-amber-600 border-amber-100';
            $statusIcon = 'Pending';
            break;
        case 'rejected':
            $statusClass = 'bg-rose-50 text-rose-600 border-rose-100';
            $statusIcon = 'Ditolak';
            break;
    }
    $kategoriOptions[] = [
        'id' => $k['id'],
        'nama' => esc($k['nama_kategori']),
        'status_html' => "<span class='text-[9px] uppercase tracking-tighter font-black px-2 py-0.5 rounded-lg border {$statusClass}'>{$statusIcon}</span>"
    ];
}
?>

<div class="max-w-2xl mx-auto my-8 font-sans" x-data="wizardForm(<?= esc(json_encode($kategoriOptions)) ?>)">

    <div class="flex items-center gap-5 mb-8">
        <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center text-blue-600 shadow-xl shadow-blue-900/5 border border-slate-100">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
        </div>
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight leading-none">Upload Dokumen</h1>
            <p class="text-xs text-slate-400 mt-2 font-bold uppercase tracking-widest">Lengkapi Detail Berkas & Verifikasi</p>
        </div>
    </div>

    <div class="mb-10 px-2">
        <div class="flex items-center gap-3 h-2">
            <template x-for="n in 2">
                <div class="flex-1 h-full rounded-full transition-all duration-500"
                     :class="step >= n ? 'bg-blue-600 shadow-lg shadow-blue-200' : 'bg-slate-200'"></div>
            </template>
        </div>
        <div class="flex justify-between mt-3 px-1">
            <span class="text-[10px] font-black uppercase tracking-tighter" :class="step >= 1 ? 'text-blue-600' : 'text-slate-400'">Informasi Dasar</span>
            <span class="text-[10px] font-black uppercase tracking-tighter" :class="step >= 2 ? 'text-blue-600' : 'text-slate-400'">Lampiran Berkas</span>
        </div>
    </div>

    <form action="<?= base_url('staff/dokumen/store') ?>"
          method="post"
          enctype="multipart/form-data"
          @submit="submitForm"
          class="bg-white rounded-[2.5rem] shadow-2xl shadow-slate-200 border border-slate-100 p-8 md:p-10 space-y-6">

        <div x-show="step === 1" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-x-4">
            <div class="space-y-6">
                <div>
                    <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Judul Dokumen <span class="text-rose-500">*</span></label>
                    <input type="text" name="judul" x-model="judul" @input="validate"
                           placeholder="E.g. Laporan Kinerja Bulanan Januari"
                           class="w-full rounded-2xl border-slate-200 bg-slate-50/50 text-sm font-bold focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all py-3.5 px-5"
                           :class="errors.judul ? 'border-rose-500 bg-rose-50' : ''">
                </div>

                <div>
                    <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Deskripsi Singkat</label>
                    <textarea name="deskripsi" rows="3" placeholder="Tambahkan keterangan tambahan jika diperlukan..."
                              class="w-full rounded-2xl border-slate-200 bg-slate-50/50 text-sm font-bold focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all py-3.5 px-5"></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="relative" @click.away="dropdownOpen = false">
                        <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Kategori Berkas <span class="text-rose-500">*</span></label>
                        <input type="hidden" name="kategori_id" x-model="kategori">
                        <button type="button" @click="dropdownOpen = !dropdownOpen"
                                class="w-full text-left bg-slate-50/50 border rounded-2xl py-3.5 px-5 text-sm font-bold flex items-center justify-between transition-all"
                                :class="errors.kategori ? 'border-rose-500 bg-rose-50' : 'border-slate-200 hover:border-blue-400 focus:ring-4 focus:ring-blue-100'">
                            <span x-text="kategoriLabel || 'Pilih kategori...'" :class="!kategoriLabel ? 'text-slate-400' : 'text-slate-900'"></span>
                            <svg class="w-5 h-5 text-slate-400 transition-transform" :class="dropdownOpen ? 'rotate-180 text-blue-500' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-width="2.5"/></svg>
                        </button>

                        <div x-show="dropdownOpen" 
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="opacity-0 scale-95"
                             class="absolute z-30 w-full mt-2 bg-white rounded-2xl shadow-2xl border border-slate-100 max-h-60 overflow-y-auto p-2">
                            <template x-for="opt in optionsList" :key="opt.id">
                                <div @click="selectKategori(opt)" 
                                     class="px-4 py-3 hover:bg-blue-50 rounded-xl cursor-pointer flex items-center justify-between group transition-colors">
                                    <span class="text-sm font-bold text-slate-700 group-hover:text-blue-600" x-text="opt.nama"></span>
                                    <span x-html="opt.status_html"></span>
                                </div>
                            </template>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Visibilitas <span class="text-rose-500">*</span></label>
                        <select name="scope" class="w-full rounded-2xl border-slate-200 bg-slate-50/50 text-sm font-bold py-3.5 px-5 focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all appearance-none cursor-pointer">
                            <option value="personal">🔒 Hanya Saya (Personal)</option>
                            <option value="unit">👥 Anggota Unit</option>
                            <option value="public">🌐 Publik (Terverifikasi)</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div x-show="step === 2" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-x-4">
            <div class="text-center mb-8">
                <h3 class="text-lg font-black text-slate-800">Lampirkan Berkas Digital</h3>
                <p class="text-xs text-slate-400 mt-1 font-medium text-balance">Pastikan file dalam format PDF, JPG, atau PNG dengan ukuran maks. 5MB</p>
            </div>
            
            <div @dragover.prevent="drag=true" @dragleave="drag=false" @drop.prevent="handleDrop($event)"
                 :class="drag ? 'border-blue-500 bg-blue-50/50 scale-[1.02]' : 'border-slate-200 bg-slate-50/30'"
                 class="border-4 border-dashed rounded-[2rem] p-12 text-center transition-all duration-300 cursor-pointer group relative"
                 @click="$refs.file.click()">
                
                <input type="file" name="file" x-ref="file" @change="handleFile" class="hidden">

                <div x-show="!file" class="space-y-4">
                    <div class="w-20 h-20 bg-white rounded-3xl shadow-lg mx-auto flex items-center justify-center text-blue-500 group-hover:scale-110 transition-transform">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-black text-slate-700">Tarik berkas ke sini</p>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1">Atau klik untuk menelusuri</p>
                    </div>
                </div>

                <div x-show="file" class="flex items-center gap-4 bg-white border border-slate-100 rounded-[1.5rem] p-4 shadow-xl text-left animate-bounce-short" @click.stop>
                    <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600 shrink-0">
                         <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" stroke-width="2"/></svg>
                    </div>
                    <div class="truncate flex-1">
                        <p class="text-sm font-black text-slate-800 truncate" x-text="file?.name"></p>
                        <p class="text-[10px] text-slate-400 font-black" x-text="file ? (file.size/1024/1024).toFixed(2) + ' MB' : ''"></p>
                    </div>
                    <button type="button" @click="removeFile" class="w-8 h-8 rounded-full bg-rose-50 text-rose-500 flex items-center justify-center hover:bg-rose-500 hover:text-white transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-width="2.5"/></svg>
                    </button>
                </div>
            </div>
        </div>

        <div class="flex justify-between items-center pt-8 border-t border-slate-50">
            <div>
                <button type="button" x-show="step > 1" @click="step--" 
                        class="text-xs text-slate-400 font-black uppercase tracking-widest px-6 py-3 hover:text-blue-600 transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7" stroke-width="3"/></svg>
                    Kembali
                </button>
            </div>
            
            <button type="button" x-show="step === 1" @click="nextStep"
                    class="bg-blue-600 hover:bg-slate-900 text-white text-xs font-black uppercase tracking-widest px-8 py-4 rounded-2xl shadow-xl shadow-blue-200 transition-all transform active:scale-95 flex items-center gap-2">
                Lanjutkan
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-width="3"/></svg>
            </button>

            <button type="submit" x-show="step === 2" :disabled="loading"
                    class="bg-emerald-600 hover:bg-slate-900 text-white text-xs font-black uppercase tracking-widest px-8 py-4 rounded-2xl shadow-xl shadow-emerald-200 transition-all flex items-center gap-3 disabled:opacity-50">
                <svg x-show="loading" class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" class="opacity-25"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                <span x-text="loading ? 'Memproses...' : 'Finalisasi & Unggah'"></span>
            </button>
        </div>
    </form>

    <div class="mt-8 p-6 bg-blue-50 rounded-3xl border border-blue-100 flex items-center gap-4">
        <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-blue-600 shadow-sm shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <p class="text-[11px] text-blue-700 font-bold leading-relaxed italic">
            Dokumen yang Anda unggah akan masuk ke antrean verifikasi Atasan sebelum dapat diarsipkan secara resmi. Mohon pastikan data sudah benar.
        </p>
    </div>
</div>

<style>
    .animate-bounce-short { animation: bounce-short 0.5s ease-out; }
    @keyframes bounce-short {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-5px); }
    }
</style>

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
            if (Object.keys(this.errors).length === 0) {
                this.step = 2;
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
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
            if (!this.file) { 
                e.preventDefault(); 
                alert('Silakan pilih berkas terlebih dahulu!'); 
                return; 
            }
            this.loading = true;
        }
    }
}
</script>
<?= $this->endSection() ?>