<?= $this->extend('layout/staff_template') ?>
<?= $this->section('content') ?>

<style>
    :root {
        --polban-blue: #1D2F83;
        --polban-blue-light: #004a94;
        --polban-gold: #D4AF37;
        --slate-soft: #f8fafc;
        --transition-smooth: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .form-card {
        background: white;
        border-radius: 32px;
        border: 1px solid #eef2f6;
        box-shadow: 0 20px 50px -12px rgba(0, 51, 102, 0.08);
    }

    .input-field {
        transition: var(--transition-smooth);
        border: 1.5px solid #e2e8f0;
        background-color: white;
    }

    .input-field:focus {
        border-color: var(--polban-blue);
        box-shadow: 0 0 0 4px rgba(0, 51, 102, 0.05);
        outline: none;
    }

    .btn-polban {
        transition: var(--transition-smooth);
        background: var(--polban-blue);
    }

    .btn-polban:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px -5px rgba(0, 51, 102, 0.3);
        filter: brightness(1.1);
    }

    .info-badge {
        background: linear-gradient(135deg, rgba(0, 51, 102, 0.03) 0%, rgba(212, 175, 55, 0.05) 100%);
        border-left: 4px solid var(--polban-gold);
    }
</style>

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

<div class="px-4 py-8 max-w-5xl mx-auto" x-data="documentForm(<?= esc(json_encode($kategoriOptions)) ?>)">
    <div class="flex items-center gap-5 mb-10">
        <div class="w-14 h-14 bg-blue-50 border border-blue-100 rounded-2xl flex items-center justify-center shadow-sm text-blue-900">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
        </div>
        <div>
            <h4 class="text-2xl font-black text-blue-900 tracking-tight">
                Upload <span class="text-blue-600">Dokumen Baru</span>
            </h4>
            <p class="text-[11px] text-slate-400 font-semibold uppercase tracking-[0.2em] mt-1">
                Manajemen Arsip Digital — Lengkapi Detail & Lampiran
            </p>
        </div>
    </div>

    <div class="form-card overflow-hidden">
        <div class="p-8 md:p-12">
            
            <div class="info-badge p-6 rounded-3xl mb-10">
                <div class="flex items-start gap-4">
                    <div class="shrink-0 w-10 h-10 bg-white rounded-xl flex items-center justify-center text-blue-600 shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-blue-900 uppercase tracking-widest mb-1">Catatan Penting</p>
                        <p class="text-xs text-slate-600 font-medium leading-relaxed">
                            Pastikan judul dan kategori sesuai. Dokumen yang diunggah akan melalui proses verifikasi oleh atasan unit sebelum dipublikasikan secara resmi.
                        </p>
                    </div>
                </div>
            </div>

            <form action="<?= base_url('staff/dokumen/store') ?>" method="POST" enctype="multipart/form-data" class="space-y-8" @submit="handleSubmit">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="md:col-span-2 space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Judul Dokumen <span class="text-rose-500">*</span></label>
                        <input type="text" name="judul" required placeholder="Contoh: Laporan Kegiatan Triwulan I"
                               class="input-field w-full px-5 py-4 rounded-2xl text-blue-900 font-bold text-lg bg-slate-50/50">
                    </div>

                    <div class="space-y-2 relative" @click.away="dropdownOpen = false">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Kategori Berkas <span class="text-rose-500">*</span></label>
                        <input type="hidden" name="kategori_id" x-model="kategoriId">
                        <button type="button" @click="dropdownOpen = !dropdownOpen"
                                class="input-field w-full px-5 py-4 rounded-2xl text-blue-900 font-bold text-sm bg-white flex items-center justify-between">
                            <span x-text="kategoriLabel || 'Pilih kategori...'" :class="!kategoriLabel ? 'text-slate-400' : ''"></span>
                            <svg class="w-5 h-5 text-slate-400" :class="dropdownOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-width="2.5"/></svg>
                        </button>

                        <div x-show="dropdownOpen" class="absolute z-30 w-full mt-2 bg-white rounded-2xl shadow-2xl border border-slate-100 max-h-60 overflow-y-auto p-2">
                            <template x-for="opt in optionsList" :key="opt.id">
                                <div @click="selectKategori(opt)" 
                                     class="px-4 py-3 hover:bg-blue-50 rounded-xl cursor-pointer flex items-center justify-between group">
                                    <span class="text-sm font-bold text-slate-700 group-hover:text-blue-600" x-text="opt.nama"></span>
                                    <span x-html="opt.status_html"></span>
                                </div>
                            </template>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Visibilitas Akses <span class="text-rose-500">*</span></label>
                        <select name="scope" class="input-field w-full px-5 py-4 rounded-2xl text-blue-900 font-bold text-sm bg-white appearance-none cursor-pointer">
                            <option value="personal">🔒 Hanya Saya (Personal)</option>
                            <option value="unit">👥 Anggota Unit</option>
                            <option value="public">🌐 Publik (Terverifikasi)</option>
                        </select>
                    </div>

                    <div class="md:col-span-2 space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Deskripsi / Keterangan</label>
                        <textarea name="deskripsi" rows="3" 
                                  placeholder="Tambahkan catatan mengenai isi dokumen ini..."
                                  class="input-field w-full px-5 py-4 rounded-2xl text-blue-900 font-medium text-sm"></textarea>
                    </div>
                </div>

                <div class="space-y-3">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Lampiran Berkas Digital</label>
                    <div class="relative group">
                        <input type="file" name="file" id="file_dokumen" class="hidden" @change="updateFileName">
                        <label for="file_dokumen" class="flex flex-col items-center justify-center border-2 border-dashed border-slate-200 rounded-3xl p-10 hover:bg-blue-50/50 hover:border-blue-400 transition-all cursor-pointer bg-slate-50/30">
                            <div class="w-14 h-14 bg-white rounded-2xl shadow-sm flex items-center justify-center mb-4 text-blue-600 group-hover:scale-110 transition-transform">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </div>
                            <p class="text-sm font-bold text-blue-900" x-text="fileName || 'Pilih berkas atau tarik ke sini'"></p>
                            <p class="text-[10px] text-slate-400 mt-1 uppercase font-black">PDF, JPG, PNG (Maks 5MB)</p>
                        </label>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 pt-8 border-t border-slate-50">
                    <button type="submit" class="btn-polban flex-1 text-white font-black py-4 rounded-2xl uppercase tracking-widest text-xs shadow-lg shadow-blue-900/10" :disabled="isLoading">
                        <span x-text="isLoading ? 'Sedang Mengunggah...' : 'Finalisasi & Simpan'"></span>
                    </button>
                    <a href="<?= base_url('staff/dokumen') ?>" class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-500 font-black py-4 rounded-2xl uppercase tracking-widest text-xs text-center transition-colors">
                        Batal & Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="mt-10 text-center">
        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">
            © <?= date('Y') ?> Kinetrack — Politeknik Negeri Bandung
        </p>
    </div>
</div>

<script>
function documentForm(optionsData) {
    return {
        dropdownOpen: false,
        kategoriId: '',
        kategoriLabel: '',
        fileName: '',
        isLoading: false,
        optionsList: optionsData,

        selectKategori(opt) {
            this.kategoriId = opt.id;
            this.kategoriLabel = opt.nama;
            this.dropdownOpen = false;
        },

        updateFileName(e) {
            if (e.target.files.length > 0) {
                this.fileName = e.target.files[0].name;
            }
        },

        handleSubmit() {
            if (!this.kategoriId) {
                alert('Silakan pilih kategori terlebih dahulu');
                return false;
            }
            this.isLoading = true;
        }
    }
}
</script>

<?= $this->endSection() ?>