<?= $this->extend('layout/staff_template') ?>
<?= $this->section('content') ?>

<div class="p-4 sm:p-6 md:p-8 transition-all duration-300 dark:bg-gray-900">

    <h3 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-100">
        Dashboard Kinerja Saya
    </h3>

    <!-- STATISTIC CARDS -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-6">

        <!-- Diterima (Biru) -->
        <div class="group bg-blue-500 dark:bg-blue-600 shadow-md rounded-2xl p-6 text-center text-white transform transition-all hover:scale-105 hover:shadow-2xl relative overflow-hidden">
            <div class="absolute right-3 top-3 opacity-20 group-hover:opacity-50">
                <svg class="w-10 h-10 sm:w-12 sm:h-12" fill="none">
                    <?= heroicons_outline('check-circle') ?>
                </svg>
            </div>
            <h5 class="font-semibold mb-1">Diterima</h5>
            <h2 class="text-3xl font-bold mt-1"><?= $approved ?></h2>
        </div>

        <!-- Ditolak (Kuning) -->
        <div class="group bg-yellow-400 dark:bg-yellow-500 shadow-md rounded-2xl p-6 text-center text-white transform transition-all hover:scale-105 hover:shadow-2xl relative overflow-hidden">
            <div class="absolute right-3 top-3 opacity-20 group-hover:opacity-50">
                <svg class="w-10 h-10 sm:w-12 sm:h-12" fill="none">
                    <?= heroicons_outline('x-circle') ?>
                </svg>
            </div>
            <h5 class="font-semibold mb-1">Ditolak</h5>
            <h2 class="text-3xl font-bold mt-1"><?= $rejected ?></h2>
        </div>

        <!-- Progress (Orange) -->
        <div class="group bg-orange-500 dark:bg-orange-600 shadow-md rounded-2xl p-6 text-center text-white transform transition-all hover:scale-105 hover:shadow-2xl relative overflow-hidden">
            <div class="absolute right-3 top-3 opacity-20 group-hover:opacity-50">
                <svg class="w-10 h-10 sm:w-12 sm:h-12" fill="none">
                    <?= heroicons_outline('trending-up') ?>
                </svg>
            </div>
            <h5 class="font-semibold mb-1">Progress</h5>
            <h2 class="text-3xl font-bold mt-1"><?= $progress ?>%</h2>
            <div class="w-full bg-white/30 rounded-full h-4 mt-3 overflow-hidden">
                <div class="h-4 bg-white" style="width: <?= $progress ?>%"></div>
            </div>
        </div>

    </div>

    <!-- GRAFIK -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- Grafik Harian -->
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-2xl p-6 transition hover:shadow-xl">
            <h6 class="font-semibold mb-4 text-gray-700 dark:text-gray-200">Grafik Harian</h6>
            <div class="w-full overflow-x-auto h-72">
                <canvas id="dailyChart"></canvas>
            </div>
        </div>

        <!-- Grafik Mingguan -->
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-2xl p-6 transition hover:shadow-xl">
            <h6 class="font-semibold mb-4 text-gray-700 dark:text-gray-200">Grafik Mingguan</h6>
            <div class="w-full overflow-x-auto h-72">
                <canvas id="weeklyChart"></canvas>
            </div>
        </div>

        <!-- Grafik Bulanan -->
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-2xl p-6 lg:col-span-2 transition hover:shadow-xl">
            <h6 class="font-semibold mb-4 text-gray-700 dark:text-gray-200">Grafik Bulanan</h6>
            <div class="w-full overflow-x-auto h-80">
                <canvas id="monthlyChart"></canvas>
            </div>
        </div>

    </div>

    <!-- Footer -->
    <p class="text-center text-gray-500 dark:text-gray-400 mt-6 sm:mt-8 text-xs sm:text-sm">
        © <?= date('Y') ?> KINETRACK — Politeknik Negeri Bandung.
    </p>

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
        plugins: { legend: { display: false } },
        scales: {
            x: { ticks: { maxRotation: 45, minRotation: 0 } },
            y: { beginAtZero: true }
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
                tension: 0.3,
                fill: true
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
                backgroundColor: '#FBBF24' // Kuning
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
                backgroundColor: '#F97316' // Orange
            }]
        },
        options: chartOptions
    });
</script>

<?= $this->endSection() ?>
