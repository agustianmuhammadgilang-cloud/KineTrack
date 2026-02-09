<?= $this->extend('layout/atasan_template') ?>
<?= $this->section('content') ?>

<style>
    :root {
        --polban-gold: #D4AF37;
        --soft-slate: #f8fafc;
    }

    .bg-light { background-color: var(--soft-slate); }

    .sasaran-container {
        background: white;
        border: 1px solid #eef2f6;
        border-radius: 12px;
    }

    .accent-line {
        width: 4px; height: 20px;
        background-color: var(--polban-blue);
        border-radius: 20px;
    }

    .tw-item {
        background: #ffffff;
        border: 1px solid #f1f5f9;
        border-radius: 10px;
        transition: all 0.2s;
    }

    .tw-item.active { border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); }

    .progress-track {
        height: 6px; background: #f1f5f9;
        border-radius: 10px; overflow: hidden;
    }

    .btn-soft {
        padding: 0.5rem 1rem; border-radius: 8px;
        font-size: 11px; font-weight: 600;
        transition: all 0.2s; display: block; text-align: center;
    }

    /* Badge untuk sumber status */
    .badge-status {
        font-size: 9px; padding: 2px 8px;
        border-radius: 20px; font-weight: 700;
        text-transform: uppercase;
    }
</style>

<div class="min-h-screen bg-light px-6 py-8">
    <div class="max-w-7xl mx-auto">
        
        <div class="flex flex-col md:flex-row justify-between items-start border-b border-slate-200 pb-6 mb-8 gap-6">
    <div class="flex-1">
        <h1 class="text-xl font-bold text-slate-800 tracking-tight">Pengukuran Kinerja</h1>
        <p class="text-sm text-slate-500 mt-1">Status pembukaan indikator dikelola secara sistem dan manual oleh admin.</p>
    </div>

    <div class="w-full md:w-80 space-y-4">
        
        <?php if ($hasRekomendasi): ?>
        <a href="<?= base_url('atasan/rekomendasi') ?>" class="group block relative overflow-hidden bg-white border border-amber-100 rounded-xl p-3 transition-all hover:shadow-md hover:border-amber-300">
            <div class="flex items-center gap-3">
                <div class="shrink-0 w-10 h-10 bg-amber-50 rounded-lg flex items-center justify-center text-amber-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </div>
                <div class="min-w-0">
                    <div class="flex items-center gap-2">
                        <h4 class="text-[11px] font-bold text-blue-900 leading-tight truncate">Evaluasi & Rekomendasi</h4>
                        <span class="px-1.5 py-0.5 bg-amber-100 text-amber-700 text-[8px] font-black rounded uppercase">Penting</span>
                    </div>
                    <p class="text-[10px] text-slate-500 truncate mt-0.5">Klik untuk lihat arahan pimpinan.</p>
                </div>
            </div>
        </a>
        <?php endif; ?>

        <div>
            <label class="text-[11px] font-semibold text-slate-400 uppercase mb-1.5 block">Filter Sasaran</label>
            <select id="sasaranFilter" onchange="filterSasaran(this.value)" 
                class="w-full bg-white border border-slate-200 text-slate-600 text-sm rounded-lg p-2 outline-none focus:border-blue-400 shadow-sm">
                <option value="all">Semua Sasaran</option>
                <?php foreach (array_keys($tasksGrouped) as $sasaran): ?>
                    <option value="<?= esc($sasaran) ?>"><?= esc($sasaran) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
