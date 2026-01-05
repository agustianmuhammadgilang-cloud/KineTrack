<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<div class="container mx-auto pb-10">
    <div class="flex flex-col md:flex-row md:items-end justify-between mb-8 gap-4 border-b-2 border-gray-100 pb-6">
        <div>
            <nav class="text-sm text-gray-500 mb-2">Admin &raquo; Log Aktivitas</nav>
            <h1 class="text-4xl font-extrabold text-[#003366] tracking-tight">Log Arsip <span class="text-yellow-500">Historis</span></h1>
            <p class="text-gray-500 mt-2 max-w-xl">Pusat penyimpanan data historis sistem e-Kinerja untuk audit dan pemantauan jangka panjang.</p>
        </div>
        
        <form action="<?= base_url('admin/activity-logs/archive/backup') ?>" method="post">
            <?= csrf_field() ?>
            <button class="inline-flex items-center px-6 py-3 bg-[#003366] hover:bg-[#002244] text-white text-sm font-bold rounded-xl transition-all shadow-md hover:shadow-lg gap-3 transform hover:-translate-y-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="C8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                </svg>
                Backup Seluruh Arsip
            </button>
        </form>
    </div>

    <div class="bg-blue-50 border-l-4 border-blue-600 p-5 rounded-r-xl mb-8 shadow-sm">
        <div class="flex items-center">
            <div class="bg-blue-600 p-2 rounded-full text-white shadow-md">
                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-bold text-blue-900">Kebijakan Penyimpanan Data</h3>
                <p class="text-xs text-blue-700 mt-1 uppercase tracking-wide font-medium">Auto-Archive: > 3 Bulan | Auto-Purge: 6 Bulan (Wajib Backup)</p>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200 mb-8 items-center">
        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Filter Periode Arsip</h4>
        <form method="get" class="flex flex-wrap items-center gap-4">
            <div class="flex-1 min-w-[200px]">
                <div class="relative">
                    <select name="bulan" class="w-full bg-gray-50 border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#003366] focus:border-[#003366] py-3 pl-4 transition-all">
                        <option value="">Semua Bulan</option>
                        <?php for ($i = 1; $i <= 12; $i++): ?>
                            <option value="<?= $i ?>" <?= ($bulan == $i) ? 'selected' : '' ?>>
                                <?= date('F', mktime(0, 0, 0, $i, 1)) ?>
                            </option>
                        <?php endfor; ?>
                    </select>
                </div>
            </div>

            <div class="flex-1 min-w-[200px]">
                <select name="tahun" class="w-full bg-gray-50 border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#003366] focus:border-[#003366] py-3 pl-4 transition-all">
                    <option value="">Semua Tahun</option>
                    <?php for ($y = date('Y'); $y >= date('Y') - 5; $y--): ?>
                        <option value="<?= $y ?>" <?= ($tahun == $y) ? 'selected' : '' ?>>
                            <?= $y ?>
                        </option>
                    <?php endfor; ?>
                </select>
            </div>

            <button type="submit" class="w-full md:w-auto px-8 py-3 bg-gray-800 hover:bg-black text-white rounded-xl text-sm font-bold transition-all shadow hover:shadow-lg">
                Terapkan Filter
            </button>
        </form>
    </div>

    <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#003366] text-white">
                        <th class="px-6 py-5 text-xs font-bold uppercase tracking-wider">Waktu & Tanggal</th>
                        <th class="px-6 py-5 text-xs font-bold uppercase tracking-wider">Pelaku / User</th>
                        <th class="px-6 py-5 text-xs font-bold uppercase tracking-wider">Aktivitas</th>
                        <th class="px-6 py-5 text-xs font-bold uppercase tracking-wider">Objek Sistem</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php if (empty($logs)): ?>
                        <tr>
                            <td colspan="4" class="px-6 py-20 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="p-4 bg-gray-50 rounded-full mb-4">
                                        <svg class="h-10 w-10 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                        </svg>
                                    </div>
                                    <p class="text-gray-400 font-medium italic">Data arsip tidak ditemukan untuk periode ini.</p>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($logs as $log): ?>
                            <tr class="hover:bg-blue-50/50 transition-colors group">
                                <td class="px-6 py-5 whitespace-nowrap border-l-4 border-transparent group-hover:border-yellow-500">
                                    <div class="text-sm font-bold text-gray-800"><?= date('d M Y', strtotime($log['created_at'])) ?></div>
                                    <div class="text-[11px] text-gray-400 font-semibold uppercase"><?= date('H:i', strtotime($log['created_at'])) ?> WIB</div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-bold text-gray-900"><?= esc($log['nama'] ?? 'System') ?></span>
                                        <span class="inline-flex mt-1 text-[10px] font-extrabold text-blue-600 bg-blue-50 px-2 py-0.5 rounded border border-blue-100 w-max uppercase">
                                            <?= esc($log['role']) ?>
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <p class="text-sm text-gray-600 leading-relaxed"><?= esc($log['description']) ?></p>
                                </td>
                                <td class="px-6 py-5">
                                    <span class="text-xs font-mono bg-gray-50 px-3 py-1.5 rounded-lg border border-gray-200 text-gray-500">
                                        <?= esc($log['subject_type'] ?? 'General') ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-8 flex flex-col items-center">
        <div class="w-16 h-1 bg-yellow-400 rounded-full mb-4"></div>
        <p class="text-[12px] text-gray-400 text-center max-w-md leading-relaxed">
            Data ini telah dipindahkan dari tabel utama untuk menjaga performa sistem e-Kinerja Polban. Pastikan backup dilakukan secara rutin.
        </p>
    </div>
</div>

<?= $this->endSection() ?>