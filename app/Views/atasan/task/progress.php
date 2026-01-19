<?= $this->extend('layout/atasan_template') ?>
<?= $this->section('content') ?>

<div class="min-h-screen bg-slate-50 px-6 py-8 font-sans text-slate-800">

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <a href="<?= base_url('atasan/task') ?>" class="p-2 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 text-slate-500 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </a>
                <span class="text-xs font-bold text-blue-600 uppercase tracking-widest">Detail Capaian (Atasan)</span>
            </div>
            <h1 class="text-3xl font-bold text-slate-900 tracking-tight">
                Progress Triwulan <?= esc($tw) ?>
            </h1>
        </div>

        <div class="flex gap-3">
             <span class="px-4 py-2 bg-white border border-slate-200 rounded-xl text-sm font-bold text-slate-600 shadow-sm">
                TA <?= esc($indikator['tahun'] ?? date('Y')) ?>
             </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-1 space-y-6">
            
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm relative overflow-hidden">
                <div class="absolute top-0 right-0 p-4 opacity-10">
                    <svg class="w-20 h-20 text-blue-600" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                </div>
                
                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-6">Status Capaian</h4>
                
                <div class="space-y-4">
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase">Realisasi Saat Ini</p>
                        <div class="flex items-baseline gap-2">
                            <span class="text-4xl font-black text-slate-800"><?= esc($measure['realisasi']) ?></span>
                            <span class="text-sm font-bold text-slate-400">/ <?= esc($target) ?> <?= esc($indikator['satuan']) ?></span>
                        </div>
                        <?php if ($measure['realisasi'] > $target): ?>
                            <div class="mt-2 inline-flex items-center px-2 py-1 rounded-md bg-emerald-50 text-emerald-600 text-[10px] font-bold uppercase tracking-wide border border-emerald-100">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 10l7-7m0 0l7 7m-7-7v18" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                +<?= esc($measure['realisasi'] - $target) ?> Nilai Tambah
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="pt-4 border-t border-slate-50">
                        <div class="flex justify-between text-[11px] font-bold text-slate-500 uppercase mb-2">
                            <span>Persentase Target TW</span>
                            <span class="<?= $percent >= 100 ? 'text-emerald-600' : 'text-blue-600' ?>"><?= round($percent) ?>%</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-3 overflow-hidden">
                            <div class="h-full rounded-full transition-all duration-1000 <?= $percent >= 100 ? 'bg-emerald-500' : 'bg-blue-500' ?>" 
                                 style="width: <?= min($percent, 100) ?>%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-slate-800 rounded-2xl p-6 text-white shadow-sm">
                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4 opacity-60">Informasi Indikator</h4>
                <div class="space-y-4">
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase opacity-50">Nama Indikator</p>
                        <p class="text-sm font-semibold mt-1 leading-snug"><?= esc($indikator['nama_indikator']) ?></p>
                    </div>
                    <div class="flex justify-between pt-2">
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase opacity-50">Satuan</p>
                            <p class="text-sm font-bold"><?= esc($indikator['satuan']) ?></p>
                        </div>
                        <div class="text-right">
                            <p class="text-[10px] font-bold text-slate-400 uppercase opacity-50">Target TW <?= $tw ?></p>
                            <p class="text-sm font-bold text-blue-400"><?= esc($target) ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2 space-y-6">
            
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                    <h4 class="text-sm font-bold text-slate-800 uppercase tracking-wider flex items-center gap-2">
                        <span class="w-1.5 h-4 bg-blue-600 rounded-full"></span>
                        Narasi Capaian & Kendala
                    </h4>
                </div>
                
                <div class="p-6 space-y-8">
                    <div class="relative pl-6 border-l-2 border-blue-100">
                        <div class="absolute -left-[9px] top-0 w-4 h-4 rounded-full bg-blue-600 border-4 border-white shadow-sm"></div>
                        <h5 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Progress / Kegiatan</h5>
                        <p class="text-slate-700 leading-relaxed italic bg-slate-50 p-4 rounded-xl border border-slate-100">
                            <?= nl2br(esc($measure['progress'])) ?: '<span class="text-slate-300">Tidak ada deskripsi kegiatan.</span>' ?>
                        </p>
                    </div>

                    <div class="relative pl-6 border-l-2 border-rose-100">
                        <div class="absolute -left-[9px] top-0 w-4 h-4 rounded-full bg-rose-500 border-4 border-white shadow-sm"></div>
                        <h5 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Kendala / Permasalahan</h5>
                        <p class="text-slate-700 leading-relaxed bg-rose-50/30 p-4 rounded-xl border border-rose-100/50">
                            <?= nl2br(esc($measure['kendala'])) ?: '<span class="text-slate-300 italic">Tidak ada kendala yang dilaporkan.</span>' ?>
                        </p>
                    </div>

                    <div class="relative pl-6 border-l-2 border-emerald-100">
                        <div class="absolute -left-[9px] top-0 w-4 h-4 rounded-full bg-emerald-500 border-4 border-white shadow-sm"></div>
                        <h5 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Strategi / Tindak Lanjut</h5>
                        <p class="text-slate-700 leading-relaxed bg-emerald-50/30 p-4 rounded-xl border border-emerald-100/50">
                            <?= nl2br(esc($measure['strategi'])) ?: '<span class="text-slate-300 italic">Tidak ada strategi tindak lanjut.</span>' ?>
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                    <h4 class="text-sm font-bold text-slate-800 uppercase tracking-wider flex items-center gap-2">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.414a4 4 0 00-5.656-5.656l-6.415 6.414a6 6 0 108.486 8.486L20.5 13" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        Lampiran Bukti Dukung
                    </h4>
                </div>
                
                <div class="p-6">
                    <?php $files = json_decode($measure['file_dukung'], true); ?>

                    <?php if (empty($files)): ?>
                        <div class="text-center py-8 border-2 border-dashed border-slate-100 rounded-2xl">
                            <p class="text-sm text-slate-400 italic">Tidak ada file dukung diunggah.</p>
                        </div>
                    <?php else: ?>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <?php foreach ($files as $file): ?>
                                <div class="group flex items-center justify-between p-4 bg-slate-50 border border-slate-200 rounded-xl hover:border-blue-300 hover:bg-white transition-all">
                                    <div class="flex items-center gap-3 overflow-hidden">
                                        <div class="p-2 bg-blue-100 text-blue-600 rounded-lg group-hover:bg-blue-600 group-hover:text-white transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                        </div>
                                        <div class="overflow-hidden">
                                            <p class="text-xs font-bold text-slate-700 truncate" title="<?= esc($file) ?>"><?= esc($file) ?></p>
                                            <p class="text-[10px] text-slate-400 font-medium uppercase mt-0.5">Dokumen Bukti</p>
                                        </div>
                                    </div>
                                    <a href="<?= base_url('uploads/pengukuran/'.$file) ?>" 
                                       target="_blank"
                                       class="ml-4 px-3 py-1.5 bg-white border border-slate-200 text-[11px] font-black text-slate-600 rounded-lg hover:bg-slate-800 hover:text-white hover:border-slate-800 transition-all uppercase tracking-tighter">
                                        Buka
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-16 pt-8 border-t border-slate-200 flex flex-col md:flex-row items-center justify-between gap-4 text-center md:text-left">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 bg-slate-200 rounded-lg flex items-center justify-center font-bold text-slate-400 text-xs">KT</div>
            <p class="text-xs text-slate-400 font-medium tracking-wide uppercase">
                © <?= date('Y') ?> <span class="text-slate-600 font-bold">KINETRACK</span> — Politeknik Negeri Bandung
            </p>
        </div>
    </div>
</div>

<?= $this->endSection() ?>