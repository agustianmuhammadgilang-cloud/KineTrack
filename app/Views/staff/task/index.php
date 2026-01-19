<?= $this->extend('layout/staff_template') ?>
<?= $this->section('content') ?>

<style>
    :root {
        --polban-gold: #D4AF37;
        --soft-slate: #f8fafc;
    }

    /* Background bersih tanpa pattern */
    .bg-light {
        background-color: var(--soft-slate);
    }

    /* Card Sasaran yang lebih tipis dan bersih */
    .sasaran-container {
        background: white;
        border: 1px solid #eef2f6;
        border-radius: 12px;
        transition: transform 0.2s ease;
    }

    /* Aksen garis kecil saja, tidak menutup seluruh sisi kiri */
    .accent-line {
        width: 4px;
        height: 24px;
        background-color: var(--polban-blue);
        border-radius: 20px;
    }

    /* Item TW yang lebih soft */
    .tw-item {
        background: #ffffff;
        border: 1px solid #f1f5f9;
        border-radius: 10px;
        transition: all 0.2s;
    }

    .tw-item.active {
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }

    /* Progress bar tipis */
    .progress-track {
        height: 6px;
        background: #f1f5f9;
        border-radius: 10px;
        overflow: hidden;
    }

    /* Tombol lebih modern & tidak kapital semua */
    .btn-soft {
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        transition: all 0.2s;
        display: block;
        text-align: center;
    }

    .btn-blue { background: var(--polban-blue); color: white; }
    .btn-blue:hover { opacity: 0.9; }
    
    .btn-outline { border: 1px solid #e2e8f0; color: #64748b; }
    .btn-outline:hover { background: #f8fafc; }
</style>

<div class="min-h-screen bg-light px-6 py-8">
    <div class="max-w-7xl mx-auto">
        
        <div class="flex flex-col md:flex-row justify-between items-end border-b border-slate-200 pb-6 mb-8">
            <div>
                <h1 class="text-xl font-bold text-slate-800 tracking-tight">Pengukuran Kinerja</h1>
                <p class="text-sm text-slate-500 mt-1">Kelola capaian indikator kinerja Anda secara berkala.</p>
            </div>

            <div class="w-full md:w-64 mt-4 md:mt-0">
                <label class="text-[11px] font-semibold text-slate-400 uppercase mb-1.5 block">Filter Sasaran</label>
                <select id="sasaranFilter" onchange="filterSasaran(this.value)" 
                    class="w-full bg-white border border-slate-200 text-slate-600 text-sm rounded-lg p-2 outline-none focus:border-blue-400 transition-all">
                    <option value="all">Semua Sasaran</option>
                    <?php foreach (array_keys($tasksGrouped) as $sasaran): ?>
                        <option value="<?= esc($sasaran) ?>"><?= esc($sasaran) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <?php if (empty($tasksGrouped)): ?>
            <div class="bg-white rounded-2xl p-12 text-center border border-slate-100">
                <p class="text-slate-400 text-sm">Belum ada data penugasan.</p>
            </div>
        <?php else: ?>

        <?php foreach ($tasksGrouped as $sasaran => $indikatorList): ?>
        <div class="sasaran-block mb-12" data-sasaran="<?= esc($sasaran) ?>">
            
            <div class="flex items-center gap-3 mb-5">
                <div class="accent-line"></div>
                <h2 class="text-sm font-bold text-slate-700 uppercase tracking-wide">
                    <?= esc($sasaran) ?>
                </h2>
            </div>

            <div class="grid grid-cols-1 gap-5">
                <?php foreach ($indikatorList as $ind): ?>
                <div class="sasaran-container p-5">
                    <div class="mb-5">
                        <h3 class="text-base font-semibold text-slate-800">
                            <?= esc($ind['nama_indikator']) ?>
                        </h3>
                        <div class="flex items-center gap-2 mt-2">
                            <span class="text-[10px] font-medium px-2 py-0.5 rounded bg-slate-100 text-slate-500">Tahun <?= $ind['tahun'] ?></span>
                            <span class="text-[10px] font-medium px-2 py-0.5 rounded bg-blue-50 text-blue-600">ID: #<?= $ind['indikator_id'] ?></span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <?php foreach ([1,2,3,4] as $tw): 
                            $twInfo = $ind['tw_status'][$tw];
                            $isOpen = is_bool($twInfo) ? $twInfo : $twInfo['is_open'];
                            $measure = $ind['pengukuran'][$tw] ?? null;
                            $hasFilled = $measure !== null;
                            $targetTW = $ind['target_tw'][$tw] ?? 0;
                            $realisasi = $measure['realisasi'] ?? 0;
                            $percent = ($targetTW > 0) ? ($realisasi / $targetTW) * 100 : 0;
                        ?>
                        
                        <div class="tw-item p-4 flex flex-col justify-between <?= $isOpen ? 'active' : '' ?>">
                            <div class="flex justify-between items-center mb-4">
                                <span class="text-xs font-bold text-slate-400">Triwulan <?= $tw ?></span>
                                <?php if ($isOpen): ?>
                                    <span class="h-2 w-2 rounded-full bg-green-500"></span>
                                <?php else: ?>
                                    <span class="h-2 w-2 rounded-full bg-slate-200"></span>
                                <?php endif; ?>
                            </div>

                            <div class="mb-4">
                                <?php if ($hasFilled): ?>
                                    <div class="flex justify-between items-center mb-1">
                                        <span class="text-[10px] font-bold text-slate-600"><?= round($percent) ?>%</span>
                                    </div>
                                    <div class="progress-track">
                                        <div class="bg-blue-600 h-full rounded-full" style="width: <?= min($percent, 100) ?>%"></div>
                                    </div>
                                    <p class="text-[10px] text-slate-400 mt-2">
                                        Realisasi: <span class="text-slate-600 font-semibold"><?= $realisasi ?></span>
                                    </p>
                                <?php else: ?>
                                    <div class="py-2">
                                        <span class="text-[10px] text-slate-300 italic">Belum ada data</span>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div>
                                <?php if (!$hasFilled): ?>
                                    <?php if ($isOpen): ?>
                                        <a href="<?= base_url('staff/task/input/'.$ind['indikator_id'].'/'.$tw) ?>" class="btn-soft btn-blue">Isi Data</a>
                                    <?php else: ?>
                                        <span class="btn-soft bg-slate-50 text-slate-300 cursor-not-allowed">Terkunci</span>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <?php if ($percent >= 100): ?>
                                        <a href="<?= base_url('staff/task/report/'.$ind['indikator_id'].'/'.$tw) ?>" target="_blank" class="btn-soft btn-outline">Laporan</a>
                                    <?php else: ?>
                                        <a href="<?= base_url('staff/task/progress/'.$ind['indikator_id'].'/'.$tw) ?>" class="btn-soft bg-amber-50 text-amber-600">Progres</a>
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