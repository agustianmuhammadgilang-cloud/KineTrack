<?= $this->extend('layout/pimpinan_template') ?>
<?= $this->section('content') ?>

<style>
    @keyframes bell-swing {
        0%, 100% { transform: rotate(0deg); }
        20% { transform: rotate(15deg); }
        40% { transform: rotate(-10deg); }
        60% { transform: rotate(5deg); }
        80% { transform: rotate(-5deg); }
    }
    .bell-group:hover .bell-icon {
        animation: bell-swing 1s ease-in-out infinite;
    }
    .card-hover {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .card-hover:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 20px -5px rgba(30, 58, 138, 0.1);
        border-color: #bfdbfe;
    }
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f5f9;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }
</style>

<div class="min-h-screen bg-slate-50 px-6 py-8 font-sans text-slate-800">

    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6 mb-10">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">
                Dashboard Pimpinan
            </h1>
            <p class="text-slate-500 mt-1 text-sm">
                Ringkasan pengukuran kinerja global Politeknik Negeri Bandung
            </p>
            
            <?php if (isset($tahun_aktif) && $tahun_aktif): ?>
                <div class="mt-4 inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-blue-50 border border-blue-200 shadow-sm">
                    <span class="flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-2 w-2 rounded-full bg-blue-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-600"></span>
                    </span>
                    <span class="text-xs font-bold text-blue-800 uppercase tracking-wide">
                        TA <?= esc($tahun_aktif['tahun']) ?> 
                        <span class="text-slate-300 mx-1">|</span> 
                        <?= isset($tw_aktif) ? 'Triwulan ' . esc($tw_aktif['tw']) : 'TW Aktif' ?>
                    </span>
                </div>
            <?php endif; ?>
        </div>

        <div class="flex items-center gap-4 self-end lg:self-center">
            <div class="w-px h-8 bg-slate-200 hidden sm:block"></div>

            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" class="flex items-center gap-3 p-1.5 pr-3 rounded-xl bg-white border border-slate-200 shadow-sm hover:shadow-md hover:border-blue-300 transition-all duration-300 group">
                    <img src="<?= base_url('uploads/profile/' . (session('foto') ?? 'default.png')) ?>" class="w-9 h-9 rounded-lg object-cover ring-2 ring-slate-100 group-hover:ring-blue-100 border border-slate-200 transition-all">
                    <div class="hidden sm:block text-left">
                        <span class="block text-xs font-bold text-slate-700 leading-tight tracking-wide"><?= session('nama') ?></span>
                        <span class="text-[10px] text-slate-400 font-medium tracking-wider uppercase">Pimpinan</span>
                    </div>
                    <svg class="w-4 h-4 text-slate-400 group-hover:text-blue-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="open" x-transition @click.away="open = false" style="display: none;" class="absolute right-0 mt-3 w-52 bg-white shadow-xl rounded-2xl border border-slate-100 py-2 z-50 ring-1 ring-black/5">
                    <div class="px-2 space-y-1">
                        <a href="<?= base_url('pimpinan/profile') ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-600 hover:bg-blue-50 hover:text-blue-700 transition-all">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                            Profil Saya
                        </a>
                        <div class="h-px bg-slate-100 my-1 mx-2"></div>
                        <a href="<?= base_url('logout') ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-red-600 hover:bg-red-50 transition-all">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                            Logout
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm card-hover flex items-center justify-between group">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Total PIC Aktif</p>
                <h3 class="text-3xl font-extrabold text-slate-800"><?= number_format($totalPic ?? 0) ?></h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center transition-transform group-hover:scale-110">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm card-hover flex items-center justify-between group">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Jumlah Indikator</p>
                <h3 class="text-3xl font-extrabold text-slate-800"><?= number_format($totalIndikator ?? 0) ?></h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-violet-50 text-violet-600 flex items-center justify-center transition-transform group-hover:scale-110">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm card-hover flex items-center justify-between group">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Total Dokumen</p>
                <h3 class="text-3xl font-extrabold text-slate-800"><?= number_format($totalDokumen ?? 0) ?></h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center transition-transform group-hover:scale-110">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm mb-10">
        <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
            <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
            Aksi Cepat Pimpinan
        </h3>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <a href="<?= site_url('pimpinan/pengukuran') ?>" class="group bg-slate-50 p-4 rounded-xl border border-slate-100 hover:bg-white hover:border-amber-400 hover:shadow-md transition-all flex flex-col gap-3">
                <div class="w-10 h-10 bg-amber-100 text-amber-600 rounded-lg flex items-center justify-center group-hover:bg-amber-600 group-hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                </div>
                <div>
                    <h4 class="font-bold text-slate-800 text-sm group-hover:text-amber-700">Kelola Rekomendasi</h4>
                    <p class="text-[10px] text-slate-500 mt-1 line-clamp-1">Berikan arahan untuk para PIC.</p>
                </div>
            </a>

            <a href="<?= site_url('pimpinan/dokumen') ?>" class="group bg-slate-50 p-4 rounded-xl border border-slate-100 hover:bg-white hover:border-emerald-400 hover:shadow-md transition-all flex flex-col gap-3">
                <div class="w-10 h-10 bg-emerald-100 text-emerald-600 rounded-lg flex items-center justify-center group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m3-3H9m4 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                </div>
                <div>
                    <h4 class="font-bold text-slate-800 text-sm group-hover:text-emerald-700">Akses Dokumen</h4>
                    <p class="text-[10px] text-slate-500 mt-1 line-clamp-1">Unduh dan periksa dokumen pendukung.</p>
                </div>
            </a>
        </div>
    </div>

    <div class="mt-16 pt-8 border-t border-slate-200 flex flex-col md:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 bg-blue-900 rounded-lg flex items-center justify-center font-bold text-white text-xs">KT</div>
            <p class="text-xs text-slate-400 font-medium tracking-wide uppercase">
                © <?= date('Y') ?> <span class="text-slate-700 font-bold">KINETRACK</span> — Politeknik Negeri Bandung
            </p>
        </div>
        <div class="flex gap-6">
            <span class="text-[10px] text-slate-300 uppercase tracking-widest font-bold">Pimpinan Mode</span>
        </div>
    </div>

</div>

<?= $this->endSection() ?>