<?= $this->extend('layout/atasan_template') ?>
<?= $this->section('content') ?>

<style>
    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
    }
</style>

<div class="min-h-screen bg-slate-50 px-6 py-8 font-sans text-slate-800">

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
        <div>
            <h1 class="text-3xl font-bold text-slate-900 tracking-tight">
                Tugas Pengukuran Kinerja
            </h1>
            <p class="text-slate-500 mt-1 text-sm">
                Kelola dan pantau realisasi capaian indikator kinerja Anda sebagai atasan.
            </p>
            
            <div class="mt-3 inline-flex items-center px-3 py-1 rounded-full bg-blue-50 border border-blue-200 shadow-sm">
                <span class="w-2 h-2 rounded-full bg-blue-600 mr-2 animate-pulse"></span>
                <span class="text-xs font-semibold text-blue-800 uppercase tracking-wide">
                    Tahun Aktif: <?= date('Y') ?>
                </span>
            </div>
        </div>
    </div>

    <?php if (empty($tasksGrouped)): ?>
        <div class="bg-white border border-dashed border-slate-300 rounded-2xl p-12 text-center">
            <div class="mx-auto w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center mb-4 text-slate-400">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2" />
                </svg>
            </div>
            <p class="text-slate-600 font-bold">Tidak ada indikator ditugaskan</p>
            <p class="text-sm text-slate-400 mt-1">Belum ada tugas pengukuran yang diarahkan ke akun Anda.</p>
        </div>
    <?php else: ?>

        <?php foreach ($tasksGrouped as $sasaran => $indikatorList): ?>
        <div class="mb-10">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-1.5 h-7 bg-amber-500 rounded-full"></div>
                <h2 class="text-xl font-extrabold text-slate-800 tracking-tight leading-none"><?= esc($sasaran) ?></h2>
            </div>

            <div class="grid grid-cols-1 gap-6">
                <?php foreach ($indikatorList as $ind): ?>
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden card-hover transition-all duration-300">
                    
                    <div class="p-6 border-b border-slate-50 bg-gradient-to-r from-white to-slate-50/50">
                        <div class="flex justify-between items-start gap-4">
                            <div>
                                <h3 class="text-lg font-bold text-slate-800 leading-snug mb-1">
                                    <?= esc($ind['nama_indikator']) ?>
                                </h3>
                                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">ID INDIKATOR: #<?= $ind['indikator_id'] ?></p>
                            </div>
                            <span class="px-3 py-1 rounded-lg bg-slate-100 text-slate-600 text-xs font-bold">TA <?= $ind['tahun'] ?></span>
                        </div>
                    </div>

                    <div class="p-6 bg-white">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                            <?php foreach ([1,2,3,4] as $tw): ?>
                                <?php
                                    $twInfo = $ind['tw_status'][$tw];
                                    $isOpen = is_bool($twInfo) ? $twInfo : $twInfo['is_open'];
                                    $source = is_bool($twInfo) ? ($twInfo ? 'admin' : 'closed') : $twInfo['source'];

                                    // Badge logic
                                    if (!$isOpen) {
                                        $badgeStyle = "bg-rose-50 text-rose-600 border-rose-100";
                                        $statusText = "Dikunci";
                                    } elseif ($source === 'auto') {
                                        $badgeStyle = "bg-blue-50 text-blue-600 border-blue-100";
                                        $statusText = "Aktif Otomatis";
                                    } else {
                                        $badgeStyle = "bg-emerald-50 text-emerald-600 border-emerald-100";
                                        $statusText = "Dibuka Admin";
                                    }

                                    $measure = $ind['pengukuran'][$tw] ?? null;
                                    $hasFilled = $measure !== null;
                                    $targetTW = $ind['target_tw'][$tw] ?? 0;
                                    $realisasi = $measure['realisasi'] ?? 0;
                                    $percent = ($targetTW > 0) ? ($realisasi / $targetTW) * 100 : 0;
                                ?>

                                <div class="relative group/tw p-4 rounded-2xl border border-slate-100 bg-slate-50/50 hover:bg-white hover:border-blue-200 hover:shadow-md transition-all duration-300">
                                    <div class="flex items-center justify-between mb-3">
                                        <span class="text-sm font-black text-slate-700 uppercase">TW <?= $tw ?></span>
                                        <span class="px-2 py-0.5 text-[10px] font-bold rounded-md border <?= $badgeStyle ?>">
                                            <?= $statusText ?>
                                        </span>
                                    </div>

                                    <?php if (!$hasFilled): ?>
                                        <?php if ($isOpen): ?>
                                            <a href="<?= base_url('atasan/task/input/'.$ind['indikator_id'].'/'.$tw) ?>"
                                               class="flex items-center justify-center gap-2 w-full mt-4 bg-blue-600 hover:bg-blue-700 text-white py-2.5 rounded-xl font-bold text-xs transition-all shadow-sm hover:shadow-blue-200">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4" stroke-width="2" stroke-linecap="round"/></svg>
                                                Isi Pengukuran
                                            </a>
                                        <?php else: ?>
                                            <div class="mt-4 py-2.5 text-center rounded-xl bg-slate-100 text-slate-400 text-xs font-medium italic">
                                                Akses Ditutup
                                            </div>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <div class="space-y-1 mt-2">
                                            <div class="flex justify-between text-[11px] font-bold text-slate-400 uppercase">
                                                <span>Progress</span>
                                                <span class="<?= ($percent >= 100 ? 'text-emerald-600' : 'text-blue-600') ?>"><?= round($percent) ?>%</span>
                                            </div>
                                            <div class="w-full bg-slate-200 rounded-full h-1.5 overflow-hidden">
                                                <div class="h-full rounded-full transition-all duration-500 <?= ($percent >= 100 ? 'bg-emerald-500' : 'bg-blue-500') ?>" style="width: <?= min($percent, 100) ?>%"></div>
                                            </div>
                                            <div class="flex justify-between items-baseline mt-3">
                                                <span class="text-lg font-black text-slate-800"><?= $realisasi ?></span>
                                                <span class="text-[10px] font-bold text-slate-400">Target: <?= $targetTW ?></span>
                                            </div>
                                        </div>

                                        <?php if ($percent >= 100): ?>
                                            <a href="<?= base_url('atasan/task/report/'.$ind['indikator_id'].'/'.$tw) ?>"
                                               target="_blank"
                                               class="flex items-center justify-center w-full mt-4 bg-emerald-50 text-emerald-600 hover:bg-emerald-600 hover:text-white py-2 rounded-xl font-bold text-xs transition-all border border-emerald-100">
                                                Lihat Report
                                            </a>
                                        <?php else: ?>
                                            <a href="<?= base_url('atasan/task/progress/'.$ind['indikator_id'].'/'.$tw) ?>"
                                               class="flex items-center justify-center w-full mt-4 bg-amber-50 text-amber-600 hover:bg-amber-600 hover:text-white py-2 rounded-xl font-bold text-xs transition-all border border-amber-100">
                                                Lihat Progress
                                            </a>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endforeach; ?>

    <?php endif; ?>

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