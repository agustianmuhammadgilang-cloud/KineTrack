<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<div class="max-w-6xl mx-auto py-10 px-6">

    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <span class="px-2 py-0.5 rounded-md bg-amber-100 text-amber-700 text-[10px] font-black uppercase tracking-wider">Vault Storage</span>
                <div class="h-px w-8 bg-gray-200"></div>
            </div>
            <h1 class="text-4xl font-black text-[#003366] tracking-tight">
                Archive <span class="text-amber-500">History</span>
            </h1>
            <p class="text-gray-400 mt-2 font-medium">
                Penyimpanan data historis sistem untuk kebutuhan audit dan pemantauan jangka panjang.
            </p>
        </div>
        
        <form action="<?= base_url('admin/activity-logs/archive/backup') ?>" method="post">
            <?= csrf_field() ?>
            <button class="group inline-flex items-center px-6 py-3.5 bg-[#003366] hover:bg-blue-800 text-white text-[11px] font-black uppercase tracking-widest rounded-2xl transition-all shadow-lg shadow-blue-900/20 gap-3 transform hover:-translate-y-1 active:scale-95">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-amber-400 group-hover:rotate-12 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                </svg>
                Backup All Archive
            </button>
        </form>
    </div>

    <div class="bg-gradient-to-r from-blue-600 to-[#003366] p-6 rounded-[2rem] mb-10 shadow-xl shadow-blue-900/10 relative overflow-hidden">
        <div class="absolute right-0 top-0 opacity-10 transform translate-x-10 -translate-y-10">
            <svg class="w-64 h-64 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4a2 2 0 012-2h4.586A1 1 0 0111 2.414l2.586 2.586a1 1 0 01.293.707V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"/></svg>
        </div>
        <div class="relative flex flex-col md:flex-row items-center gap-6">
            <div class="w-14 h-14 bg-white/10 backdrop-blur-md rounded-2xl flex items-center justify-center border border-white/20">
                <svg class="h-7 w-7 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <h3 class="text-sm font-black text-white uppercase tracking-widest leading-none mb-1">Storage Policy</h3>
                <p class="text-blue-100 text-xs font-medium opacity-80 uppercase tracking-tighter">Auto-Archive: > 3 Months | Auto-Purge: 6 Months (Mandatory Backup)</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-[2rem] shadow-[0_20px_50px_rgba(0,0,0,0.02)] border border-gray-100 overflow-hidden">
        
        <div class="px-8 py-6 border-b border-gray-50 bg-white flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-1.5 h-5 bg-amber-500 rounded-full"></div>
                <h2 class="font-black text-gray-800 tracking-tight">Vault Records</h2>
            </div>
            <span class="text-[10px] font-bold text-gray-300 uppercase tracking-[0.2em]">Historical Data Only</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50">
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.15em]">Time Snapshot</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.15em]">Initiator</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.15em]">Activity Description</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.15em] text-right">System Object</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-50">
                    <?php if (empty($logs)): ?>
                        <tr>
                            <td colspan="4" class="py-32 text-center">
                                <div class="relative inline-block">
                                    <div class="absolute inset-0 bg-amber-50 rounded-full blur-2xl opacity-50"></div>
                                    <svg class="relative w-16 h-16 text-gray-200 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                                </div>
                                <p class="text-gray-400 font-bold italic tracking-tight">Vault is currently empty.</p>
                            </td>
                        </tr>
                    <?php else: foreach ($logs as $log): ?>
                        <tr class="hover:bg-amber-50/20 transition-all duration-300 group">
                            <td class="px-8 py-6">
                                <div class="flex flex-col border-l-2 border-transparent group-hover:border-amber-500 pl-4 transition-all">
                                    <span class="text-sm font-black text-gray-900 leading-none mb-1"><?= date('d M Y', strtotime($log['created_at'])) ?></span>
                                    <span class="text-[10px] font-bold text-gray-400 uppercase"><?= date('H:i', strtotime($log['created_at'])) ?> WIB</span>
                                </div>
                            </td>

                            <td class="px-8 py-6">
                                <div class="flex flex-col">
                                    <span class="text-sm font-black text-[#003366]"><?= esc($log['nama'] ?? 'System Engine') ?></span>
                                    <span class="inline-flex mt-1 text-[9px] font-black text-blue-600 bg-blue-50 px-2 py-0.5 rounded-md border border-blue-100 w-max uppercase tracking-tighter">
                                        <?= esc($log['role']) ?>
                                    </span>
                                </div>
                            </td>

                            <td class="px-8 py-6">
                                <p class="text-[13px] text-gray-500 font-medium leading-relaxed max-w-md">
                                    <?= esc($log['description']) ?>
                                </p>
                            </td>

                            <td class="px-8 py-6 text-right">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-gray-50 text-gray-500 text-[10px] font-black uppercase border border-gray-100 group-hover:bg-white transition-colors">
                                    <svg class="w-3 h-3 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                    <?= esc($log['subject_type'] ?? 'GENERAL') ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>

        <div class="px-8 py-6 bg-gray-50/30 border-t border-gray-50 flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-2 text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                Archive Engine Active
            </div>
            <div class="flex gap-2">
                <button class="w-10 h-10 flex items-center justify-center bg-white border border-gray-200 rounded-xl text-gray-400 hover:text-amber-600 hover:border-amber-200 transition-all shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </button>
                <button class="w-10 h-10 flex items-center justify-center bg-white border border-gray-200 rounded-xl text-gray-400 hover:text-amber-600 hover:border-amber-200 transition-all shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </button>
            </div>
        </div>
    </div>

    <div class="mt-12 flex flex-col items-center">
        <div class="h-1 w-12 bg-amber-400 rounded-full mb-6"></div>
        <p class="text-[11px] text-gray-400 text-center max-w-sm leading-relaxed uppercase tracking-[0.2em] font-bold">
            Data ini dioptimasi untuk <span class="text-[#003366]">Auditor</span> dan <span class="text-[#003366]">System Admin</span>.
        </p>
    </div>

</div>

<style>
    body { background-color: #FAFBFF; }
</style>

<?= $this->endSection() ?>