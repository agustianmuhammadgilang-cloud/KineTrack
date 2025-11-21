<?= $this->extend('layout/staff_template') ?>
<?= $this->section('content') ?>

<h3 class="text-2xl font-bold text-[var(--polban-blue)] mb-6">
    Task Anda
</h3>

<div class="bg-white shadow-md rounded-xl p-6 border border-gray-200">

    <?php if(empty($tasks)): ?>
        <p class="text-gray-600">Tidak ada task untuk Anda saat ini.</p>
    <?php else: ?>
        <ul class="space-y-3">
            <?php foreach($tasks as $t): ?>
                <li class="flex items-center justify-between p-4 rounded-lg border border-gray-200 hover:shadow-md transition">
                    
                    <div>
                        <p class="text-lg font-semibold text-gray-800">
                            <?= $t['nama_indikator'] ?>
                        </p>
                        <p class="text-sm text-gray-600">
                            Tahun <?= $t['tahun'] ?>
                        </p>
                    </div>

                    <a href="<?= base_url('staff/task/input/'.$t['indikator_id']) ?>"
                       class="px-4 py-2 bg-[var(--polban-blue)] text-white rounded-lg font-medium hover:bg-blue-700 transition shadow">
                        Isi Pengukuran
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

</div>

<?= $this->endSection() ?>