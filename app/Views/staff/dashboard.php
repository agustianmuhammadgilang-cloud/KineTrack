<?= $this->extend('layout/staff_template') ?>
<?= $this->section('content') ?>

<h3 class="fw-bold mb-4">Dashboard Kinerja Saya</h3>

<div class="row mb-4">

    <!-- Approved -->
    <div class="col-md-4">
        <div class="card shadow p-3 text-center">
            <h5 class="fw-bold text-success">Diterima</h5>
            <h2 class="fw-bold"><?= $approved ?></h2>
        </div>
    </div>

    <!-- Rejected -->
    <div class="col-md-4">
        <div class="card shadow p-3 text-center">
            <h5 class="fw-bold text-danger">Ditolak</h5>
            <h2 class="fw-bold"><?= $rejected ?></h2>
        </div>
    </div>

    <!-- Progress -->
    <div class="col-md-4">
        <div class="card shadow p-3 text-center">
            <h5 class="fw-bold text-primary">Progress</h5>
            <h2 class="fw-bold"><?= $progress ?>%</h2>

            <div class="progress mt-2">
                <div class="progress-bar bg-primary" 
                     style="width: <?= $progress ?>%"></div>
            </div>
        </div>
    </div>
</div>

<!-- GRAFIK -->
<div class="row">

    <div class="col-md-6 mb-4">
        <div class="card shadow p-3">
            <h6 class="fw-bold">Grafik Harian</h6>
            <canvas id="dailyChart"></canvas>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card shadow p-3">
            <h6 class="fw-bold">Grafik Mingguan</h6>
            <canvas id="weeklyChart"></canvas>
        </div>
    </div>

    <div class="col-md-12 mb-4">
        <div class="card shadow p-3">
            <h6 class="fw-bold">Grafik Bulanan</h6>
            <canvas id="monthlyChart"></canvas>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Convert PHP to JS
    const dailyLabels = <?= json_encode(array_column($daily, 'tgl')) ?>;
    const dailyData = <?= json_encode(array_column($daily, 'total')) ?>;

    const weeklyLabels = <?= json_encode(array_column($weekly, 'minggu')) ?>;
    const weeklyData = <?= json_encode(array_column($weekly, 'total')) ?>;

    const monthlyLabels = <?= json_encode(array_column($monthly, 'bulan')) ?>;
    const monthlyData = <?= json_encode(array_column($monthly, 'total')) ?>;

    // Daily Chart
    new Chart(document.getElementById('dailyChart'), {
        type: 'line',
        data: {
            labels: dailyLabels,
            datasets: [{
                label: 'Laporan per Hari',
                data: dailyData,
                borderColor: '#007bff'
            }]
        }
    });

    // Weekly Chart
    new Chart(document.getElementById('weeklyChart'), {
        type: 'bar',
        data: {
            labels: weeklyLabels,
            datasets: [{
                label: 'Laporan per Minggu',
                data: weeklyData,
                backgroundColor: '#28a745'
            }]
        }
    });

    // Monthly Chart
    new Chart(document.getElementById('monthlyChart'), {
        type: 'bar',
        data: {
            labels: monthlyLabels,
            datasets: [{
                label: 'Laporan per Bulan',
                data: monthlyData,
                backgroundColor: '#ffc107'
            }]
        }
    });
</script>

<?= $this->endSection() ?>
