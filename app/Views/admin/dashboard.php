<?= $this->extend('layout/admin_template') ?>
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
        box-shadow: 0 10px 20px -5px rgba(30, 58, 138, 0.1); /* Blue shadow hint */
        border-color: #bfdbfe;
    }
    /* Scrollbar halus untuk notifikasi */
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
                Dashboard Admin
            </h1>
            <p class="text-slate-500 mt-1 text-sm">
                Sistem Manajemen Kinerja Politeknik Negeri Bandung
            </p>
            
            <?php if ($tahun_aktif): ?>
                <div class="mt-4 inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-blue-50 border border-blue-200 shadow-sm">
                    <span class="flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-2 w-2 rounded-full bg-blue-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-600"></span>
                    </span>
                    <span class="text-xs font-bold text-blue-800 uppercase tracking-wide">
                        TA <?= esc($tahun_aktif['tahun']) ?> 
                        <span class="text-slate-300 mx-1">|</span> 
                        <?= $tw_aktif ? 'Triwulan ' . esc($tw_aktif['tw']) : 'TW Belum Set' ?>
                    </span>
                </div>
            <?php else: ?>
                <div class="mt-4 inline-flex px-3 py-1 bg-red-50 text-red-600 rounded-full text-xs font-bold border border-red-200">
                    ⚠️ Tahun Anggaran Belum Diset
                </div>
            <?php endif; ?>
        </div>

        <div class="flex items-center gap-4 self-end lg:self-center">
            
            <div x-data="{ open: false }" class="relative bell-group">
                <button @click="open = !open"
                    class="relative p-2.5 rounded-xl bg-white border border-slate-200 shadow-sm hover:bg-blue-50 hover:border-blue-300 text-slate-600 hover:text-blue-700 transition-all">
                    <svg class="w-6 h-6 bell-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>

                    <span id="notifBadge"
                        class="absolute -top-1 -right-1 bg-rose-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full ring-2 ring-white shadow-sm
                        <?= $unreadCount == 0 ? 'hidden' : '' ?>">
                        <?= $unreadCount ?>
                    </span>
                </button>

                <div x-show="open"
     @click.outside="open = false"
     x-transition:enter="transition ease-out duration-200"
     x-transition:enter-start="opacity-0 translate-y-2"
     x-transition:enter-end="opacity-100 translate-y-0"
     x-cloak
     class="absolute right-0 mt-3 w-80 bg-white border border-slate-100
            rounded-2xl shadow-xl z-50 overflow-hidden ring-1 ring-black/5">

    <div class="px-4 py-3 bg-slate-50 border-b border-slate-100
                flex justify-between items-center">
        <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider">
            Notifikasi
        </h3>
        <span class="text-[10px] bg-blue-100 text-blue-700 px-2 py-0.5
                     rounded-full font-bold">
            <?= $unreadCount ?> Baru
        </span>
    </div>

    <ul id="notifList"
        class="max-h-64 overflow-y-auto divide-y divide-slate-50 custom-scrollbar">

        <?php if (empty($notifications)): ?>
            <li class="p-6 text-sm text-slate-400 text-center italic">
                Tidak ada notifikasi baru
            </li>
        <?php else: ?>
            <?php foreach ($notifications as $notif): ?>
                <li class="p-4 hover:bg-slate-50 transition-colors
                    <?= $notif['status'] === 'unread' ? 'bg-blue-50/40' : '' ?>">
                    
                    <div class="text-sm text-slate-700 font-medium leading-snug">
                        <?= esc($notif['message']) ?>
                    </div>

                    <div class="text-[10px] text-slate-400 mt-1.5">
                        <?= date('d M H:i', strtotime($notif['created_at'])) ?>
                    </div>
                </li>
            <?php endforeach; ?>
        <?php endif; ?>

    </ul>

    <div class="p-3 bg-slate-50 border-t border-slate-100 text-center">
        <button onclick="markAllNotif()"
            class="text-xs font-bold text-blue-600 hover:text-blue-800 hover:underline">
            Tandai semua dibaca
        </button>
    </div>
</div>

