<?= $this->extend('layout/atasan_template') ?>
<?= $this->section('content') ?>

<style>
    :root {
        --polban-blue: #003366;
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

<div class="px-4 py-8 max-w-5xl mx-auto">
    <div class="flex items-center gap-5 mb-10">
        <div class="w-14 h-14 bg-blue-50 border border-blue-100 rounded-2xl flex items-center justify-center shadow-sm text-blue-900">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
        </div>
        <div>
            <h4 class="text-2xl font-black text-blue-900 tracking-tight">
                Triwulan <?= esc($tw) ?> <span class="text-slate-400 font-light">|</span> <span class="text-blue-600">Pengukuran Atasan</span>
            </h4>
            <p class="text-[11px] text-slate-400 font-semibold uppercase tracking-[0.2em] mt-1">
                Tahun Anggaran <?= $tahun ?> — Input Capaian Kinerja Unit
            </p>
        </div>
    </div>

    <div class="form-card overflow-hidden">
        <div class="p-8 md:p-12">
            
            <div class="info-badge p-6 rounded-3xl mb-10">
                <div class="flex flex-col md:flex-row gap-6">
                    <div class="flex-1">
                        <p class="text-[10px] font-black text-blue-900 uppercase tracking-widest mb-2">Sasaran & Indikator</p>
                        <p class="text-sm font-bold text-slate-700 leading-relaxed mb-1">"<?= esc($sasaran['nama_sasaran']) ?>"</p>
                        <p class="text-xs text-slate-500 font-medium"><?= esc($indikator['nama_indikator']) ?></p>
                        
                    </div>
                    <div class="shrink-0 flex gap-8 border-t md:border-t-0 md:border-l border-slate-200 pt-4 md:pt-0 md:pl-8">
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Target PK</p>
                            <p class="text-xl font-black text-blue-900"><?= esc($indikator['target_pk']) ?> <span class="text-[10px] text-slate-400 font-bold"><?= esc($indikator['satuan']) ?></span></p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Target TW <?= $tw ?></p>
                            <p class="text-xl font-black text-amber-600"><?= esc($target_tw[$tw] ?? '0') ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <form action="<?= base_url('atasan/task/store') ?>" method="POST" enctype="multipart/form-data" class="space-y-8">
                <input type="hidden" name="indikator_id" value="<?= esc($indikator_id) ?>">
                <input type="hidden" name="triwulan" value="<?= esc($tw) ?>">
                <input type="hidden" name="tahun" value="<?= esc($tahun) ?>">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="md:col-span-2 space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Nilai Realisasi Capaian <span class="text-rose-500">*</span></label>
                        <input type="number" name="realisasi" step="any" min="0" required
                               placeholder="0.00"
                               class="input-field w-full px-5 py-4 rounded-2xl text-blue-900 font-black text-2xl bg-slate-50/50">
                    </div>

                    <div class="md:col-span-2 space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Progress / Deskripsi Kegiatan</label>
                        <textarea name="progress" rows="3" required
                                  placeholder="Uraikan detail kegiatan yang telah dilaksanakan..."
                                  class="input-field w-full px-5 py-4 rounded-2xl text-blue-900 font-medium text-sm"></textarea>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Hambatan / Kendala</label>
                        <textarea name="kendala" rows="3"
                                  placeholder="Tuliskan kendala jika ada..."
                                  class="input-field w-full px-5 py-4 rounded-2xl text-blue-900 font-medium text-sm"></textarea>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Strategi Tindak Lanjut</label>
                        <textarea name="strategi" rows="3"
                                  placeholder="Rencana perbaikan ke depan..."
                                  class="input-field w-full px-5 py-4 rounded-2xl text-blue-900 font-medium text-sm"></textarea>
                    </div>
                </div>

                <div class="space-y-3">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Unggah Bukti Dukung (Multi Files)</label>
                    <div class="relative group">
                        <input type="file" name="file_dukung[]" multiple id="file_dukung" class="hidden" onchange="updateFileName(this)">
                        <label for="file_dukung" class="flex flex-col items-center justify-center border-2 border-dashed border-slate-200 rounded-3xl p-8 hover:bg-blue-50/50 hover:border-blue-400 transition-all cursor-pointer bg-slate-50/30">
                            <div class="w-12 h-12 bg-white rounded-2xl shadow-sm flex items-center justify-center mb-3 text-blue-600 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </div>
                            <p class="text-sm font-bold text-blue-900" id="file-label">Pilih berkas atau tarik ke sini</p>
                            <p class="text-[10px] text-slate-400 mt-1 uppercase font-black">PDF, JPG, PNG, DOCX (Maks 5MB)</p>
                        </label>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 pt-8 border-t border-slate-50">
                    <button type="submit" class="btn-polban flex-1 text-white font-black py-4 rounded-2xl uppercase tracking-widest text-xs shadow-lg shadow-blue-900/10">
                        Simpan Capaian Atasan
                    </button>
                    <a href="<?= base_url('atasan/task') ?>" class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-500 font-black py-4 rounded-2xl uppercase tracking-widest text-xs text-center transition-colors">
                        Batal & Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="mt-10 text-center">
        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">
            © <?= date('Y') ?> KINETRACK — Politeknik Negeri Bandung
        </p>
    </div>
</div>

<script>
    function updateFileName(input) {
        const label = document.getElementById('file-label');
        if (input.files.length > 0) {
            label.innerText = input.files.length + ' Berkas terpilih';
            label.classList.add('text-blue-600');
        } else {
            label.innerText = 'Pilih berkas atau tarik ke sini';
            label.classList.remove('text-blue-600');
        }
    }
</script>

<?= $this->endSection() ?>