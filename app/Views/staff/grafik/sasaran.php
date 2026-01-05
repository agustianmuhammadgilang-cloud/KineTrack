<?= $this->extend('layout/staff_template') ?>
<?= $this->section('content') ?>

<h3 class="text-2xl font-bold text-[var(--polban-blue)] mb-2">
    Grafik Sasaran Strategis
</h3>

<p class="text-sm text-gray-600 mb-6">
    Klik grafik atau tombol <b>Detail</b> untuk melihat indikator kinerja.
</p>

<div class="bg-white p-6 rounded-xl shadow border mb-8">
    <div style="height:380px">
        <canvas id="chartSasaran"></canvas>
    </div>
</div>

<!-- =======================
     LIST SASARAN
     ======================= -->
<div class="bg-white p-6 rounded-xl shadow border">

    <div class="flex items-center justify-between mb-4">
        <h4 class="text-lg font-semibold text-gray-700">
            Daftar Sasaran Strategis Anda
        </h4>

        <a href="<?= base_url('staff/grafik') ?>"
           class="text-sm px-4 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 transition">
            ← Kembali ke Grafik Tahun
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full border-collapse text-sm">
            <thead>
                <tr class="bg-gray-50 text-gray-600">
                    <th class="border px-4 py-2 text-left">Kode</th>
                    <th class="border px-4 py-2 text-left">Nama Sasaran</th>
                    <th class="border px-4 py-2 text-center">Progres</th>
                    <th class="border px-4 py-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($sasaran)) : ?>
                    <tr>
                        <td colspan="4" class="text-center py-6 text-gray-500">
                            Tidak ada sasaran pada tahun ini
                        </td>
                    </tr>
                <?php else : ?>
                    <?php foreach ($sasaran as $s) : ?>
                        <tr class="hover:bg-gray-50">
                            <td class="border px-4 py-2 font-medium">
                                <?= esc($s['kode_sasaran']) ?>
                            </td>
                            <td class="border px-4 py-2">
                                <?= esc($s['nama_sasaran']) ?>
                            </td>
                            <td class="border px-4 py-2 text-center">
                                <span class="font-semibold">
                                    <?= number_format($s['progres'], 2) ?>%
                                </span>
                            </td>
                            <td class="border px-4 py-2 text-center">
                                <a href="<?= base_url('staff/grafik/indikator/' . $s['id'] . '/' . $tahunId) ?>"    
                                   class="inline-block px-3 py-1.5 text-sm rounded-lg
                                          bg-blue-600 text-white hover:bg-blue-700 transition">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                <?php endif ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const dataSasaran = <?= json_encode($sasaran) ?>;

// =======================
// CHART
// =======================
new Chart(document.getElementById('chartSasaran'), {
    type: 'bar',
    data: {
        labels: dataSasaran.map(d => d.kode_sasaran),
        datasets: [{
            label: 'Progres (%)',
            data: dataSasaran.map(d => Number(d.progres).toFixed(2)),
            backgroundColor: 'rgba(37, 99, 235, 0.8)',
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
        onClick: (evt, elements) => {
    if (!elements.length) return;

    const idx = elements[0].index;
    const sasaranId = dataSasaran[idx].id;
    const tahunId   = <?= json_encode($tahunId) ?>;

    window.location.href =
        "<?= base_url('staff/grafik/indikator/') ?>" + sasaranId + "/" + tahunId;
}
    }
});
</script>

<?= $this->endSection() ?>
