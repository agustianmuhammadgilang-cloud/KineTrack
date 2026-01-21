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

    .glass-card {
        background: white;
        border-radius: 32px;
        border: 1px solid #eef2f6;
        box-shadow: 0 20px 50px -12px rgba(0, 51, 102, 0.08);
        transition: var(--transition-smooth);
    }

    .dark-card {
        background: var(--polban-blue);
        border-radius: 32px;
        color: white;
    }

    .progress-bar-container {
        background: #f1f5f9;
        border-radius: 99px;
        height: 12px;
        overflow: hidden;
    }

    .btn-back {
        transition: var(--transition-smooth);
        border: 1.5px solid #e2e8f0;
    }

    .btn-back:hover {
        background: var(--polban-blue);
        color: white;
        border-color: var(--polban-blue);
    }

    .status-badge {
        background: linear-gradient(135deg, rgba(0, 51, 102, 0.03) 0%, rgba(212, 175, 55, 0.05) 100%);
        border-left: 4px solid var(--polban-gold);
    }

    .timeline-dot {
        box-shadow: 0 0 0 4px white, 0 0 0 7px rgba(0, 51, 102, 0.1);
    }
</style>

<div class="px-6 py-10 max-w-6xl mx-auto min-h-screen">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-12">
        <div class="flex items-center gap-5">
            <a href="<?= base_url('staff/task') ?>" class="w-12 h-12 btn-back rounded-2xl flex items-center justify-center shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M15 19l-7-7 7-7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-black text-blue-900 tracking-tight">
                    Progress <span class="text-blue-600">Triwulan <?= esc($tw) ?></span>
                </h1>
                <p class="text-[11px] text-slate-400 font-bold uppercase tracking-[0.2em] mt-1">
                    Detail Capaian & Dokumentasi Indikator
                </p>
            </div>
        </div>

        <div class="flex gap-3">
             <span class="px-6 py-3 bg-white border border-slate-100 rounded-2xl text-xs font-black text-blue-900 shadow-sm uppercase tracking-widest">
                TA <?= esc($indikator['tahun'] ?? date('Y')) ?>
             </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-1 space-y-8">
            
            <div class="glass-card p-8 relative overflow-hidden">
                <div class="absolute -top-6 -right-6 opacity-[0.03] text-blue-900">
                    <svg class="w-40 h-40" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                </div>
                
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-6">Status Realisasi</label>
                
                <div class="space-y-6">
                    <div>
                        <div class="flex items-baseline gap-2">
                            <span class="text-5xl font-black text-blue-900 tracking-tighter"><?= esc($measure['realisasi']) ?></span>
                            <span class="text-sm font-bold text-slate-400">/ <?= esc($target) ?> <?= esc($indikator['satuan']) ?></span>
                        </div>
                        
                        <?php if ($measure['realisasi'] > $target): ?>
                            <div class="mt-3 inline-flex items-center px-3 py-1.5 rounded-xl bg-emerald-50 text-emerald-600 text-[10px] font-black uppercase tracking-wide border border-emerald-100">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 10l7-7m0 0l7 7m-7-7v18" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                Surplus <?= esc($measure['realisasi'] - $target) ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="pt-6 border-t border-slate-50">
                        <div class="flex justify-between text-[11px] font-black uppercase mb-3">
                            <span class="text-slate-500">Persentase Target</span>
                            <span class="<?= $percent >= 100 ? 'text-emerald-600' : 'text-blue-600' ?>"><?= round($percent) ?>%</span>
                        </div>
                        <div class="progress-bar-container">
                            <div class="h-full rounded-full transition-all duration-1000 <?= $percent >= 100 ? 'bg-emerald-500' : 'bg-blue-600' ?>" 
                                 style="width: <?= min($percent, 100) ?>%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="dark-card p-8 shadow-xl shadow-blue-900/10">
                <label class="text-[10px] font-black text-white/40 uppercase tracking-widest block mb-4">Detail Indikator</label>
                <div class="space-y-5">
                    <div>
                        <p class="text-sm font-bold leading-snug text-white/90"><?= esc($indikator['nama_indikator']) ?></p>
                    </div>
                    <div class="grid grid-cols-2 gap-4 pt-4 border-t border-white/10">
                        <div>
                            <p class="text-[10px] font-bold text-white/40 uppercase">Satuan</p>
                            <p class="text-sm font-black text-white"><?= esc($indikator['satuan']) ?></p>
                        </div>
                        <div class="text-right">
                            <p class="text-[10px] font-bold text-white/40 uppercase">Target TW</p>
                            <p class="text-sm font-black text-polban-gold"><?= esc($target) ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2 space-y-8">
            
            <div class="glass-card overflow-hidden">
                <div class="px-8 py-5 border-b border-slate-50 bg-slate-50/30">
                    <h4 class="text-xs font-black text-blue-900 uppercase tracking-widest flex items-center gap-3">
                        <span class="w-2 h-2 bg-polban-gold rounded-full"></span>
                        Narasi Capaian & Analisis
                    </h4>
                </div>
                
                <div class="p-8 space-y-10">
                    <div class="relative pl-8 border-l-2 border-blue-50">
                        <div class="absolute -left-[9px] top-0 w-4 h-4 rounded-full bg-blue-900 timeline-dot"></div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-3">Kegiatan yang dilakukan</label>
                        <div class="text-sm text-slate-700 leading-relaxed font-medium bg-slate-50 p-5 rounded-2xl border border-slate-100/50">
                            <?= nl2br(esc($measure['progress'])) ?: '<span class="text-slate-300 italic">Belum ada deskripsi.</span>' ?>
                        </div>
                    </div>

                    <div class="relative pl-8 border-l-2 border-rose-50">
                        <div class="absolute -left-[9px] top-0 w-4 h-4 rounded-full bg-rose-500 timeline-dot"></div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-3">Kendala / Hambatan</label>
                        <div class="text-sm text-slate-700 leading-relaxed font-medium bg-rose-50/50 p-5 rounded-2xl border border-rose-100/30">
                            <?= nl2br(esc($measure['kendala'])) ?: '<span class="text-slate-300 italic">Tidak ada kendala.</span>' ?>
                        </div>
                    </div>

                    <div class="relative pl-8 border-l-2 border-emerald-50">
                        <div class="absolute -left-[9px] top-0 w-4 h-4 rounded-full bg-emerald-500 timeline-dot"></div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-3">Strategi Tindak Lanjut</label>
                        <div class="text-sm text-slate-700 leading-relaxed font-medium bg-emerald-50/50 p-5 rounded-2xl border border-emerald-100/30">
                            <?= nl2br(esc($measure['strategi'])) ?: '<span class="text-slate-300 italic">Belum ada strategi.</span>' ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="glass-card overflow-hidden">
                <div class="px-8 py-5 border-b border-slate-50 bg-slate-50/30 flex justify-between items-center">
                    <h4 class="text-xs font-black text-blue-900 uppercase tracking-widest flex items-center gap-3">
                        <svg class="w-4 h-4 text-polban-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.414a4 4 0 00-5.656-5.656l-6.415 6.414a6 6 0 108.486 8.486L20.5 13" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        Bukti Dukung (Lampiran)
                    </h4>
                </div>
                
                <div class="p-8">
                    <?php $files = json_decode($measure['file_dukung'], true); ?>

                    <?php if (empty($files)): ?>
                        <div class="text-center py-10 border-2 border-dashed border-slate-100 rounded-[32px]">
                            <p class="text-xs text-slate-400 font-bold uppercase tracking-widest italic">Belum ada file diunggah</p>
                        </div>
                    <?php else: ?>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <?php foreach ($files as $file): ?>
                                <div class="group flex items-center justify-between p-5 bg-slate-50 rounded-2xl border border-slate-100 hover:border-blue-200 hover:bg-white transition-all">
                                    <div class="flex items-center gap-4 overflow-hidden">
                                        <div class="w-10 h-10 shrink-0 bg-blue-50 text-blue-900 rounded-xl flex items-center justify-center group-hover:bg-blue-900 group-hover:text-white transition-all">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                        </div>
                                        <div class="overflow-hidden">
                                            <p class="text-xs font-black text-blue-900 truncate" title="<?= esc($file) ?>"><?= esc($file) ?></p>
                                            <p class="text-[9px] text-slate-400 font-bold uppercase mt-1">Dokumen Resmi</p>
                                        </div>
                                    </div>
                                    <a href="<?= base_url('uploads/pengukuran/'.$file) ?>" 
                                       target="_blank"
                                       class="ml-4 px-4 py-2 bg-white border border-slate-200 text-[10px] font-black text-blue-900 rounded-xl hover:bg-blue-900 hover:text-white transition-all uppercase tracking-wider shadow-sm">
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

    <div class="mt-20 pt-8 border-t border-slate-100">
        <div class="flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-blue-900 rounded-xl flex items-center justify-center font-black text-white text-xs shadow-lg shadow-blue-900/20">KT</div>
                <p class="text-[10px] text-slate-400 font-bold tracking-[0.1em] uppercase">
                    © <?= date('Y') ?> <span class="text-blue-900">KINETRACK</span> — Politeknik Negeri Bandung
                </p>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>