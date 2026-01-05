<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<div class="max-w-6xl mx-auto px-4 py-8 space-y-8">
    
    <div class="relative overflow-hidden bg-white rounded-3xl border border-gray-100 shadow-sm p-8">
        <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-bl from-[#1D2F83]/5 to-transparent rounded-full -mr-32 -mt-32"></div>
        
        <div class="relative flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="flex items-center gap-5">
                <div class="w-14 h-14 rounded-2xl bg-[#1D2F83] flex items-center justify-center shadow-lg shadow-blue-900/20">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Audit <span class="text-[#1D2F83]">Log System</span></h1>
                    <div class="flex items-center gap-2 mt-1">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                        </span>
                        <p class="text-sm text-gray-500 font-medium">Monitoring Real-time Aktivitas Kinerja</p>
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-2 bg-gray-50 p-1.5 rounded-2xl border border-gray-100">
                <button onclick="filterLogs('all', this)" class="filter-btn active">Semua</button>
                <button onclick="filterLogs('admin', this)" class="filter-btn">Admin</button>
                <button onclick="filterLogs('atasan', this)" class="filter-btn">Atasan</button>
                <button onclick="filterLogs('staff', this)" class="filter-btn">Staff</button>
                <div class="w-px h-6 bg-gray-200 mx-1"></div>
                <button onclick="filterLogs('restore', this)" class="group flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold transition-all hover:bg-purple-100 text-purple-700 border border-transparent hover:border-purple-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    RESTORED
                </button>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-3xl border border-gray-100 shadow-xl overflow-hidden relative">
        <div class="absolute left-10 top-0 bottom-0 w-px bg-gray-100 hidden md:block"></div>

        <div class="divide-y divide-gray-50">
            <?php foreach ($logs as $log): ?>
                <?php
                    $isRestored = (int)($log['is_restored'] ?? 0) === 1;
                    $roleColor = match(strtolower($log['role'])) {
                        'admin' => 'bg-red-50 text-red-700 border-red-100',
                        'atasan' => 'bg-blue-50 text-blue-700 border-blue-100',
                        default => 'bg-green-50 text-green-700 border-green-100'
                    };
                ?>
                <div class="log-item group relative p-6 hover:bg-gray-50/80 transition-all duration-300"
                    data-role="<?= strtolower($log['role']) ?>"
                    data-type="<?= $isRestored ? 'restore' : 'normal' ?>">
                    
                    <div class="relative flex flex-col md:flex-row md:items-start gap-6">
                        <div class="hidden md:flex flex-shrink-0 z-10">
                            <div class="w-10 h-10 rounded-full bg-white border-2 border-gray-100 flex items-center justify-center shadow-sm group-hover:border-[#1D2F83] transition-colors">
                                <?php if($isRestored): ?>
                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                <?php else: ?>
                                    <svg class="w-5 h-5 text-gray-400 group-hover:text-[#1D2F83]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="flex-grow space-y-3">
                            <div class="flex flex-wrap items-center gap-3">
                                <h3 class="text-sm font-bold text-gray-900"><?= esc($log['nama'] ?? 'SYSTEM') ?></h3>
                                <span class="text-[10px] px-2.5 py-0.5 rounded-lg border font-bold uppercase tracking-wider <?= $roleColor ?>">
                                    <?= esc($log['role']) ?>
                                </span>

                                <?php if ($isRestored): ?>
                                    <div class="group/tooltip relative inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-lg bg-purple-600 text-white text-[10px] font-bold shadow-sm cursor-help">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        RESTORED
                                        <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 hidden group-hover/tooltip:block w-48 p-2 bg-gray-900 text-white text-[10px] rounded-lg shadow-xl z-50">
                                            Dipulihkan dari: <?= esc($log['restored_from_backup'] ?? 'Unknown') ?><br>
                                            Pada: <?= date('d/m/y H:i', strtotime($log['restored_at'] ?? 'now')) ?>
                                            <div class="absolute top-full left-1/2 -translate-x-1/2 border-8 border-transparent border-t-gray-900"></div>
                                        </div>
                                    </div>
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
                            <p class="text-[11px] text-gray-400 font-medium"><?= date('H:i:s', strtotime($log['created_at'])) ?> WIB</p>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>

        <div id="empty-state" class="hidden py-20 text-center">
            <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-gray-100">
                <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
            </div>
            <h3 class="text-gray-900 font-bold">Tidak Ada Data</h3>
            <p class="text-sm text-gray-500">Log untuk kategori ini belum tersedia.</p>
        </div>
    </div>
</div>

<style>
    body { background-color: #f8fafc; }
    
    .filter-btn {
        padding: 8px 18px;
        border-radius: 14px;
        font-size: 12px;
        font-weight: 700;
        color: #64748b;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid transparent;
    }

    .filter-btn:hover {
        background-color: white;
        color: #1D2F83;
        box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.05);
    }

    .filter-btn.active {
        background-color: #1D2F83;
        color: white;
        box-shadow: 0 10px 15px -3px rgba(29, 47, 131, 0.25);
    }
</style>

<script>
function filterLogs(type, btn) {
    // UI Update Button
    document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
    if(btn.classList.contains('filter-btn')) btn.classList.add('active');

    let visibleCount = 0;
    const items = document.querySelectorAll('.log-item');
    
    items.forEach(item => {
        const role = item.dataset.role;
        const logType = item.dataset.type;

        let show = false;
        if (type === 'all') show = true;
        else if (type === 'restore' && logType === 'restore') show = true;
        else if (type === role) show = true;

        if(show) {
            item.style.display = 'block';
            visibleCount++;
        } else {
            item.style.display = 'none';
        }
    });

    // Handle Empty State
    const emptyState = document.getElementById('empty-state');
    if(visibleCount === 0) {
        emptyState.classList.remove('hidden');
    } else {
        emptyState.classList.add('hidden');
    }
}
</script>

<?= $this->endSection() ?>