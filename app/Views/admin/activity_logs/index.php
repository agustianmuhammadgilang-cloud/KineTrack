<?= $this->extend('layout/admin_template') ?> 
<?= $this->section('content') ?>

<div class="max-w-7xl mx-auto space-y-8">

    <!-- HEADER -->
    <div class="bg-white rounded-2xl border shadow-sm p-6">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-[#1D2F83]/10 flex items-center justify-center">
                <svg class="w-5 h-5 text-[#1D2F83]" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <h4 class="text-2xl font-semibold text-gray-800">
                    Log Aktivitas Sistem
                </h4>
                <p class="text-sm text-gray-500 mt-1">
                    Riwayat aktivitas pengguna dalam sistem Kinetrack
                </p>
            </div>
        </div>
    </div>

    <!-- EMPTY STATE -->
    <?php if (empty($logs)) : ?>
        <div class="bg-white border border-dashed rounded-2xl p-12 text-center">
            <div class="mx-auto w-16 h-16 flex items-center justify-center
                        rounded-full bg-gray-100 mb-4">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 4v16m8-8H4"/>
                </svg>
            </div>
            <p class="font-medium text-gray-700">
                Belum ada aktivitas tercatat
            </p>
            <p class="text-sm text-gray-500 mt-1">
                Semua aktivitas sistem akan muncul di sini
            </p>
        </div>

    <?php else : ?>

    <!-- LOG LIST -->
    <div class="bg-white rounded-2xl border shadow-sm overflow-hidden">

        <div class="divide-y">
            <?php foreach ($logs as $log) : ?>
            <div class="p-6 hover:bg-gray-50 transition">

                <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4">

                    <!-- LEFT -->
                    <div class="flex items-start gap-4">

                        <!-- ICON -->
                        <div class="w-10 h-10 rounded-full bg-[#F58025]/10
                                    flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-[#F58025]" fill="none" stroke="currentColor" stroke-width="2"
                                 viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M5.121 17.804A13.937 13.937 0 0112 15
                                         c2.5 0 4.847.655 6.879 1.804M15 10
                                         a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>

                        <!-- CONTENT -->
                        <div class="space-y-1">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="font-semibold text-gray-800">
                                    <?= esc($log['nama']) ?>
                                </span>

                                <span class="px-2 py-0.5 rounded-full text-xs font-medium
                                    <?= $log['role'] === 'admin'
                                        ? 'bg-red-100 text-red-700'
                                        : ($log['role'] === 'atasan'
                                            ? 'bg-blue-100 text-blue-700'
                                            : 'bg-gray-100 text-gray-700') ?>">
                                    <?= ucfirst(esc($log['role'])) ?>
                                </span>
                            </div>

                            <p class="text-sm text-gray-600">
                                <?= esc($log['description']) ?>
                            </p>
                        </div>
                    </div>

                    <!-- RIGHT -->
                    <div class="text-sm text-gray-500 whitespace-nowrap">
                        <?= date('d M Y • H:i', strtotime($log['created_at'])) ?>
                    </div>

                </div>
            </div>
            <?php endforeach ?>
        </div>

    </div>

    <?php endif; ?>

</div>

<?= $this->endSection() ?>
