<?= $this->extend('layout/staff_template') ?>
<?= $this->section('content') ?>

<h3 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-100">
    Dashboard Kinerja Saya
</h3>


<!-- STATISTIC CARDS -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-6">

    <!-- Diterima -->
    <div class="bg-white dark:bg-gray-800 shadow-md rounded-xl p-6 text-center transition">
        <h5 class="text-green-500 font-semibold mb-1">Diterima</h5>
        <h2 class="text-3xl font-bold text-gray-900 dark:text-gray-100"><?= $approved ?></h2>
    </div>

    <!-- Ditolak -->
    <div class="bg-white dark:bg-gray-800 shadow-md rounded-xl p-6 text-center transition">
        <h5 class="text-red-500 font-semibold mb-1">Ditolak</h5>
        <h2 class="text-3xl font-bold text-gray-900 dark:text-gray-100"><?= $rejected ?></h2>
    </div>

    <!-- Progress -->
    <div class="bg-white dark:bg-gray-800 shadow-md rounded-xl p-6 text-center transition">
        <h5 class="text-blue-500 font-semibold mb-1">Progress</h5>
        <h2 class="text-3xl font-bold text-gray-900 dark:text-gray-100"><?= $progress ?>%</h2>

        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-4 mt-3 overflow-hidden">
            <div class="h-4 bg-blue-500" style="width: <?= $progress ?>%"></div>
        </div>
    </div>

</div>

<!-- GRAFIK -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    <!-- Grafik Harian -->
    <div class="bg-white dark:bg-gray-800 shadow-md rounded-xl p-6">
        <h6 class="font-semibold mb-4 text-gray-700 dark:text-gray-200">Grafik Harian</h6>
        <div class="w-full overflow-x-auto">
            <canvas id="dailyChart"></canvas>
        </div>
    </div>

    <!-- Grafik Mingguan -->
    <div class="bg-white dark:bg-gray-800 shadow-md rounded-xl p-6">
        <h6 class="font-semibold mb-4 text-gray-700 dark:text-gray-200">Grafik Mingguan</h6>
        <div class="w-full overflow-x-auto">
            <canvas id="weeklyChart"></canvas>
        </div>
    </div>

    <!-- Grafik Bulanan -->
    <div class="bg-white dark:bg-gray-800 shadow-md rounded-xl p-6 lg:col-span-2">
        <h6 class="font-semibold mb-4 text-gray-700 dark:text-gray-200">Grafik Bulanan</h6>
        <div class="w-full overflow-x-auto">
            <canvas id="monthlyChart"></canvas>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const dailyLabels = <?= json_encode(array_column($daily, 'tgl')) ?>;
    const dailyData = <?= json_encode(array_column($daily, 'total')) ?>;

    const weeklyLabels = <?= json_encode(array_column($weekly, 'minggu')) ?>;
    const weeklyData = <?= json_encode(array_column($weekly, 'total')) ?>;

    const monthlyLabels = <?= json_encode(array_column($monthly, 'bulan')) ?>;
    const monthlyData = <?= json_encode(array_column($monthly, 'total')) ?>;

    const chartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false }
        },
        scales: {
            x: { ticks: { maxRotation: 45, minRotation: 0 } }
        }
    };

    new Chart(document.getElementById('dailyChart'), {
        type: 'line',
        data: {
            labels: dailyLabels,
            datasets: [{
                label: 'Laporan per Hari',
                data: dailyData,
                borderColor: '#3B82F6',
                backgroundColor: '#3B82F666',
                tension: 0.3
            }]
        },
        options: chartOptions
    });

    new Chart(document.getElementById('weeklyChart'), {
        type: 'bar',
        data: {
            labels: weeklyLabels,
            datasets: [{
                label: 'Laporan per Minggu',
                data: weeklyData,
                backgroundColor: '#10B981'
            }]
        },
        options: chartOptions
    });

    new Chart(document.getElementById('monthlyChart'), {
        type: 'bar',
        data: {
            labels: monthlyLabels,
            datasets: [{
                label: 'Laporan per Bulan',
                data: monthlyData,
                backgroundColor: '#F59E0B'
            }]
        },
        options: chartOptions
    });
</script>

<?= $this->endSection() ?>
