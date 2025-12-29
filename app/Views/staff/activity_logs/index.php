<?= $this->extend('layout/staff_template') ?>
<?= $this->section('content') ?>

<div class="max-w-6xl mx-auto space-y-8">

    <!-- HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-semibold text-gray-800">
                Log Aktivitas
            </h2>
            <p class="text-sm text-gray-500 mt-1">
                Riwayat seluruh aktivitas yang pernah Anda lakukan di sistem
            </p>
        </div>
    </div>

    <!-- EMPTY STATE -->
    <?php if (empty($logs)): ?>
        <div class="bg-white border border-dashed rounded-2xl p-12 text-center">
            <div class="mx-auto w-14 h-14 flex items-center justify-center
                        rounded-full bg-gray-100 mb-4">
                <svg class="w-7 h-7 text-gray-400" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>

            <p class="text-gray-700 font-medium">
                Belum ada aktivitas
            </p>
            <p class="text-sm text-gray-500 mt-1">
                Semua aktivitas Anda akan tercatat dan muncul di halaman ini
            </p>
        </div>

    <?php else: ?>

    <!-- ACTIVITY LIST -->
    <div class="space-y-4">

        <?php foreach ($logs as $log): ?>

        <div class="bg-white rounded-2xl border shadow-sm
                    hover:shadow-md transition p-5">

            <div class="flex items-start gap-4">

                <!-- ICON -->
                <div class="flex-shrink-0 w-10 h-10 rounded-full
                            bg-orange-100 text-orange-600
                            flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M13 16h-1v-4h-1m1-4h.01M12 20a8 8 0 100-16 8 8 0 000 16z"/>
                    </svg>
                </div>

                <!-- CONTENT -->
                <div class="flex-1 space-y-2">

                    <!-- ACTIVITY -->
                    <p class="text-gray-800 font-medium leading-relaxed">
                        <?= esc($log['description']) ?>
                    </p>

                    <!-- META -->
                    <div class="flex flex-wrap items-center gap-x-4 gap-y-1
                                text-xs text-gray-500">

                        <span class="flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2"
                                 viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M12 8v4l3 3"/>
                            </svg>
                            <?= date('d M Y • H:i', strtotime($log['created_at'])) ?>
                        </span>

                        <?php if (!empty($log['ip_address'])): ?>
                        <span class="flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2"
                                 viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M12 11c0 1.657-1.343 3-3 3s-3-1.343-3-3 1.343-3 3-3 3 1.343 3 3z"/>
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M12 11v8m0-8c0-1.657 1.343-3 3-3s3 1.343 3 3"/>
                            </svg>
                            IP: <?= esc($log['ip_address']) ?>
                        </span>
                        <?php endif; ?>

                    </div>

                </div>

            </div>
        </div>

        <?php endforeach; ?>
    </div>

    <?php endif; ?>

</div>

<?= $this->endSection() ?>