</div> <!-- penutup x-data -->


            <div class="w-px h-8 bg-slate-200 hidden sm:block"></div>

            <div class="flex items-center justify-end">
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open"
                        class="flex items-center gap-3 p-1.5 pr-3 rounded-xl bg-white border border-slate-200 shadow-sm hover:shadow-md hover:border-blue-300 transition-all duration-300 group">
                        <img src="<?= base_url('uploads/profile/' . (session('foto') ?? 'default.png')) ?>"
                            class="w-9 h-9 rounded-lg object-cover ring-2 ring-slate-100 group-hover:ring-blue-100 border border-slate-200 transition-all">
                        
                        <div class="hidden sm:block text-left">
                            <span class="block text-xs font-bold text-slate-700 leading-tight tracking-wide">
                                <?= session('nama') ?>
                            </span>
                            <span class="text-[10px] text-slate-400 font-medium tracking-wider uppercase">Administrator</span>
                        </div>
                        
                        <svg class="w-4 h-4 text-slate-400 group-hover:text-blue-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div x-show="open" x-transition @click.away="open = false" style="display: none;"
                        class="absolute right-0 mt-3 w-52 bg-white shadow-xl rounded-2xl border border-slate-100 py-2 z-50 ring-1 ring-black/5">
                        <div class="px-2 space-y-1">
                            <a href="<?= base_url('admin/profile') ?>"
                                class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-600 hover:bg-blue-50 hover:text-blue-700 transition-all">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                Profil Saya
                            </a>
                            <div class="h-px bg-slate-100 my-1 mx-2"></div>
                            <a href="<?= base_url('logout') ?>"
                                class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-red-600 hover:bg-red-50 transition-all">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                                Logout
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">

        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm card-hover flex items-center justify-between group">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Total User</p>
                <h3 class="text-3xl font-extrabold text-slate-800"><?= number_format($total_user) ?></h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center transition-transform group-hover:scale-110">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm card-hover flex items-center justify-between group">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Total Jabatan</p>
                <h3 class="text-3xl font-extrabold text-slate-800"><?= number_format($total_jabatan) ?></h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-500 flex items-center justify-center transition-transform group-hover:scale-110">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm card-hover flex items-center justify-between group">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Unit Kerja</p>
                <h3 class="text-3xl font-extrabold text-slate-800"><?= number_format($total_unit) ?></h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center transition-transform group-hover:scale-110">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm card-hover flex items-center justify-between group">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Total Indikator</p>
                <h3 class="text-3xl font-extrabold text-slate-800"><?= number_format($total_indikator) ?></h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-violet-50 text-violet-600 flex items-center justify-center transition-transform group-hover:scale-110">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
            </div>
        </div>

    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-10">
        
        <div class="lg:col-span-2 bg-white rounded-2xl p-6 border border-slate-200 shadow-sm relative overflow-hidden flex flex-col justify-center">
            <div class="absolute top-0 right-0 p-4 opacity-5">
                <svg class="w-40 h-40 text-blue-900" fill="currentColor" viewBox="0 0 24 24"><path d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            </div>

            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="font-bold text-lg text-slate-800 flex items-center gap-2">
                            <span class="w-1.5 h-6 bg-blue-600 rounded-full"></span>
                            Capaian Kinerja Global
                        </h3>
                        <p class="text-sm text-slate-500 mt-1">Akumulasi pengisian indikator seluruh unit.</p>
                    </div>
                    <div class="text-right">
                        <span class="text-4xl font-black text-blue-700 block"><?= $persentase_progres ?>%</span>
                        <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Terisi</span>
                    </div>
                </div>

                <div class="w-full bg-slate-100 rounded-full h-4 mb-4 overflow-hidden shadow-inner ring-1 ring-slate-200">
                    <div class="bg-gradient-to-r from-blue-700 to-blue-400 h-4 rounded-full transition-all duration-1000 ease-out"
                         style="width: <?= $persentase_progres ?>%"></div>
                </div>
                
                <div class="grid grid-cols-3 gap-4 mt-2">
                    <div class="bg-blue-50/50 p-3 rounded-xl border border-blue-100">
                        <span class="block text-xs text-blue-600 font-bold uppercase">Target</span>
                        <span class="block text-lg font-bold text-slate-800"><?= $total_indikator ?></span>
                    </div>
                    <div class="bg-green-50/50 p-3 rounded-xl border border-green-100">
                        <span class="block text-xs text-green-600 font-bold uppercase">Sudah Isi</span>
                        <span class="block text-lg font-bold text-slate-800"><?= $indikator_terisi ?></span>
                    </div>
                    <div class="bg-slate-50 p-3 rounded-xl border border-slate-100">
                        <span class="block text-xs text-slate-500 font-bold uppercase">Belum</span>
                        <span class="block text-lg font-bold text-slate-800"><?= $total_indikator - $indikator_terisi ?></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 flex flex-col h-full">
            <h3 class="font-bold text-slate-800 mb-4 text-sm uppercase tracking-widest border-b border-slate-100 pb-2">Status Dokumen</h3>
            
            <div class="space-y-3 flex-1">
                <div class="flex items-center justify-between p-3 rounded-xl bg-orange-50 border border-orange-100 hover:shadow-sm transition-all">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-white rounded-lg text-orange-500 shadow-sm">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <div>
                            <span class="block font-bold text-slate-700">List Pengajuan Kategori</span>
                            <span class="text-xs text-slate-500">Butuh Validasi</span>
                        </div>
                    </div>
                    <span class="text-xl font-bold text-orange-600"><?= $dokumen_pending ?></span>
                </div>

                <div class="flex items-center justify-between p-3 rounded-xl bg-emerald-50 border border-emerald-100 hover:shadow-sm transition-all">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-white rounded-lg text-emerald-600 shadow-sm">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <div>
                            <span class="block font-bold text-slate-700">Dokumen Tervalidasi</span>
                            <span class="text-xs text-slate-500">Diterima</span>
                        </div>
                    </div>
                    <span class="text-xl font-bold text-emerald-600"><?= $dokumen_valid ?></span>
                </div>

                <div class="flex items-center justify-between p-3 rounded-xl bg-red-50 border border-red-100 hover:shadow-sm transition-all">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-white rounded-lg text-red-600 shadow-sm">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                        </div>
                        <div>
                            <span class="block font-bold text-slate-700">Dokumen Tidak Tervalidasi</span>
                            <span class="text-xs text-slate-500">Ditolak</span>
                        </div>
                    </div>
                    <span class="text-xl font-bold text-red-600"><?= $dokumen_tidak_tervalidasi ?></span>
                </div>
            </div>
        </div>

    </div>

    <div class="mb-10">
        <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
            Menu Akses Cepat
        </h3>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            
            <a href="<?= base_url('admin/users') ?>" class="group bg-white p-4 rounded-xl border border-slate-200 hover:border-blue-400 hover:shadow-md transition-all flex items-start gap-4">
                <div class="p-3 bg-blue-50 text-blue-600 rounded-lg group-hover:bg-blue-600 group-hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                </div>
                <div>
                    <h4 class="font-bold text-slate-800 group-hover:text-blue-700">Kelola User</h4>
                    <p class="text-xs text-slate-500 mt-1">Manajemen akun pengguna & hak akses.</p>
                </div>
            </a>

            <a href="<?= base_url('admin/bidang') ?>" class="group bg-white p-4 rounded-xl border border-slate-200 hover:border-indigo-400 hover:shadow-md transition-all flex items-start gap-4">
                <div class="p-3 bg-indigo-50 text-indigo-600 rounded-lg group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                </div>
                <div>
                    <h4 class="font-bold text-slate-800 group-hover:text-indigo-700">Unit Kerja</h4>
                    <p class="text-xs text-slate-500 mt-1">Data departemen dan unit di Polban.</p>
                </div>
            </a>

            <a href="<?= base_url('admin/tahun') ?>" class="group bg-white p-4 rounded-xl border border-slate-200 hover:border-emerald-400 hover:shadow-md transition-all flex items-start gap-4">
                <div class="p-3 bg-emerald-50 text-emerald-600 rounded-lg group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                </div>
                <div>
                    <h4 class="font-bold text-slate-800 group-hover:text-emerald-700">Tahun Anggaran</h4>
                    <p class="text-xs text-slate-500 mt-1">Setting periode aktif & triwulan.</p>
                </div>
            </a>

            <a href="<?= base_url('admin/indikator') ?>" class="group bg-white p-4 rounded-xl border border-slate-200 hover:border-violet-400 hover:shadow-md transition-all flex items-start gap-4">
                <div class="p-3 bg-violet-50 text-violet-600 rounded-lg group-hover:bg-violet-600 group-hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                </div>
                <div>
                    <h4 class="font-bold text-slate-800 group-hover:text-violet-700">Indikator</h4>
                    <p class="text-xs text-slate-500 mt-1">Bank data indikator kinerja utama.</p>
                </div>
            </a>
            
            <a href="<?= base_url('admin/pic') ?>" class="group bg-white p-4 rounded-xl border border-slate-200 hover:border-rose-400 hover:shadow-md transition-all flex items-start gap-4">
                <div class="p-3 bg-rose-50 text-rose-600 rounded-lg group-hover:bg-rose-600 group-hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                </div>
                <div>
                    <h4 class="font-bold text-slate-800 group-hover:text-rose-700">Kelola PIC</h4>
                    <p class="text-xs text-slate-500 mt-1">Penugasan Staff ke Indikator.</p>
                </div>
            </a>

            <a href="<?= base_url('admin/grafik') ?>" class="group bg-white p-4 rounded-xl border border-slate-200 hover:border-cyan-400 hover:shadow-md transition-all flex items-start gap-4">
                <div class="p-3 bg-cyan-50 text-cyan-600 rounded-lg group-hover:bg-cyan-600 group-hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" /></svg>
                </div>
                <div>
                    <h4 class="font-bold text-slate-800 group-hover:text-cyan-700">Laporan Grafik</h4>
                    <p class="text-xs text-slate-500 mt-1">Visualisasi data capaian sistem.</p>
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
            <span class="text-[10px] text-slate-300 uppercase tracking-widest font-bold">Administrator Mode</span>
        </div>
    </div>

</div>

<?= $this->endSection() ?>