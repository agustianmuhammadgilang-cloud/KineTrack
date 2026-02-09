<?= $this->extend('layout/staff_template') ?>
<?= $this->section('content') ?>

<div class="px-6 py-10 max-w-4xl mx-auto">
    <div class="mb-10">
        <a href="<?= base_url('staff/task') ?>" class="inline-flex items-center gap-2 text-xs font-bold text-slate-400 uppercase tracking-widest hover:text-blue-900 transition-colors mb-6">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M10 19l-7-7m0 0l7-7m-7 7h18" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            Kembali ke Tugas
        </a>
        <h2 class="text-3xl font-black text-blue-900 tracking-tight">Papan Evaluasi Pimpinan</h2>
        <p class="text-slate-500 mt-1">Daftar arahan strategis berdasarkan capaian kinerja Tahun <?= $tahun_aktif['tahun'] ?? '' ?></p>
    </div>

    <?php if (empty($rekomendasi)): ?>
        <div class="bg-white border-2 border-dashed border-slate-200 rounded-[32px] p-20 text-center">
            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </div>
            <p class="text-slate-400 font-bold uppercase tracking-widest text-xs">Belum ada data evaluasi</p>
        </div>
    <?php else: ?>
        <div class="relative">
            <div class="absolute left-8 top-0 bottom-0 w-px bg-slate-200"></div>

            <div class="space-y-10">
                <?php foreach ($rekomendasi as $r): ?>
                <div class="relative flex items-start gap-8 group">
                    <div class="relative z-10 flex-none w-16 h-16 rounded-2xl bg-blue-900 shadow-xl shadow-blue-900/20 flex flex-col items-center justify-center text-white transition-transform group-hover:scale-110">
                        <span class="text-[9px] font-black opacity-60 leading-none">TW</span>
                        <span class="text-2xl font-black">0<?= $r['triwulan'] ?></span>
                    </div>

                    <div class="flex-1 bg-white rounded-[28px] p-8 shadow-sm border border-slate-100 hover:shadow-md transition-shadow">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-blue-900">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] text-slate-400 font-bold uppercase leading-none mb-1">Pimpinan / Direktur</p>
                                    <p class="text-sm font-bold text-slate-700"><?= esc($r['pimpinan_nama'] ?? 'Pimpinan Polban') ?></p>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="text-[10px] font-bold text-slate-400 block uppercase italic">Tanggal Terbit</span>
                                <span class="text-xs font-medium text-slate-600"><?= date('d M Y', strtotime($r['created_at'])) ?></span>
                            </div>
                        </div>

                        <div class="bg-slate-50/50 rounded-2xl p-6 border border-slate-100/50">
                            <p class="text-slate-700 leading-relaxed font-medium">
                                "<?= nl2br(esc($r['isi_rekomendasi'])) ?>"
                            </p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>