<?= $this->extend('layout/pimpinan_template') ?>
<?= $this->section('content') ?>

<div class="px-4 py-8 max-w-5xl mx-auto">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <a href="<?= base_url('pimpinan/pengukuran/output?tahun_id='.$selected_tahun.'&triwulan='.$selected_tw) ?>" 
               class="inline-flex items-center gap-2 text-sm font-bold text-blue-900/60 hover:text-blue-900 transition-colors mb-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Ringkasan Output
            </a>
            <h4 class="text-3xl font-black text-blue-900 tracking-tight">
                Rekomendasi <span class="text-blue-600">Pimpinan</span>
            </h4>
            <p class="text-sm text-slate-500 font-medium">Evaluasi strategis untuk periode Triwulan <?= $selected_tw ?></p>
        </div>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="bg-emerald-50 border border-emerald-100 text-emerald-700 px-6 py-3 rounded-2xl flex items-center gap-3 animate-bounce">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                <span class="text-xs font-bold uppercase"><?= session()->getFlashdata('success') ?></span>
            </div>
        <?php endif; ?>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="space-y-6">
            <div class="bg-blue-900 rounded-[32px] p-8 text-white shadow-2xl shadow-blue-900/20 relative overflow-hidden">
                <div class="relative z-10">
                    <span class="text-[10px] font-black uppercase tracking-[0.2em] opacity-60">Periode Aktif</span>
                    <h5 class="text-2xl font-bold mt-1">TW 0<?= $selected_tw ?></h5>
                    <div class="h-1 w-12 bg-gold-500 bg-[#D4AF37] my-4"></div>
                    <p class="text-sm opacity-80 leading-relaxed">
                        Rekomendasi ini akan diteruskan kepada seluruh PIC (Atasan & Staff) sebagai bahan evaluasi kinerja.
                    </p>
                </div>
                <div class="absolute -right-8 -bottom-8 w-32 h-32 bg-white/5 rounded-full"></div>
            </div>

            <div class="bg-white border border-slate-100 rounded-[32px] p-6 shadow-sm">
                <h6 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-4">Petunjuk Penulisan</h6>
                <ul class="space-y-4">
                    <li class="flex gap-3 text-sm text-slate-600">
                        <span class="w-5 h-5 bg-slate-100 rounded-full flex-shrink-0 flex items-center justify-center text-[10px] font-bold">1</span>
                        Gunakan bahasa yang instruktif namun suportif.
                    </li>
                    <li class="flex gap-3 text-sm text-slate-600">
                        <span class="w-5 h-5 bg-slate-100 rounded-full flex-shrink-0 flex items-center justify-center text-[10px] font-bold">2</span>
                        Fokus pada perbaikan indikator yang belum mencapai target.
                    </li>
                </ul>
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="bg-white border border-slate-100 rounded-[32px] p-2 shadow-xl shadow-blue-900/5">
                <div class="p-8">
                    <form action="<?= base_url('pimpinan/rekomendasi/store') ?>" method="post">
                        <?= csrf_field() ?>
                        <input type="hidden" name="tahun_id" value="<?= $selected_tahun ?>">
                        <input type="hidden" name="triwulan" value="<?= $selected_tw ?>">

                        <div class="mb-8">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4 px-1">
                                Isi Evaluasi & Rekomendasi Strategis
                            </label>
                            <textarea 
                                name="isi_rekomendasi" 
                                rows="12"
                                class="w-full px-6 py-5 bg-slate-50 border-2 border-slate-100 rounded-[24px] focus:ring-4 focus:ring-blue-900/5 focus:border-blue-900 outline-none transition-all text-slate-700 leading-relaxed placeholder:text-slate-300"
                                placeholder="Contoh: Berdasarkan capaian TW <?= $selected_tw ?>, perlu dilakukan percepatan pada program kerja..."><?= $rekomendasi['isi_rekomendasi'] ?? '' ?></textarea>
                        </div>

                        <div class="flex items-center justify-between bg-slate-50 p-4 rounded-2xl">
                            <div class="flex items-center gap-2 text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span class="text-[10px] font-bold uppercase tracking-wider">
                                    <?= isset($rekomendasi['updated_at']) ? 'Terakhir diubah: '.date('d M Y H:i', strtotime($rekomendasi['updated_at'])) : 'Draft Baru' ?>
                                </span>
                            </div>
                            
                            <button type="submit" 
                                class="px-8 py-4 bg-blue-900 text-white rounded-xl font-black text-xs uppercase tracking-widest hover:bg-blue-800 shadow-lg shadow-blue-900/20 transition-all transform active:scale-95 flex items-center gap-3">
                                <span>Simpan & Publish</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>

<?= $this->endSection() ?>