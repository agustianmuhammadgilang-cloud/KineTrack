<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<div class="max-w-5xl mx-auto py-10 px-4">

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
        <div>
            <div class="flex items-center gap-3 mb-1">
                <a href="<?= base_url('admin/activity-logs/archive') ?>" 
                   class="group p-2 bg-white border border-gray-200 text-gray-400 hover:text-[#003366] hover:border-[#003366] rounded-xl transition-all duration-300 shadow-sm">
                    <svg class="w-5 h-5 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <h1 class="text-3xl font-black text-slate-800 tracking-tight">
                    Pembersihan <span class="text-[#003366]">Arsip</span>
                </h1>
            </div>
            <p class="text-slate-500 ml-12 font-medium">Manajemen pembersihan database secara instan dan aman.</p>
        </div>
        
        <div class="ml-12 md:ml-0 flex items-center gap-2 px-4 py-2 bg-slate-100 rounded-full border border-slate-200">
            <div class="w-2 h-2 rounded-full <?= $has_backup ? 'bg-green-500 animate-pulse' : 'bg-red-500' ?>"></div>
            <span class="text-xs font-bold text-slate-600 uppercase tracking-widest">
                <?= $has_backup ? 'Sistem Siap' : 'Sistem Terkunci' ?>
            </span>
        </div>
    </div>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="mb-8 p-4 bg-red-50 border border-red-200 text-red-700 rounded-2xl flex items-center gap-3 shadow-sm">
            <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="font-medium"><?= session()->getFlashdata('error') ?></span>
        </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
                <div class="flex items-center gap-4 mb-4">
                    <div class="p-3 bg-blue-50 text-blue-600 rounded-2xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Data Arsip</p>
                        <h3 class="text-3xl font-black text-slate-800"><?= number_format($total_archive) ?></h3>
                    </div>
                </div>
                <div class="pt-4 border-t border-slate-50">
                    <p class="text-xs text-slate-400 leading-relaxed italic">
                        *Data diambil langsung dari tabel <code class="bg-slate-100 px-1 rounded text-slate-600 font-bold italic text-[10px]">logs_archive</code>
                    </p>
                </div>
            </div>

            <div class="p-6 rounded-3xl shadow-sm border <?= $has_backup ? 'bg-green-50/50 border-green-100' : 'bg-red-50/50 border-red-100' ?>">
                <h3 class="text-sm font-bold <?= $has_backup ? 'text-green-800' : 'text-red-800' ?> mb-3 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                    Audit Keamanan
                </h3>
                <p class="text-sm <?= $has_backup ? 'text-green-700' : 'text-red-700' ?> leading-relaxed">
                    <?php if ($has_backup): ?>
                        Sistem mendeteksi file backup <strong>.json</strong> tersedia. Anda memiliki izin untuk membersihkan tabel.
                    <?php else: ?>
                        <strong>Peringatan!</strong> Tidak ada backup ditemukan. Silakan buat backup di menu 
                        <a href="<?= base_url('admin/activity-logs/archive') ?>" class="underline font-bold hover:opacity-80 transition-opacity">Log Arsip</a>.
                    <?php endif; ?>
                </p>
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="bg-white rounded-[2rem] shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
                <div class="bg-slate-900 px-8 py-6 text-white relative overflow-hidden">
                    <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-red-500/20 rounded-full blur-2xl"></div>
                    
                    <div class="relative z-10 flex items-center gap-4">
                        <div class="p-3 bg-red-500 rounded-2xl shadow-lg shadow-red-500/30">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold tracking-tight">Zona Pembersihan Darurat</h2>
                            <p class="text-slate-400 text-xs font-medium uppercase tracking-widest mt-0.5">Penghapusan Data Permanen</p>
                        </div>
                    </div>
                </div>

                <div class="p-8">
                    <form method="post" action="<?= base_url('admin/activity-logs/cleanup/run') ?>" 
                          onsubmit="return confirm('KONFIRMASI AKHIR: Apakah Anda yakin ingin menghapus data arsip? Tindakan ini tidak dapat dibatalkan.');">
                        <?= csrf_field() ?>

                        <div class="mb-10">
                            <label class="block text-sm font-bold text-slate-700 mb-4 uppercase tracking-wide">
                                Tentukan Rentang Waktu:
                            </label>
                            <div class="relative group">
                                <select name="scope" 
                                        class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-5 py-4 appearance-none focus:outline-none focus:border-[#003366] focus:bg-white transition-all text-slate-700 font-bold shadow-sm"
                                        <?= !$has_backup ? 'disabled' : '' ?>>
                                    <option value="all"> Hapus Seluruh Data Log Arsip</option>
                                    <option value="1"> Hapus Arsip > 1 Bulan</option>
                                    <option value="3"> Hapus Arsip > 3 Bulan</option>
                                    <option value="6"> Hapus Arsip > 6 Bulan</option>
                                </select>
                                <div class="absolute inset-y-0 right-5 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                            <p class="mt-3 text-xs text-slate-400 flex items-center gap-1.5 ml-1">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                                Pastikan Anda telah memverifikasi jangkauan data yang akan dihapus.
                            </p>
                        </div>

                        <div class="flex flex-col gap-4">
                            <button type="submit" 
                                    <?= !$has_backup ? 'disabled' : '' ?>
                                    class="relative group w-full overflow-hidden px-8 py-5 rounded-2xl font-black tracking-widest uppercase transition-all
                                    <?= $has_backup 
                                        ? 'bg-red-600 hover:bg-red-700 text-white shadow-xl shadow-red-200 active:scale-[0.98]' 
                                        : 'bg-slate-100 text-slate-400 cursor-not-allowed shadow-none' ?>">
                                <span class="relative z-10 flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                                    Jalankan Pembersihan Sekarang
                                </span>
                                <?php if($has_backup): ?>
                                    <div class="absolute inset-0 w-full h-full bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full group-hover:animate-[shimmer_1.5s_infinite]"></div>
                                <?php endif; ?>
                            </button>
                            
                            <?php if (!$has_backup): ?>
                                <div class="text-center">
                                    <span class="text-[11px] font-bold text-red-500 uppercase tracking-widest bg-red-50 px-3 py-1 rounded-full border border-red-100">
                                        Fitur Dinonaktifkan: Menunggu Backup File
                                    </span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes shimmer {
        100% { transform: translateX(100%); }
    }
</style>

<?= $this->endSection() ?>