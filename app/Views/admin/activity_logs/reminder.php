<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<div class="max-w-6xl mx-auto py-10 px-6">

    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <span class="px-2 py-0.5 rounded-md bg-blue-100 text-blue-700 text-[10px] font-bold uppercase tracking-wider">System Engine</span>
                <div class="h-px w-8 bg-gray-200"></div>
            </div>
            <h1 class="text-4xl font-black text-[#003366] tracking-tight">
                Reminder <span class="text-blue-600">Scheduler</span>
            </h1>
            <p class="text-gray-400 mt-2 font-medium">
                Log otomatisasi pengiriman notifikasi dan pemeliharaan rutin sistem.
            </p>
        </div>
        
        <div class="flex items-center gap-4 bg-white p-2 pr-6 rounded-2xl border border-gray-100 shadow-sm">
            <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center text-green-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
            </div>
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase leading-none mb-1">Engine Health</p>
                <p class="text-sm font-black text-gray-800">Operational</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <div class="bg-gradient-to-br from-white to-gray-50 p-5 rounded-3xl border border-gray-100 shadow-sm">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-white rounded-2xl shadow-sm text-blue-600 border border-gray-50">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <h4 class="text-[11px] font-bold text-gray-400 uppercase tracking-widest">Automation Mode</h4>
                    <p class="text-sm font-extrabold text-[#003366]">Real-time Cronjob</p>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-white to-gray-50 p-5 rounded-3xl border border-gray-100 shadow-sm">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-white rounded-2xl shadow-sm text-indigo-600 border border-gray-50">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                </div>
                <div>
                    <h4 class="text-[11px] font-bold text-gray-400 uppercase tracking-widest">Source Data</h4>
                    <p class="text-sm font-extrabold text-[#003366]">Internal Database</p>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-white to-gray-50 p-5 rounded-3xl border border-gray-100 shadow-sm">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-white rounded-2xl shadow-sm text-orange-600 border border-gray-50">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <div>
                    <h4 class="text-[11px] font-bold text-gray-400 uppercase tracking-widest">Efficiency</h4>
                    <p class="text-sm font-extrabold text-[#003366]">Optimized Threads</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-[2rem] shadow-[0_20px_50px_rgba(0,0,0,0.02)] border border-gray-100 overflow-hidden">
        
        <div class="px-8 py-6 border-b border-gray-50 bg-white flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-1.5 h-5 bg-blue-600 rounded-full"></div>
                <h2 class="font-black text-gray-800 tracking-tight">Activity Stream</h2>
            </div>
            <span class="text-[10px] font-bold text-gray-300 uppercase tracking-[0.2em]">Live Updates</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50">
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.15em]">Execution Time</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.15em]">Process Details</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.15em] text-center">Ref. Table</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.15em] text-center">Volume</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.15em] text-right">Outcome</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-50">
                    <?php if (empty($reminders)): ?>
                        <tr>
                            <td colspan="5" class="py-32 text-center">
                                <div class="relative inline-block">
                                    <div class="absolute inset-0 bg-blue-50 rounded-full blur-2xl opacity-50"></div>
                                    <svg class="relative w-16 h-16 text-gray-200 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                                </div>
                                <p class="text-gray-400 font-bold italic tracking-tight">No automated logs found in current buffer.</p>
                            </td>
                        </tr>
                    <?php else: foreach ($reminders as $r): ?>
                        <tr class="hover:bg-blue-50/30 transition-all duration-300 group">
                            <td class="px-8 py-6">
                                <div class="flex flex-col">
                                    <span class="text-sm font-black text-gray-900 leading-none mb-1"><?= date('H:i', strtotime($r['executed_at'])) ?></span>
                                    <span class="text-[10px] font-bold text-gray-400 uppercase"><?= date('d M Y', strtotime($r['executed_at'])) ?></span>
                                </div>
                            </td>

                            <td class="px-8 py-6">
                                <div class="flex items-start gap-4">
                                    <div class="mt-1 w-2 h-2 rounded-full bg-blue-600 shadow-[0_0_8px_rgba(37,99,235,0.4)]"></div>
                                    <div class="max-w-xs">
                                        <p class="text-[11px] font-black text-[#003366] uppercase tracking-tighter mb-1"><?= esc($r['action_type']) ?></p>
                                        <p class="text-[13px] text-gray-500 font-medium leading-relaxed"><?= esc($r['message']) ?></p>
                                    </div>
                                </div>
                            </td>

                            <td class="px-8 py-6 text-center">
                                <span class="px-3 py-1 rounded-lg bg-gray-50 text-gray-400 text-[10px] font-bold border border-gray-100 group-hover:bg-white transition-colors">
                                    <?= esc($r['related_table']) ?>
                                </span>
                            </td>

                            <td class="px-8 py-6 text-center">
                                <div class="inline-flex flex-col">
                                    <span class="text-sm font-black text-gray-800">
                                        <?= number_format($r['total_data']) ?>
                                    </span>
                                    <span class="text-[9px] font-bold text-gray-300 uppercase">Records</span>
                                </div>
                            </td>

                            <td class="px-8 py-6 text-right">
                                <?php if ($r['status'] === 'success'): ?>
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-green-50 text-green-600 text-[10px] font-black border border-green-100/50">
                                        <span class="w-1 h-1 rounded-full bg-green-500"></span>
                                        SUCCESS
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-red-50 text-red-600 text-[10px] font-black border border-red-100/50">
                                        <span class="w-1 h-1 rounded-full bg-red-500"></span>
                                        FAILED
                                    </span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>

        <div class="px-8 py-6 bg-gray-50/30 border-t border-gray-50 flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-2 text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Engine Logs are retained for 30 days
            </div>
            <div class="flex gap-2">
                <button class="w-10 h-10 flex items-center justify-center bg-white border border-gray-200 rounded-xl text-gray-400 hover:text-blue-600 hover:border-blue-200 transition-all shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </button>
                <button class="w-10 h-10 flex items-center justify-center bg-white border border-gray-200 rounded-xl text-gray-400 hover:text-blue-600 hover:border-blue-200 transition-all shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </button>
            </div>
        </div>
    </div>

    <div class="mt-12 flex flex-col items-center">
        <div class="h-px w-24 bg-gradient-to-r from-transparent via-gray-200 to-transparent mb-6"></div>
        <p class="text-[11px] text-gray-400 text-center max-w-lg leading-relaxed uppercase tracking-[0.2em] font-bold">
            Data integrity is monitored by <span class="text-blue-600">e-Kinerja Automation Core</span>. 
        </p>
    </div>

</div>

<style>
    body { background-color: #FAFBFF; }
    
    /* Smooth Scroll & Font Enhancements */
    .tracking-tighter { letter-spacing: -0.05em; }
    
    @keyframes pulse-soft {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.7; }
    }
    .animate-pulse-soft {
        animation: pulse-soft 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
</style>

<?= $this->endSection() ?>