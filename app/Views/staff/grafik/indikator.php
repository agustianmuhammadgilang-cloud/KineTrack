<?= $this->extend('layout/staff_template') ?>
<?= $this->section('content') ?>

<h3 class="text-2xl font-bold text-[var(--polban-blue)] mb-2">
    Grafik Indikator Kinerja Anda
</h3>

<p class="text-sm text-gray-600 mb-6">
    Klik grafik atau tombol <b>Detail</b> untuk melihat capaian per triwulan.
</p>

<!-- =======================
     GRAFIK
     ======================= -->
<div class="bg-white p-6 rounded-xl shadow border mb-8">
    <div style="height:380px">
        <canvas id="chartIndikator"></canvas>
    </div>
</div>

<!-- =======================
     LIST INDIKATOR
     ======================= -->
<div class="bg-white p-6 rounded-xl shadow border">

    <div class="flex items-center justify-between mb-4">
        <h4 class="text-lg font-semibold text-gray-700">
            Daftar Indikator Kinerja
        </h4>

        <a href="<?= base_url('staff/grafik/sasaran/' . $tahunId) ?>"
   class="text-sm px-4 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 transition">
    ← Kembali ke Grafik Sasaran
</a>

    </div>

    <div class="overflow-x-auto">
        <table class="w-full border-collapse text-sm">
            <thead>
                <tr class="bg-gray-50 text-gray-600">
                    <th class="border px-4 py-2 text-left">Kode</th>
                    <th class="border px-4 py-2 text-left">Nama Indikator</th>
                    <th class="border px-4 py-2 text-center">Target PK</th>
                    <th class="border px-4 py-2 text-center">Realisasi</th>
                    <th class="border px-4 py-2 text-center">Progres</th>
                    <th class="border px-4 py-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($indikator)) : ?>
                    <tr>
                        <td colspan="6" class="text-center py-6 text-gray-500">
                            Tidak ada indikator pada sasaran ini
                        </td>
                    </tr>
                <?php else : ?>
                    <?php foreach ($indikator as $i) : ?>
                        <tr class="hover:bg-gray-50">
                            <td class="border px-4 py-2 font-medium">
                                <?= esc($i['kode_indikator']) ?>
                            </td>
                            <td class="border px-4 py-2">
                                <?= esc($i['nama_indikator']) ?>
                            </td>
                            <td class="border px-4 py-2 text-center">
                                <?= number_format($i['target_pk'], 2) ?>
                            </td>
                            <td class="border px-4 py-2 text-center">
                                <?= number_format($i['realisasi'], 2) ?>
                            </td>
                            <td class="border px-4 py-2 text-center">
                                <span class="font-semibold">
                                    <?= number_format($i['progres'], 2) ?>%
                                </span>
                            </td>
                            <td class="border px-4 py-2 text-center">
                                <a href="<?= base_url('staff/grafik/triwulan/' . $i['id']) ?>"
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
const indikator = <?= json_encode($indikator) ?>;

// =======================
// CHART
// =======================
new Chart(document.getElementById('chartIndikator'), {
    data: {
        labels: indikator.map(i => i.kode_indikator),
        datasets: [
            {
                type: 'bar',
                label: 'Target PK',
                data: indikator.map(i => i.target_pk),
                backgroundColor: 'rgba(37, 99, 235, 0.8)',
                borderRadius: 6,
                maxBarThickness: 60
            },
            {
                type: 'line',
                label: 'Realisasi',
                data: indikator.map(i => i.realisasi),
                borderColor: 'rgba(16, 185, 129, 1)',
                backgroundColor: 'rgba(16, 185, 129, 0.2)',
                tension: 0.3,
                fill: false,
                pointRadius: 4
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            tooltip: {
                callbacks: {
                    label(ctx) {
                        return `${ctx.dataset.label}: ${ctx.parsed.y}`;
                    }
                }
            }
        },
        scales: {
            y: { beginAtZero: true }
        },
        onClick: (evt, elements) => {
            if (!elements.length) return;
            const idx = elements[0].index;
            const indikatorId = indikator[idx].id;

            window.location.href =
                "<?= base_url('staff/grafik/triwulan/') ?>" + indikatorId;
        }
    }
});
</script>

<?= $this->endSection() ?>
