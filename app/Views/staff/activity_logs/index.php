<?= $this->extend('layout/staff_template') ?>
<?= $this->section('content') ?>

<div class="max-w-6xl mx-auto px-4 py-8 space-y-8">
    
    <div class="relative overflow-hidden bg-white rounded-3xl border border-gray-100 shadow-sm p-8">
        <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-bl from-[#1D2F83]/5 to-transparent rounded-full -mr-32 -mt-32"></div>
        
        <div class="relative flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="flex items-center gap-5">
                <div class="w-14 h-14 rounded-2xl bg-[#1D2F83] flex items-center justify-center shadow-lg shadow-blue-900/20">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Log <span class="text-[#1D2F83]">Aktivitas Saya</span></h1>
                    <div class="flex items-center gap-2 mt-1">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                        </span>
                        <p class="text-sm text-gray-500 font-medium">Riwayat seluruh aktivitas Anda dalam sistem KINETRACK</p>
                    </div>
                </div>
            </div>

            <div class="hidden md:block">
                <div class="px-4 py-2 rounded-xl bg-blue-50 border border-blue-100 text-blue-700 text-xs font-bold uppercase tracking-wider">
                    Monitoring Keamanan Aktif
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-3xl border border-gray-100 shadow-xl overflow-hidden relative">
        <div class="absolute left-10 top-0 bottom-0 w-px bg-gray-100 hidden md:block"></div>

        <div class="divide-y divide-gray-50">
            <?php if (empty($logs)): ?>
                <div class="py-20 text-center">
                    <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-gray-100 text-gray-300">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2-2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                        </svg>
                    </div>
                    <h3 class="text-gray-900 font-bold">Belum Ada Aktivitas</h3>
                    <p class="text-sm text-gray-500">Sistem belum mencatat riwayat untuk akun Anda.</p>
                </div>
            <?php else: ?>
                <?php foreach ($logs as $log): ?>
                <div class="group relative p-6 hover:bg-gray-50/80 transition-all duration-300">
                    <div class="relative flex flex-col md:flex-row md:items-start gap-6">
                        
                        <div class="hidden md:flex flex-shrink-0 z-10">
                            <div class="w-10 h-10 rounded-full bg-white border-2 border-gray-100 flex items-center justify-center shadow-sm group-hover:border-[#1D2F83] transition-colors">
                                <svg class="w-5 h-5 text-gray-400 group-hover:text-[#1D2F83]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 20a8 8 0 100-16 8 8 0 000 16z"/>
                                </svg>
                            </div>
                        </div>

                        <div class="flex-grow space-y-3">
                            <div class="flex flex-wrap items-center gap-3">
                                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wide">
                                    Activity Recorded
                                </h3>
                                <?php if (!empty($log['ip_address'])): ?>
                                <span class="text-[10px] px-2.5 py-0.5 rounded-lg border font-bold bg-gray-50 text-gray-500 border-gray-100">
                                    IP: <?= esc($log['ip_address']) ?>
                                </span>
                                <?php endif; ?>
                            </div>

                            <div class="relative">
                                <div class="absolute left-0 top-0 w-1 h-full bg-gray-100 rounded-full group-hover:bg-[#1D2F83]/20 transition-colors"></div>
                                <p class="text-[13px] text-gray-600 leading-relaxed pl-4 italic">
                                    "<?= esc($log['description']) ?>"
                                </p>
                            </div>
                        </div>

                        <div class="md:text-right flex-shrink-0 flex md:flex-col items-center md:items-end gap-2 md:gap-0">
                            <p class="text-xs font-bold text-gray-900"><?= date('d M Y', strtotime($log['created_at'])) ?></p>
                            <p class="text-[11px] text-gray-400 font-medium uppercase"><?= date('H:i:s', strtotime($log['created_at'])) ?> WIB</p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <div class="pt-8 border-t border-gray-200">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center font-bold text-gray-400 text-xs">KT</div>
            <p class="text-[11px] text-gray-400 font-medium tracking-wide uppercase">
                © <?= date('Y') ?> <span class="text-gray-600 font-bold">KINETRACK</span> — Politeknik Negeri Bandung
            </p>
        </div>
    </div>
</div>

<style>
    body { background-color: #f8fafc; }
</style>

<?= $this->endSection() ?>