</div>

        <?php if (empty($tasksGrouped)): ?>
            <div class="bg-white rounded-2xl p-12 text-center border border-slate-100">
                <p class="text-slate-400 text-sm">Belum ada data penugasan.</p>
            </div>
        <?php else: ?>

        <?php foreach ($tasksGrouped as $sasaran => $indikatorList): ?>
        <div class="sasaran-block mb-10" data-sasaran="<?= esc($sasaran) ?>">
            
            <div class="flex items-center gap-3 mb-4">
                <div class="accent-line"></div>
                <h2 class="text-sm font-bold text-slate-700 uppercase tracking-wide"><?= esc($sasaran) ?></h2>
            </div>

            <div class="grid grid-cols-1 gap-5">
                <?php foreach ($indikatorList as $ind): ?>
                <div class="sasaran-container p-5">
                    <div class="mb-5">
                        <h3 class="text-base font-semibold text-slate-800"><?= esc($ind['nama_indikator']) ?></h3>
                        <div class="flex items-center gap-2 mt-2">
                            <span class="text-[10px] font-medium px-2 py-0.5 rounded bg-slate-100 text-slate-500">Tahun <?= $ind['tahun'] ?></span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <?php foreach ([1,2,3,4] as $tw): 
                            $twInfo = $ind['tw_status'][$tw];
                            
                            // Logika penentuan Source & Status
                            if (is_bool($twInfo)) {
                                $isOpen = $twInfo;
                                $source = $twInfo ? 'admin' : 'closed';
                            } else {
                                $isOpen = $twInfo['is_open'];
                                $source = $twInfo['source'];
                            }

                            $measure = $ind['pengukuran'][$tw] ?? null;
                            $hasFilled = $measure !== null;
                            $targetTW = $ind['target_tw'][$tw] ?? 0;
                            $realisasi = $measure['realisasi'] ?? 0;
                            $percent = ($targetTW > 0) ? ($realisasi / $targetTW) * 100 : 0;
                        ?>
                        
                        <div class="tw-item p-4 flex flex-col justify-between <?= $isOpen ? 'active' : '' ?>">
                            <div class="flex flex-col gap-2 mb-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-xs font-bold text-slate-400">TW <?= $tw ?></span>
                                    <div class="h-1.5 w-1.5 rounded-full <?= $isOpen ? 'bg-green-500' : 'bg-slate-200' ?>"></div>
                                </div>
                                
                                <div>
                                    <?php if (!$isOpen): ?>
                                        <span class="badge-status bg-slate-100 text-slate-500 border border-slate-200">Terkunci</span>
                                    <?php elseif ($source === 'auto'): ?>
                                        <span class="badge-status bg-blue-50 text-blue-600 border border-blue-100">Aktif Otomatis</span>
                                    <?php else: ?>
                                        <span class="badge-status bg-green-50 text-green-600 border border-green-100">Dibuka Admin</span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="mb-4">
                                <?php if ($hasFilled): ?>
                                    <div class="flex justify-between items-center mb-1">
                                        <span class="text-[10px] font-bold text-slate-600"><?= round($percent) ?>%</span>
                                        <span class="text-[10px] text-slate-400"><?= $realisasi ?>/<?= $targetTW ?></span>
                                    </div>
                                    <div class="progress-track">
                                        <div class="bg-blue-600 h-full rounded-full" style="width: <?= min($percent, 100) ?>%"></div>
                                    </div>
                                <?php else: ?>
                                    <div class="py-2"><span class="text-[10px] text-slate-300 italic">Belum ada data</span></div>
                                <?php endif; ?>
                            </div>

                            <div>
                                <?php if (!$hasFilled): ?>
                                    <?php if ($isOpen): ?>
                                        <a href="<?= base_url('atasan/task/input/'.$ind['indikator_id'].'/'.$tw) ?>" class="btn-soft bg-blue-900 text-white hover:bg-slate-800">Isi Data</a>
                                    <?php else: ?>
                                        <span class="btn-soft bg-slate-50 text-slate-300 cursor-not-allowed border border-slate-100">Akses Tutup</span>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <?php if ($percent >= 100): ?>
                                        <a href="<?= base_url('atasan/task/report/'.$ind['indikator_id'].'/'.$tw) ?>" target="_blank" class="btn-soft border border-slate-200 text-slate-600 hover:bg-slate-50">Laporan</a>
                                    <?php else: ?>
                                        <a href="<?= base_url('atasan/task/progress/'.$ind['indikator_id'].'/'.$tw) ?>" class="btn-soft bg-amber-50 text-amber-600 border border-amber-100 hover:bg-amber-100">Progres</a>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<script>
function filterSasaran(selected) {
    const blocks = document.querySelectorAll('.sasaran-block');
    blocks.forEach(block => {
        const sasaran = block.dataset.sasaran;
        block.style.display = (selected === 'all' || sasaran === selected) ? 'block' : 'none';
    });
}
</script>

<?= $this->endSection() ?>