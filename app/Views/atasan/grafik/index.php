<?= $this->extend('layout/atasan_template') ?>
<?= $this->section('content') ?>

<h3 class="text-2xl font-bold text-[var(--polban-blue)] mb-2">
    Grafik Kinerja Anda
</h3>

<p class="text-sm text-gray-600 mb-6">
    Tahun <span class="font-semibold">aktif</span> ditampilkan di posisi paling kanan.
    Geser grafik ke kiri untuk melihat tahun sebelumnya.
</p>

<div class="bg-white p-6 rounded-xl shadow border">

    <!-- SCROLL WRAPPER -->
    <div class="overflow-x-auto pb-3">
        <div style="min-width:900px; height:420px;">
            <canvas id="grafikTahun"></canvas>
        </div>
    </div>

    <div class="mt-4 flex items-center gap-4 text-sm">
        <div class="flex items-center gap-2">
            <span class="inline-block w-3 h-3 rounded bg-blue-600"></span>
            Tahun Aktif
        </div>
        <div class="flex items-center gap-2">
            <span class="inline-block w-3 h-3 rounded bg-blue-300"></span>
            Tahun Sebelumnya
        </div>
    </div>

    

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const rawData = <?= json_encode($grafikTahun) ?>;

// =======================
// SORT DATA
// =======================
// Pastikan urutan: tahun lama ➜ tahun aktif (paling kanan)
rawData.sort((a, b) => a.tahun - b.tahun);

// =======================
// PREPARE DATA
// =======================
const labels     = rawData.map(i => i.tahun);
const progres    = rawData.map(i => Number(i.progres).toFixed(2));
const tahunIds   = rawData.map(i => i.tahun_id);
const statuses   = rawData.map(i => i.status ?? 'inactive');

// =======================
// COLOR LOGIC
// =======================
const barColors = statuses.map(status =>
    status === 'active'
        ? 'rgba(37, 99, 235, 0.9)'   // aktif (biru tua)
        : 'rgba(147, 197, 253, 0.8)' // non-aktif
);

// =======================
// CHART
// =======================
const ctx = document.getElementById('grafikTahun').getContext('2d');

const chart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels,
        datasets: [{
            label: 'Progres (%)',
            data: progres,
            backgroundColor: barColors,
            borderRadius: 6,
            maxBarThickness: 60
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            tooltip: {
                callbacks: {
                    label(ctx) {
                        return `Progres: ${ctx.parsed.y}%`;
                    },
                    afterLabel(ctx) {
                        return statuses[ctx.dataIndex] === 'active'
                            ? 'Status: Tahun Aktif'
                            : 'Status: Tahun Sebelumnya';
                    }
                }
            },
            legend: { display: false }
        },
        scales: {
            y: {
                beginAtZero: true,
                max: 100,
                ticks: {
                    callback: value => value + '%'
                }
            }
        },
        onClick(evt, elements) {
            if (!elements.length) return;
            const index   = elements[0].index;
            const tahunId = tahunIds[index];

            window.location.href =
                "<?= base_url('atasan/grafik/sasaran/') ?>" + tahunId;
        }
    }
});

// =======================
// AUTO SCROLL KE TAHUN AKTIF
// =======================
setTimeout(() => {
    const container = document.querySelector('.overflow-x-auto');
    container.scrollLeft = container.scrollWidth;
}, 300);
</script>

<?= $this->endSection() ?>
