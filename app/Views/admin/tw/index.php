<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<style>
    :root {
        --polban-blue: #003366;
        --polban-blue-light: #004a94;
        --polban-gold: #D4AF37;
        --polban-gold-soft: #FCF8E3;
        --slate-soft: #f8fafc;
        /* Bezier Curve yang lebih "bouncy" untuk kesan organik */
        --transition-bouncy: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        --transition-smooth: all 0.3s ease;
    }

    /* Card Styling */
    .year-card {
        border-radius: 24px;
        background: white;
        border: 1px solid #eef2f6;
        box-shadow: 0 10px 25px -5px rgba(0, 51, 102, 0.04);
        overflow: hidden;
    }

    .tw-card {
        transition: var(--transition-smooth);
        border: 1px solid #f1f5f9;
        position: relative;
        background: white;
    }

    .tw-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(0, 51, 102, 0.08);
        border-color: var(--polban-blue-light);
    }

    /* --- TOGGLE SWITCH REFINED --- */
    .toggle-base {
        position: relative;
        width: 52px; /* Dipersempit sedikit agar lebih proporsional */
        height: 28px;
        border-radius: 999px;
        padding: 4px;
        transition: var(--transition-smooth);
        display: flex;
        align-items: center;
        cursor: pointer;
        /* Efek lubang ke dalam */
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.06); 
    }

    .toggle-circle {
        position: absolute;
        left: 4px; /* Posisi awal */
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: white;
        /* Shadow agar lingkaran terlihat timbul */
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2), 0 1px 1px rgba(0, 0, 0, 0.1);
        transition: var(--transition-bouncy);
    }

    /* State: Active (Dibuka) */
    .active-switch { 
        background-color: #10b981; /* Emerald 500 */
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1), 0 4px 10px rgba(16, 185, 129, 0.2);
    }

    .active-switch .toggle-circle { 
        /* Kalkulasi presisi: Lebar Base (52) - Lebar Circle (20) - Padding (4) = 28px */
        transform: translateX(24px); 
    }

    /* State: Inactive (Dikunci) */
    .inactive-switch { 
        background-color: #cbd5e1; /* Slate 300 */
    }

    /* Micro-interaction: Lingkaran sedikit memanjang saat hover/active */
    .group\/toggle:active .toggle-circle {
        width: 26px;
    }

    /* Pulse Animation yang lebih halus */
    .pulse-animation {
        animation: pulse-soft 2.5s infinite;
    }

    @keyframes pulse-soft {
        0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.4), inset 0 2px 4px rgba(0, 0, 0, 0.1); }
        70% { box-shadow: 0 0 0 10px rgba(16, 185, 129, 0), inset 0 2px 4px rgba(0, 0, 0, 0.1); }
        100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0), inset 0 2px 4px rgba(0, 0, 0, 0.1); }
    }
</style>

<div class="px-4 py-8 max-w-7xl mx-auto">
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
        <div class="flex items-center gap-5">
            <div class="w-16 h-16 bg-slate-50 border border-slate-100 rounded-2xl flex items-center justify-center shadow-sm text-blue-900">
                <svg class="w-9 h-9" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
            </div>
            <div>
                <h4 class="text-2xl font-black text-blue-900 tracking-tight">
                    Manajemen <span class="text-slate-400 font-light">|</span> <span class="text-blue-600">Triwulan</span>
                </h4>
                <p class="text-[11px] text-slate-400 font-semibold uppercase tracking-[0.2em] mt-1">
                    Kontrol Akses Periode Pelaporan Kinerja
                </p>
            </div>
        </div>
    </div>

    <div class="space-y-8">
        <?php foreach ($data as $row): ?>
            <div class="year-card overflow-hidden">
                <div class="bg-slate-50 border-b border-slate-100 p-6 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="h-8 w-1.5 bg-blue-900 rounded-full"></div>
                        <h4 class="font-black text-xl text-blue-900">Tahun Anggaran <?= $row['tahun'] ?></h4>
                    </div>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest bg-white px-3 py-1 rounded-full border border-slate-200 shadow-sm">
                        Master Period
                    </span>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        <?php foreach ($row['tw'] as $t): ?>
                            <div class="tw-card rounded-2xl p-5 bg-white group">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex flex-col">
                                        <p class="font-black text-blue-900 text-lg">TW <?= $t['tw'] ?></p>
                                        <span class="text-[10px] text-slate-400 font-bold uppercase tracking-tight">Quarter Phase</span>
                                    </div>

                                    <?php if ($t['is_open_effective']): ?>
                                        <span class="flex items-center gap-1.5 text-green-600 bg-green-50 px-2 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider border border-green-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                                            Dibuka
                                        </span>
                                    <?php else: ?>
                                        <span class="flex items-center gap-1.5 text-slate-400 bg-slate-50 px-2 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider border border-slate-100">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" stroke-width="3"/></svg>
                                            Dikunci
                                        </span>
                                    <?php endif; ?>
                                </div>

                                <?php if ($t['is_auto_now']): ?>
                                    <div class="inline-flex items-center gap-2 bg-blue-50 text-blue-700 px-3 py-1.5 rounded-lg mb-4 w-full border border-blue-100">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span class="text-[11px] font-bold">Periode Berjalan</span>
                                    </div>
                                <?php else: ?>
                                    <div class="h-[34px] mb-4"></div> <?php endif; ?>

                                <div class="pt-4 border-t border-slate-50">
    <a href="<?= base_url('admin/tw/toggle/' . $t['id']) ?>" 
       class="toggle-wrapper group/toggle w-full flex items-center justify-between">
        
        <div class="flex flex-col">
            <span class="text-[10px] font-black uppercase tracking-widest leading-none <?= $t['is_open_effective'] ? 'text-green-600' : 'text-slate-400' ?>">
                Status Akses
            </span>
            <span class="text-xs font-bold text-slate-700 mt-1">
                <?= $t['is_open_effective'] ? 'Terbuka' : 'Terkunci' ?>
            </span>
        </div>
        
        <div class="toggle-base <?= $t['is_open_effective'] ? 'active-switch' : 'bg-slate-300' ?>">
            <div class="toggle-circle"></div>
        </div>
        
    </a>
</div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="mt-12">
        <div class="p-6 rounded-3xl bg-blue-900 text-white flex flex-col md:flex-row items-center gap-6 justify-between shadow-xl shadow-blue-900/20">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center backdrop-blur-md">
                    <svg class="w-6 h-6 text-polban-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-white leading-tight">Panduan Akses Pelaporan</p>
                    <p class="text-[11px] text-blue-200 mt-1 uppercase tracking-wider">Gunakan toggle switch untuk mengizinkan atau melarang unit kerja mengunggah data pada periode terkait.</p>
                </div>
            </div>
            <div class="flex flex-col items-end shrink-0">
                <span class="text-[10px] font-black text-white/40 uppercase tracking-[0.4em]">Secure Access Control</span>
                <div class="flex gap-1 mt-1">
                    <div class="w-2 h-2 rounded-full bg-green-400"></div>
                    <div class="w-2 h-2 rounded-full bg-yellow-400"></div>
                    <div class="w-2 h-2 rounded-full bg-red-400"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>