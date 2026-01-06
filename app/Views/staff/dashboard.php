<?= $this->extend('layout/staff_template') ?>
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
    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
    }
</style>

<div class="min-h-screen bg-slate-50 px-6 py-8 font-sans text-slate-800">

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
        
        <div>
            <h1 class="text-3xl font-bold text-slate-900 tracking-tight">
                Dashboard Kinerja
            </h1>
            <p class="text-slate-500 mt-1 text-sm">
                Selamat datang kembali, <span class="font-semibold text-slate-700"><?= session('nama') ?></span>.
            </p>
            
            <?php if (!empty($tahunAktif)): ?>
                <div class="mt-3 inline-flex items-center px-3 py-1 rounded-full bg-blue-50 border border-blue-200 shadow-sm">
                    <span class="w-2 h-2 rounded-full bg-blue-600 mr-2 animate-pulse"></span>
                    <span class="text-xs font-semibold text-blue-800 uppercase tracking-wide">
                        Tahun Akademik <?= esc($tahunAktif['tahun']) ?>
                    </span>
                </div>
            <?php endif; ?>
        </div>

        <div class="flex items-center gap-3 self-end md:self-center">
            
            <div x-data="{ openNotif: false }" class="relative bell-group">
                <button @click="openNotif = !openNotif"
                        class="relative p-2.5 rounded-xl bg-white border border-slate-200 shadow-sm hover:shadow-md hover:border-blue-300 text-slate-600 hover:text-blue-700 transition-all duration-300">
                    <svg class="w-6 h-6 bell-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <span id="notifBadge" class="hidden absolute -top-1 -right-1 bg-rose-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full ring-2 ring-white">
                        0
                    </span>
                </button>

                <div x-show="openNotif" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     @click.outside="openNotif=false"
                     style="display: none;"
                     class="absolute right-0 mt-3 w-80 bg-white border border-slate-100 shadow-xl rounded-2xl z-50 overflow-hidden ring-1 ring-black/5">
                    <div class="px-4 py-3 border-b border-slate-100 bg-slate-50">
                        <h3 class="text-sm font-semibold text-slate-700">Notifikasi Terbaru</h3>
                    </div>
                    <ul id="notifList" class="max-h-60 overflow-y-auto divide-y divide-slate-50"></ul>
                    <div class="p-3 bg-slate-50 border-t border-slate-100 text-center">
                        <button @click="markAllNotif()" class="text-xs font-medium text-blue-600 hover:underline">Tandai semua dibaca</button>
                    </div>
                </div>
            </div>

            <div class="w-px h-8 bg-slate-200 mx-1 hidden sm:block"></div>

            <div x-data="{ openProfile: false }" class="relative">
                <button @click="openProfile = !openProfile"
                        class="flex items-center gap-3 p-1.5 pr-3 rounded-xl bg-white border border-slate-200 shadow-sm hover:shadow-md hover:border-blue-300 transition-all duration-300 group">
                    <div class="relative">
                        <img src="<?= base_url('uploads/profile/' . (session('foto') ?? 'default.png')) ?>"
                             class="w-9 h-9 rounded-lg object-cover ring-2 ring-slate-100 group-hover:ring-blue-100 transition-all">
                        <div class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-green-500 border-2 border-white rounded-full"></div>
                    </div>
                    <div class="hidden sm:block text-left">
                        <p class="text-xs font-bold text-slate-700 leading-tight tracking-wide uppercase">
                            <?= session('nama') ?>
                        </p>
                        <p class="text-[10px] text-slate-400 font-medium tracking-wider">STAFF POLBAN</p>
                    </div>
                    <svg class="w-4 h-4 text-slate-400 group-hover:text-blue-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div x-show="openProfile" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     @click.outside="openProfile = false"
                     style="display: none;"
                     class="absolute right-0 mt-3 w-52 bg-white border border-slate-100 shadow-xl rounded-2xl z-50 overflow-hidden ring-1 ring-black/5">
                    <div class="p-2 space-y-1">
                        <a href="<?= base_url('staff/profile') ?>"
                           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-600 hover:bg-blue-50 hover:text-blue-700 transition-all">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Profil Saya
                        </a>
                        <hr class="border-slate-100 mx-2">
                        <a href="<?= base_url('logout') ?>"
                           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-rose-600 hover:bg-rose-50 transition-all">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Keluar Sistem
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">

        <div class="relative bg-white rounded-2xl p-6 shadow-sm border border-slate-200 card-hover transition-all duration-300 group overflow-hidden">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-blue-50 rounded-full opacity-50"></div>
            <div class="relative z-10">
                <div class="flex items-center gap-2 mb-4 text-blue-600 font-bold text-sm uppercase tracking-widest">
                    <span class="p-2 bg-blue-100 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2" />
                        </svg>
                    </span>
                    Tugas PIC Aktif
                </div>
                <div class="flex items-baseline gap-2">
                    <h3 class="text-4xl font-extrabold text-slate-800 tracking-tight"><?= esc($totalPicAktif ?? 0) ?></h3>
                    <span class="text-slate-400 font-medium">Indikator</span>
                </div>
                <p class="text-xs text-slate-500 mt-2">Daftar tanggung jawab yang perlu diperbarui.</p>
                <div class="mt-6 pt-4 border-t border-slate-50">
                    <a href="<?= site_url('staff/task') ?>" class="text-sm font-bold text-blue-600 hover:text-blue-800 inline-flex items-center gap-1 group/link">
                        Kelola Tugas <svg class="w-4 h-4 transition-transform group-hover/link:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M13 7l5 5m0 0l-5 5m5-5H6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </a>
                </div>
            </div>
        </div>

        <div class="relative bg-white rounded-2xl p-6 shadow-sm border border-slate-200 card-hover transition-all duration-300 group overflow-hidden">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-rose-50 rounded-full opacity-50"></div>
            <div class="relative z-10">
                <div class="flex items-center gap-2 mb-4 text-rose-600 font-bold text-sm uppercase tracking-widest">
                    <span class="p-2 bg-rose-100 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </span>
                    Perlu Revisi
                </div>
                <div class="flex items-baseline gap-2">
                    <h3 class="text-4xl font-extrabold text-rose-600 tracking-tight"><?= esc($dokumenRevisi ?? 0) ?></h3>
                    <span class="text-slate-400 font-medium">Dokumen</span>
                </div>
                <p class="text-xs text-slate-500 mt-2">Segera perbaiki bukti dukung yang ditolak.</p>
                <div class="mt-6 pt-4 border-t border-slate-50">
                    <a href="<?= site_url('staff/dokumen') ?>" class="text-sm font-bold text-rose-600 hover:text-rose-800 inline-flex items-center gap-1 group/link">
                        Lihat Detail <svg class="w-4 h-4 transition-transform group-hover/link:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M13 7l5 5m0 0l-5 5m5-5H6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </a>
                </div>
            </div>
        </div>

    </div>

    <div class="bg-gradient-to-br from-white to-slate-50 border border-slate-200 rounded-2xl p-6 shadow-sm">
        <div class="flex items-center mb-6">
            <div class="w-1.5 h-6 bg-amber-500 rounded-full mr-3"></div>
            <h4 class="text-lg font-bold text-slate-800 tracking-tight">Aksi Cepat</h4>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            
            <a href="<?= site_url('staff/task') ?>"
               class="flex items-center justify-between p-4 rounded-xl bg-white border border-slate-200 hover:border-blue-400 hover:shadow-md transition-all group">
                <div class="flex items-center gap-3">
                    <div class="p-2.5 rounded-xl bg-blue-50 text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-all">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                    </div>
                    <div>
                        <span class="block text-sm font-bold text-slate-700">Isi Pengukuran</span>
                        <span class="text-[10px] text-slate-400 uppercase tracking-wider font-semibold">Update Capaian</span>
                    </div>
                </div>
                <svg class="w-5 h-5 text-slate-300 group-hover:text-blue-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
            </a>

            <a href="<?= site_url('staff/dokumen/create') ?>"
               class="flex items-center justify-between p-4 rounded-xl bg-white border border-slate-200 hover:border-green-400 hover:shadow-md transition-all group">
                <div class="flex items-center gap-3">
                    <div class="p-2.5 rounded-xl bg-green-50 text-green-600 group-hover:bg-green-600 group-hover:text-white transition-all">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" /></svg>
                    </div>
                    <div>
                        <span class="block text-sm font-bold text-slate-700">Upload Dokumen</span>
                        <span class="text-[10px] text-slate-400 uppercase tracking-wider font-semibold">Lampirkan Bukti</span>
                    </div>
                </div>
                <svg class="w-5 h-5 text-slate-300 group-hover:text-green-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
            </a>

            <a href="<?= site_url('staff/dokumen/arsip') ?>"
               class="flex items-center justify-between p-4 rounded-xl bg-white border border-slate-200 hover:border-slate-400 hover:shadow-md transition-all group">
                <div class="flex items-center gap-3">
                    <div class="p-2.5 rounded-xl bg-slate-100 text-slate-600 group-hover:bg-slate-700 group-hover:text-white transition-all">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z" /></svg>
                    </div>
                    <div>
                        <span class="block text-sm font-bold text-slate-700">Arsip Dokumen</span>
                        <span class="text-[10px] text-slate-400 uppercase tracking-wider font-semibold">Riwayat Berkas</span>
                    </div>
                </div>
                <svg class="w-5 h-5 text-slate-300 group-hover:text-slate-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
            </a>

        </div>
    </div>

    <div class="mt-16 pt-8 border-t border-slate-200 flex flex-col md:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 bg-slate-200 rounded-lg flex items-center justify-center font-bold text-slate-400 text-xs">KT</div>
            <p class="text-xs text-slate-400 font-medium tracking-wide uppercase">
                © <?= date('Y') ?> <span class="text-slate-600 font-bold">KINETRACK</span> — Politeknik Negeri Bandung
            </p>
        </div>
        <div class="flex gap-6">
            <span class="text-[10px] text-slate-300 uppercase tracking-widest font-bold">Integritas</span>
            <span class="text-[10px] text-slate-300 uppercase tracking-widest font-bold">Transparansi</span>
            <span class="text-[10px] text-slate-300 uppercase tracking-widest font-bold">Kinerja</span>
        </div>
    </div>

</div>

<?= $this->endSection() ?>