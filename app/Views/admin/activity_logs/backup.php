<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<div class="max-w-6xl mx-auto px-4 py-8 space-y-8">
    
    <div class="relative overflow-hidden bg-white rounded-3xl border border-gray-100 shadow-sm p-8">
        <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-bl from-[#1D2F83]/5 to-transparent rounded-full -mr-32 -mt-32"></div>
        
        <div class="relative flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="flex items-center gap-5">
                <div class="w-14 h-14 rounded-2xl bg-[#1D2F83] flex items-center justify-center shadow-lg shadow-blue-900/20">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Database <span class="text-[#1D2F83]">Archive Manager</span></h1>
                    <div class="flex items-center gap-2 mt-1">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                        </span>
                        <p class="text-sm text-gray-500 font-medium">Sistem Pemulihan & Pencadangan Aktif</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-5 rounded-3xl border border-gray-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-[#1D2F83] flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.58 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.58 4 8 4s8-1.79 8-4M4 7c0-2.21 3.58-4 8-4s8 1.79 8 4"/></svg>
            </div>
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Format Restore</p>
                <p class="text-sm font-bold text-gray-700">Wajib Berkas .JSON</p>
            </div>
        </div>
        <div class="bg-white p-5 rounded-3xl border border-gray-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-green-50 text-green-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Fungsi CSV</p>
                <p class="text-sm font-bold text-gray-700">Audit & Pelaporan Eksternal</p>
            </div>
        </div>
        <div class="bg-white p-5 rounded-3xl border border-gray-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04M12 21a11.955 11.955 0 01-8.618-3.04A11.955 11.955 0 012 7.843 11.952 11.952 0 0012 20.354a11.952 11.952 0 0010-12.511 11.955 11.955 0 01-8.618 3.04z"/></svg>
            </div>
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Integritas</p>
                <p class="text-sm font-bold text-gray-700">Auto Restored Mark</p>
            </div>
        </div>
    </div>

    <?php foreach (['success','error'] as $type): ?>
        <?php if (session()->getFlashdata($type)): ?>
            <div class="flex items-center p-4 rounded-2xl border <?= $type=='success'?'bg-green-50 border-green-100 text-green-700':'bg-red-50 border-red-100 text-red-700' ?> animate-fade-in shadow-sm">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?= $type=='success'?'M5 13l4 4L19 7':'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z' ?>"/>
                </svg>
                <span class="text-sm font-bold"><?= session()->getFlashdata($type) ?></span>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>

    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">
        <form method="get" class="flex flex-col md:flex-row gap-4 items-end">
            <div class="w-full md:w-48">
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Tanggal</label>
                <input type="date" name="date" value="<?= esc(request()->getGet('date')) ?>" 
                       class="w-full px-4 py-2.5 rounded-xl border border-gray-100 bg-gray-50 text-sm focus:ring-2 focus:ring-blue-100 focus:bg-white transition-all outline-none">
            </div>
            <div class="flex-1 w-full">
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Cari Arsip</label>
                <input type="text" name="q" placeholder="Nama file atau periode data..." value="<?= esc(request()->getGet('q')) ?>"
                       class="w-full px-4 py-2.5 rounded-xl border border-gray-100 bg-gray-50 text-sm focus:ring-2 focus:ring-blue-100 focus:bg-white transition-all outline-none">
            </div>
            <div class="flex gap-2 w-full md:w-auto">
                <button type="submit" class="flex-1 md:flex-none px-6 py-2.5 bg-[#1D2F83] text-white rounded-xl text-xs font-bold hover:shadow-lg hover:shadow-blue-900/20 transition-all active:scale-95">
                    FILTER
                </button>
                <a href="<?= base_url('admin/activity-logs/backup') ?>" class="flex-1 md:flex-none px-6 py-2.5 bg-gray-100 text-gray-500 rounded-xl text-xs font-bold hover:bg-gray-200 transition-all text-center">
                    RESET
                </a>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-3xl border border-gray-100 shadow-xl overflow-hidden shadow-gray-200/50">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-50">
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Periode Arsip</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Jumlah Data</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Waktu Backup</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    <?php if (empty($backups)): ?>
                        <tr>
                            <td colspan="4" class="py-20 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                        <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                                    </div>
                                    <p class="text-gray-400 font-bold">Belum ada file cadangan</p>
                                </div>
                            </td>
                        </tr>
                    <?php else: foreach ($backups as $b): ?>
                        <tr class="hover:bg-gray-50/50 transition-all group">
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-[#1D2F83] flex items-center justify-center border border-blue-100 group-hover:bg-[#1D2F83] group-hover:text-white transition-all">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-gray-800 tracking-tight"><?= esc($b['period']) ?></p>
                                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-tighter">System Recovery Point</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6 text-center">
                                <span class="inline-block px-3 py-1 rounded-lg bg-red-50 text-red-600 text-xs font-black">
                                    <?= number_format($b['total']) ?> <span class="text-[10px] opacity-70 ml-1">LOGS</span>
                                </span>
                            </td>
                            <td class="px-8 py-6 text-center">
                                <p class="text-xs font-bold text-gray-700"><?= date('d M Y', strtotime($b['created_at'])) ?></p>
                                <p class="text-[10px] text-gray-400 font-medium tracking-widest"><?= date('H:i', strtotime($b['created_at'])) ?> WIB</p>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex justify-end gap-3">
                                    <a href="<?= base_url('admin/activity-logs/backup/download/'.$b['csv_file']) ?>"
                                       class="flex items-center gap-2 px-4 py-2 text-[10px] font-black text-gray-500 bg-white border border-gray-200 rounded-xl hover:border-[#1D2F83] hover:text-[#1D2F83] transition-all shadow-sm"
                                       title="Download CSV Audit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                        CSV AUDIT
                                    </a>

                                    <form action="<?= base_url('admin/activity-logs/backup/restore') ?>" method="post" class="inline"
                                          onsubmit="return confirm('PENTING: Sistem akan memulihkan data ini ke tabel aktif. Lanjutkan?');">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="file" value="<?= esc($b['json_file']) ?>">
                                        <button class="flex items-center gap-2 px-4 py-2 text-[10px] font-black bg-[#1D2F83] text-white rounded-xl hover:shadow-lg hover:shadow-blue-900/30 transition-all active:scale-95">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                            RESTORE
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="flex flex-col items-center py-6">
        <div class="w-12 h-1.5 bg-gray-100 rounded-full mb-4"></div>
        <p class="text-[10px] text-gray-400 text-center max-w-md leading-relaxed uppercase tracking-widest font-bold">
            Keamanan data Log Kampus adalah prioritas. Selalu verifikasi data setelah proses <span class="text-[#1D2F83]">Restoration</span> selesai dilakukan.
        </p>
    </div>

</div>

<style>
    body { background-color: #f8fafc; }
    @keyframes fade-in {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in { animation: fade-in 0.4s ease-out forwards; }
</style>

<?= $this->endSection() ?>