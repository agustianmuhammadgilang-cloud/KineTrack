<?= $this->extend('layout/atasan_template') ?>
<?= $this->section('content') ?>

<div class="min-h-screen bg-[#f8fafc] py-6 px-4 sm:px-6 lg:px-8">
    
    <div class="max-w-7xl mx-auto mb-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h3 class="text-2xl font-black text-slate-900 tracking-tight">
                    Statistik <span class="text-blue-600">Kinerja</span>
                </h3>
                <p class="text-slate-500 text-sm italic">
                    Perbandingan Target PK & Realisasi
                </p>
            </div>

            <div class="flex items-center gap-3 bg-white p-2 rounded-xl shadow-sm border border-slate-200">
                <label for="tahunSelect" class="pl-2 text-[9px] font-black text-slate-400 uppercase tracking-widest">Tahun</label>
                <select id="tahunSelect"
                        class="form-select border-none bg-slate-50 rounded-lg text-xs font-bold text-slate-700 focus:ring-0 cursor-pointer py-1">
                    <?php foreach ($listTahun as $t): ?>
                        <option value="<?= $t['id'] ?>" <?= $t['id'] == $tahunAktif['id'] ? 'selected' : '' ?>>
                            <?= $t['tahun'] ?> <?= $t['status'] === 'active' ? ' (Aktif)' : '' ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto">
        <div class="bg-white rounded-2xl shadow-xl shadow-blue-900/5 border border-white overflow-hidden">
            
            <div class="px-6 py-4 border-b border-slate-50 flex flex-wrap items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center text-white">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <span class="text-sm font-bold text-slate-700">Visualisasi Capaian</span>
                </div>

                <div class="flex items-center gap-4 bg-slate-50 px-4 py-2 rounded-xl border border-slate-100">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-sm bg-blue-600"></span>
                        <span class="text-[10px] font-bold text-slate-500 uppercase">Target</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full border-2 border-emerald-500 bg-white"></span>
                        <span class="text-[10px] font-bold text-slate-500 uppercase">Realisasi</span>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <div class="relative w-full" style="height:320px;">
                    <canvas id="chartIndikator"></canvas>
                </div>
            </div>

            <div class="px-6 py-3 bg-slate-50/50 border-t border-slate-100">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">
                    Klik grafik untuk detail triwulan
                </p>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// Logika tetap dipertahankan
let indikator = <?= json_encode($indikator) ?>;
let chart;

const getLabels = (data) => data.map(i => `${i.kode_indikator}\n${i.kode_sasaran}`);
const getTargetData = (data) => data.map(i => Number(i.target_pk));
const getRealisasiData = (data) => data.map(i => Number(i.realisasi));

const tooltipCallbacks = {
    title(ctx) {
        const i = indikator[ctx[0].dataIndex];
        return `ID: ${i.kode_indikator}`;
    },
    beforeBody(ctx) {
        const i = indikator[ctx[0].dataIndex];
        return i.nama_indikator;
    },
    label(ctx) {
        return ` ${ctx.dataset.label}: ${ctx.parsed.y}`;
    },
    footer(ctx) {
        const i = indikator[ctx[0].dataIndex];
        return `\nProgres: ${Number(i.progres).toFixed(2)}%`;
    }
};

const ctx = document.getElementById('chartIndikator').getContext('2d');

const blueGradient = ctx.createLinearGradient(0, 0, 0, 300);
blueGradient.addColorStop(0, 'rgba(37, 99, 235, 1)');
blueGradient.addColorStop(1, 'rgba(37, 99, 235, 0.6)');

chart = new Chart(ctx, {
    data: {
        labels: getLabels(indikator),
        datasets: [
            {
                type: 'bar',
                label: 'Target PK',
                data: getTargetData(indikator),
                backgroundColor: blueGradient,
                borderRadius: 8,
                maxBarThickness: 35,
                order: 2
            },
            {
                type: 'line',
                label: 'Realisasi',
                data: getRealisasiData(indikator),
                borderColor: '#10b981',
                borderWidth: 3,
                pointBackgroundColor: '#ffffff',
                pointBorderColor: '#10b981',
                pointRadius: 4,
                tension: 0.4,
                order: 1
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false },
            tooltip: {
                backgroundColor: '#0f172a',
                padding: 12,
                cornerRadius: 12,
                callbacks: tooltipCallbacks
            }
        },
        scales: {
            x: {
                grid: { display: false },
                ticks: {
                    font: { size: 10, weight: '700' },
                    color: '#94a3b8',
                    callback(value) { return this.getLabelForValue(value).split('\n'); }
                }
            },
            y: {
                beginAtZero: true,
                grid: { color: '#f1f5f9' },
                ticks: { color: '#94a3b8', font: { size: 10 } }
            }
        },
        onClick(evt, elements) {
            if (!elements.length) return;
            const idx = elements[0].index;
            window.location.href = `<?= base_url('atasan/grafik/triwulan/') ?>${indikator[idx].indikator_id}`;
        }
    }
});

document.getElementById('tahunSelect').addEventListener('change', function () {
    fetch(`<?= base_url('atasan/grafik/data-indikator') ?>/${this.value}`)
        .then(res => res.json())
        .then(data => {
            indikator = data;
            chart.data.labels = getLabels(data);
            chart.data.datasets[0].data = getTargetData(data);
            chart.data.datasets[1].data = getRealisasiData(data);
            chart.update('active');
        })
        .catch(err => console.error("Gagal memuat data:", err));
});
</script>

<?= $this->endSection() ?>