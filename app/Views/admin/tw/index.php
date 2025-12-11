<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<h3 class="text-2xl font-bold text-[var(--polban-blue)] mb-6">
    Manajemen Triwulan
</h3>

<div class="space-y-6">

    <?php foreach ($data as $row): ?>
        
        <!-- CARD PER TAHUN -->
        <div class="bg-white shadow-lg border border-gray-200 rounded-xl p-6">

            <div class="flex items-center justify-between mb-5">
                <h4 class="font-semibold text-xl text-gray-800">
                    Tahun <?= $row['tahun'] ?>
                </h4>

                <!-- Icon Tahun -->
                <div class="p-2 bg-[var(--polban-blue)]/10 rounded-lg">
                    <svg class="w-6 h-6 text-[var(--polban-blue)]" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 4h18M3 12h18M3 20h18"/>
                    </svg>
                </div>
            </div>

            <!-- LIST TW -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

                <?php foreach ($row['tw'] as $t): ?>

                    <div class="rounded-xl border border-gray-200 p-5 shadow-sm bg-gray-50 hover:bg-gray-100 transition">

                        <div class="flex items-center justify-between mb-3">
                            <p class="font-semibold text-gray-800">TW <?= $t['tw'] ?></p>

                            <!-- BADGE STATUS -->
                            <?php if ($t['is_open_effective']): ?>
                                <span class="flex items-center gap-1 text-green-600 text-sm font-semibold">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                    </path>
                                    </svg>
                                    Dibuka
                                </span>
                            <?php else: ?>
                                <span class="flex items-center gap-1 text-red-500 text-sm font-semibold">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                    </path>
                                    </svg>
                                    Dikunci
                                </span>
                            <?php endif; ?>
                        </div>

                        <!-- LABEL TW SAAT INI -->
                        <?php if ($t['is_auto_now']): ?>
                            <div class="text-xs font-semibold text-blue-700 mb-2 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M12 6v6l4 2"/>
                                </svg>
                                TW Saat Ini
                            </div>
                        <?php endif; ?>


                        <!-- TOGGLE SWITCH MANUAL -->
                        <a 
                            href="<?= base_url('admin/tw/toggle/' . $t['id']) ?>"
                            class="flex items-center mt-3"
                        >
                            <div 
                                class="w-14 h-7 flex items-center rounded-full transition
                                <?= $t['is_open_effective'] ? 'bg-green-500' : 'bg-gray-400' ?>"
                            >
                                <div 
                                    class="w-6 h-6 bg-white rounded-full shadow transform transition
                                    <?= $t['is_open_effective'] ? 'translate-x-7' : 'translate-x-1' ?>"
                                ></div>
                            </div>

                            <span class="ml-3 font-medium text-sm 
                                <?= $t['is_open_effective'] ? 'text-green-700' : 'text-gray-600' ?>">
                                <?= $t['is_open_effective'] ? 'Kunci TW' : 'Buka TW' ?>
                            </span>

                        </a>

                    </div>

                <?php endforeach; ?>

            </div>
        </div>

    <?php endforeach; ?>

</div>

<?= $this->endSection() ?>
