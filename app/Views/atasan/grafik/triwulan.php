<?= $this->extend('layout/atasan_template') ?>
<?= $this->section('content') ?>

<div class="min-h-screen bg-[#f8fafc] py-6 px-4 sm:px-6 lg:px-8">
    
    <div class="max-w-7xl mx-auto mb-6">
        <div class="bg-white rounded-2xl border border-white shadow-xl shadow-blue-900/5 p-6">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="flex items-start gap-4">
                    <div class="p-3 bg-blue-50 rounded-xl text-blue-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-slate-800 tracking-tight">
                            Analisis Capaian Triwulan
                        </h3>
                        <p class="text-sm text-slate-500 mt-1">
                            Indikator: <span class="font-semibold text-slate-700"><?= esc($indikator['nama_indikator']) ?></span>
                        </p>
                        <div class="mt-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            Mode: <?= ucfirst($mode) ?> 
                            <?= $mode === 'akumulatif' ? '(Akumulasi TW)' : '(Data Mandiri TW)' ?>
                        </div>
                    </div>
                </div>

                <a href="<?= base_url('atasan/grafik') ?>?tahun=<?= $indikator['tahun_id'] ?>"
                   class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-white border border-slate-200 text-sm font-bold text-slate-600 hover:bg-slate-50 hover:text-blue-600 transition-all shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl shadow-xl shadow-blue-900/5 border border-white p-6">
                <div class="flex items-center justify-between mb-6">
                    <h4 class="text-sm font-bold text-slate-700 uppercase tracking-wider">Perbandingan Tren</h4>
                    <div class="flex items-center gap-3">
                         <span class="flex items-center gap-1.5 text-[10px] font-bold text-slate-400">
                            <span class="w-2.5 h-2.5 rounded-sm bg-blue-600/20 border border-blue-600"></span> TARGET
                         </span>
                    </div>
                </div>

                <div class="relative h-[300px]">
                    <canvas id="chartTW"></canvas>
                </div>
            </div>
        </div>

        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-xl shadow-blue-900/5 border border-white overflow-hidden">
                <div class="px-6 py-4 bg-slate-50/50 border-b border-slate-100">
                    <h4 class="text-sm font-bold text-slate-700 uppercase tracking-wider">Detail Data</h4>
                </div>
                
                <div class="divide-y divide-slate-100">
                    <?php for ($tw = 1; $tw <= 4; $tw++): 
                        $targetTw = $target[$tw] ?? 0;
                        $totalRealisasi = 0;
                        foreach ($realisasi as $pic) { $totalRealisasi += ($pic['data'][$tw] ?? 0); }
                        $progres = $targetTw > 0 ? min(($totalRealisasi / $targetTw) * 100, 100) : 0;
                        
                        // Warna progres
                        $colorClass = $progres >= 100 ? 'text-emerald-600' : ($progres > 0 ? 'text-blue-600' : 'text-slate-400');
                    ?>
                    <div class="p-4 hover:bg-slate-50 transition">
                        <div class="flex justify-between items-center mb-3">
                            <span class="font-bold text-slate-800">Triwulan <?= $tw ?></span>
                            <span class="text-xs font-black <?= $colorClass ?>"><?= number_format($progres, 1) ?>%</span>
                        </div>
                        
                        <div class="flex justify-between text-xs mb-2">
                            <span class="text-slate-400">Target: <span class="text-slate-700 font-bold"><?= $targetTw ?></span></span>
                            <span class="text-slate-400">Total Realisasi: <span class="text-slate-700 font-bold"><?= $totalRealisasi ?></span></span>
                        </div>

                        <div class="w-full bg-slate-100 rounded-full h-1.5 mb-3">
                            <div class="h-1.5 rounded-full <?= $progres >= 100 ? 'bg-emerald-500' : 'bg-blue-500' ?>" style="width: <?= $progres ?>%"></div>
                        </div>

                        <div class="space-y-1">
                            <?php foreach ($realisasi as $pic): 
                                $nilai = $pic['data'][$tw] ?? 0;
                                if ($nilai > 0): ?>
                                <div class="flex justify-between text-[11px]">
                                    <span class="text-slate-500"><?= esc($pic['nama']) ?></span>
                                    <span class="font-semibold text-slate-700"><?= $nilai ?></span>
                                </div>
                            <?php endif; endforeach; ?>
                        </div>
                    </div>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const target = <?= json_encode(array_values($target)) ?>;
const realisasi = <?= json_encode($realisasi) ?>;

// Skema warna yang lebih soft
const colors = ['#2563eb', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6'];
let colorIndex = 0;

const datasets = [
    {
        type: 'bar',
        label: 'Target TW',
        data: target,
        backgroundColor: 'rgba(37, 99, 235, 0.08)',
        borderColor: 'rgba(37, 99, 235, 0.3)',
        borderWidth: 1,
        borderRadius: 8,
        borderDash: [5, 5],
        order: 2
    }
];

Object.values(realisasi).forEach(pic => {
    datasets.push({
        type: 'line',
        label: pic.nama,
        data: [1,2,3,4].map(tw => pic.data[tw] ?? 0),
        borderColor: colors[colorIndex % colors.length],
        backgroundColor: colors[colorIndex % colors.length],
        tension: 0.4,
        borderWidth: 3,
        pointRadius: 4,
        pointHoverRadius: 7,
        pointBackgroundColor: '#fff',
        pointBorderWidth: 2,
        order: 1
    });
    colorIndex++;
});

new Chart(document.getElementById('chartTW'), {
    data: {
        labels: ['TW 1','TW 2','TW 3','TW 4'],
        datasets
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        interaction: { mode: 'index', intersect: false },
        plugins: {
            legend: { 
                position: 'bottom',
                labels: {
                    usePointStyle: true,
                    padding: 20,
                    font: { size: 11, weight: '600' }
                }
            },
            tooltip: {
                backgroundColor: '#0f172a',
                padding: 12,
                cornerRadius: 12,
                titleFont: { size: 13 }
            }
        },
        scales: {
            x: {
                grid: { display: false },
                ticks: { font: { weight: 'bold' }, color: '#94a3b8' }
            },
            y: { 
                beginAtZero: true,
                border: { display: false },
                grid: { color: '#f1f5f9' },
                ticks: { color: '#94a3b8' }
            }
        }
    }
});
</script>

<?= $this->endSection() ?>