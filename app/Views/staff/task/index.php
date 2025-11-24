<?= $this->extend('layout/staff_template') ?>
<?= $this->section('content') ?>

<h3 class="text-2xl font-bold text-[var(--polban-blue)] mb-6">
    Task Anda
</h3>

<div class="bg-white shadow-md rounded-xl p-6 border border-gray-200">

    <?php if(empty($tasks)): ?>
        <p class="text-gray-600">Tidak ada task untuk Anda saat ini.</p>
    <?php else: ?>
        <?php 
        // Kelompokkan tasks berdasarkan Sasaran Strategis
        $tasksBySasaran = [];
        foreach($tasks as $t) {
            $ss = $t['nama_sasaran'] ?? 'Tanpa Sasaran';
            $tasksBySasaran[$ss][] = $t;
        }
        ?>

        <?php foreach($tasksBySasaran as $sasaran => $taskList): ?>
            <!-- Header SS -->
            <h4 class="text-lg font-bold text-[var(--polban-blue)] mb-2 border-b pb-1">
                <?= $sasaran ?>
            </h4>

            <ul class="mb-4 space-y-2">
                <?php foreach($taskList as $t): ?>
                    <li class="flex items-center justify-between p-3 rounded-lg border border-gray-200 hover:shadow-md transition">
                        <div>
                            <p class="text-gray-800 font-semibold"><?= $t['nama_indikator'] ?></p>
                            <p class="text-sm text-gray-600">Tahun <?= $t['tahun'] ?></p>
                        </div>

                        <a href="<?= base_url('staff/task/input/'.$t['indikator_id']) ?>"
                           class="px-3 py-1 bg-[var(--polban-blue)] text-white rounded font-medium hover:bg-blue-700 transition shadow">
                            Isi Pengukuran
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endforeach; ?>
    <?php endif; ?>

</div>

<?= $this->endSection() ?>
