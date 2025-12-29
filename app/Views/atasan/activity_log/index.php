<?= $this->extend('layout/atasan_template') ?>
<?= $this->section('content') ?>

<div class="max-w-7xl mx-auto space-y-8">

    <!-- HEADER -->
    <div class="bg-white rounded-2xl border shadow-sm p-6">
        <h2 class="text-2xl font-semibold text-gray-800">
            Log Aktivitas
        </h2>
        <p class="text-sm text-gray-500 mt-1">
            Riwayat seluruh aktivitas yang dilakukan oleh Anda sebagai atasan
        </p>
    </div>

    <!-- EMPTY STATE -->
    <?php if (empty($logs)): ?>
        <div class="bg-white border border-dashed rounded-2xl p-12 text-center">
            <div class="mx-auto w-16 h-16 flex items-center justify-center
                        rounded-full bg-gray-100 mb-4">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 6v6l4 2"/>
                </svg>
            </div>

            <p class="text-gray-700 font-medium">
                Belum ada aktivitas tercatat
            </p>
            <p class="text-sm text-gray-500 mt-1">
                Aktivitas Anda akan otomatis tercatat di halaman ini
            </p>
        </div>

    <?php else: ?>

    <!-- LOG LIST -->
    <div class="space-y-4">

        <?php foreach ($logs as $log): ?>

        <?php
            // Badge warna berdasarkan aksi
            $actionClass = match ($log['action']) {
                'create'  => 'bg-blue-100 text-blue-700',
                'update'  => 'bg-yellow-100 text-yellow-700',
                'delete'  => 'bg-red-100 text-red-700',
                'approve' => 'bg-green-100 text-green-700',
                'reject'  => 'bg-orange-100 text-orange-700',
                default   => 'bg-gray-100 text-gray-700',
            };
        ?>

        <!-- ITEM -->
        <div class="bg-white rounded-2xl border shadow-sm
                    hover:shadow-md transition p-6">

            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">

                <!-- LEFT -->
                <div class="space-y-2">

                    <!-- ACTION -->
                    <div class="flex items-center gap-3">
                        <span class="px-3 py-1 rounded-full text-xs font-medium <?= $actionClass ?>">
                            <?= strtoupper(esc($log['action'])) ?>
                        </span>

                        <span class="text-sm text-gray-500">
                            <?= date('d M Y · H:i', strtotime($log['created_at'])) ?>
                        </span>
                    </div>

                    <!-- DESCRIPTION -->
                    <p class="text-gray-800 font-medium">
                        <?= esc($log['description']) ?>
                    </p>

                    <!-- META -->
                    <div class="flex flex-wrap items-center gap-4 text-xs text-gray-500">

                        <!-- IP -->
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                 viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M3 7h18M3 12h18M3 17h18"/>
                            </svg>
                            IP: <?= esc($log['ip_address']) ?>
                        </span>

                    </div>
                </div>

                <!-- RIGHT (TIME BADGE) -->
                <div class="text-sm text-gray-400 whitespace-nowrap">
                    <?= date('l', strtotime($log['created_at'])) ?>
                </div>

            </div>
        </div>

        <?php endforeach; ?>

    </div>

    <?php endif; ?>

</div>

<?= $this->endSection() ?>