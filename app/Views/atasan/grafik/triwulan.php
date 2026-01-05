<?= $this->extend('layout/atasan_template') ?>
<?= $this->section('content') ?>

<h3 class="text-2xl font-bold text-[var(--polban-blue)] mb-2">
    Grafik Triwulan Anda
</h3>

<p class="text-sm text-gray-600 mb-6">
    Indikator: <b><?= esc($indikator['nama_indikator']) ?></b>
</p>

<!-- =======================
     GRAFIK
     ======================= -->
<div class="bg-white p-6 rounded-xl shadow border mb-8">
    <div style="height:380px">
        <canvas id="chartTW"></canvas>
    </div>
</div>

<!-- =======================
     TABEL INFORMASI TRIWULAN
     ======================= -->
<div class="bg-white p-6 rounded-xl shadow border mt-8">

    <div class="flex items-center justify-between mb-4">
        <h4 class="text-lg font-semibold text-gray-700">
            Detail Target & Realisasi Triwulan
        </h4>

        <a href="<?= base_url('atasan/grafik/indikator/' . $sasaranId . '/' . $indikator['tahun_id']) ?>"
           class="text-sm px-4 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 transition">
            ← Kembali ke Indikator
        </a>
    </div>

    <table class="w-full border-collapse text-sm">
        <thead>
            <tr class="bg-gray-50">
                <th class="border px-4 py-2">Triwulan</th>
                <th class="border px-4 py-2">Target</th>
                <th class="border px-4 py-2">Realisasi</th>
                <th class="border px-4 py-2">Progres</th>
            </tr>
        </thead>
        <tbody>
<?php for ($tw = 1; $tw <= 4; $tw++): ?>
    <?php
        $targetTw = $target[$tw] ?? 0;
        $totalRealisasi = 0;
    ?>
    <tr class="hover:bg-gray-50 align-top">
        <td class="border px-4 py-2 text-center font-medium">
            TW <?= $tw ?>
        </td>

        <td class="border px-4 py-2 text-center">
            <?= $targetTw ?>
        </td>

        <!-- REALISASI PER PIC -->
        <td class="border px-4 py-2">
            <?php foreach ($realisasi as $pic): 
                $nilai = $pic['data'][$tw] ?? 0;
                if ($nilai > 0):
                    $totalRealisasi += $nilai;
            ?>
                <div class="text-sm">
                    <span class="font-semibold"><?= esc($pic['nama']) ?></span> :
                    <?= $nilai ?>
                </div>
            <?php endif; endforeach; ?>

            <?php if ($totalRealisasi === 0): ?>
                <span class="text-gray-400 text-sm">Belum ada realisasi</span>
            <?php endif; ?>

            <div class="mt-1 text-xs text-gray-500 border-t pt-1">
                Total: <?= $totalRealisasi ?>
            </div>
        </td>

        <!-- PROGRES -->
        <td class="border px-4 py-2 text-center font-semibold">
            <?php
                $progres = $targetTw > 0
                    ? min(($totalRealisasi / $targetTw) * 100, 100)
                    : 0;
            ?>
            <?= number_format($progres, 2) ?>%
        </td>
    </tr>
<?php endfor ?>
</tbody>

    </table>
</div>



<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const target = <?= json_encode(array_values($target)) ?>;
const realisasi = <?= json_encode($realisasi) ?>;

const colors = [
    '#2563eb', // blue
    '#16a34a', // green
    '#dc2626', // red
    '#9333ea', // purple
    '#ea580c', // orange
];

let colorIndex = 0;

const datasets = [
    {
        type: 'bar',
        label: 'Target TW',
        data: target,
        backgroundColor: 'rgba(37, 99, 235, 0.2)',
        borderColor: '#2563eb',
        borderWidth: 1
    }
];

Object.values(realisasi).forEach(pic => {
    datasets.push({
        type: 'line',
        label: pic.nama,
        data: [1,2,3,4].map(tw => pic.data[tw] ?? 0),
        borderColor: colors[colorIndex % colors.length],
        backgroundColor: colors[colorIndex % colors.length],
        tension: 0.3,
        borderWidth: 2,
        pointRadius: 4
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
        scales: {
            y: { beginAtZero: true }
        }
    }
});
</script>


<?= $this->endSection() ?>
