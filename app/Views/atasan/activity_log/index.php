<?= $this->extend('layout/atasan_template') ?>
<?= $this->section('content') ?>

<style>
    .card-hover:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
    }
</style>

<div class="min-h-screen bg-slate-50 px-6 py-8 font-sans text-slate-800">

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
        <div>
            <h1 class="text-3xl font-bold text-slate-900 tracking-tight">
                Log Aktivitas
            </h1>
            <p class="text-slate-500 mt-1 text-sm">
                Riwayat seluruh aktivitas Anda sebagai atasan dalam sistem <span class="font-semibold text-slate-700">KINETRACK</span>.
            </p>
            
            <div class="mt-3 inline-flex items-center px-3 py-1 rounded-full bg-blue-50 border border-blue-100 shadow-sm">
                <span class="w-2 h-2 rounded-full bg-blue-500 mr-2"></span>
                <span class="text-xs font-semibold text-blue-800 uppercase tracking-wide">
                    Audit Trail Manajemen
                </span>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        
        <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-white">
            <div class="flex items-center gap-2">
                <div class="w-1.5 h-6 bg-blue-600 rounded-full mr-1"></div>
                <h2 class="text-lg font-bold text-slate-800 tracking-tight">Daftar Riwayat</h2>
            </div>
        </div>

        <div class="p-6 bg-slate-50/30">
            <?php if (empty($logs)): ?>
                <div class="py-20 flex flex-col items-center justify-center text-center">
                    <div class="w-20 h-20 bg-slate-100 rounded-2xl flex items-center justify-center mb-4 text-slate-400">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-slate-700 font-bold">Belum Ada Aktivitas</h3>
                    <p class="text-slate-500 text-sm mt-1 max-w-xs">Sistem belum mencatat tindakan manajemen apa pun untuk akun Anda saat ini.</p>
                </div>
            <?php else: ?>
                <div class="space-y-4">
                    <?php foreach ($logs as $log): ?>
                    <div class="bg-white rounded-xl border border-slate-200 p-5 card-hover transition-all duration-300 group">
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0 p-3 rounded-xl bg-slate-50 text-slate-500 group-hover:bg-blue-50 group-hover:text-blue-600 transition-colors duration-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                                </svg>
                            </div>

                            <div class="flex-1">
                                <p class="text-slate-700 font-semibold leading-relaxed group-hover:text-slate-900 transition-colors">
                                    <?= esc($log['description']) ?>
                                </p>
                                
                                <div class="flex flex-wrap items-center gap-x-6 gap-y-2 mt-3">
                                    <div class="flex items-center gap-2 text-[11px] font-medium text-slate-400 uppercase tracking-wider">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3"/>
                                        </svg>
                                        <?= date('d M Y • H:i', strtotime($log['created_at'])) ?>
                                    </div>

                                    <?php if (!empty($log['ip_address'])): ?>
                                    <div class="flex items-center gap-2 text-[11px] font-medium text-slate-400 uppercase tracking-wider">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                        </svg>
                                        IP: <?= esc($log['ip_address']) ?>
                                    </div>
                                    <?php endif; ?>
                                    
                                    <div class="flex items-center px-2 py-0.5 rounded bg-slate-100 text-[10px] font-bold text-slate-500 uppercase tracking-tight">
                                        Action: <?= esc($log['action']) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="mt-16 pt-8 border-t border-slate-200 flex flex-col md:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 bg-slate-200 rounded-lg flex items-center justify-center font-bold text-slate-400 text-xs">KT</div>
            <p class="text-xs text-slate-400 font-medium tracking-wide uppercase">
                © <?= date('Y') ?> <span class="text-slate-600 font-bold">KINETRACK</span> — Politeknik Negeri Bandung
            </p>
        </div>
    </div>

</div>

<?= $this->endSection() ?>