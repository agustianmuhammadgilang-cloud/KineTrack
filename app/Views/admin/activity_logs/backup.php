<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<div class="max-w-6xl mx-auto py-8 px-4">

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-[#003366] tracking-tight">
                Database <span class="text-blue-600">Archive Manager</span>
            </h1>
            <p class="text-gray-500 mt-1">
                Pusat kendali pencadangan dan pemulihan data log aktivitas sistem.
            </p>
        </div>
        <div class="flex items-center gap-2 bg-blue-50 px-4 py-2 rounded-2xl border border-blue-100">
            <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
            <span class="text-[11px] font-bold text-blue-700 uppercase tracking-wider">Sistem Pemulihan Aktif</span>
        </div>
    </div>

    <?php foreach (['success','error'] as $type): ?>
        <?php if (session()->getFlashdata($type)): ?>
            <div class="mb-6 flex items-center p-4 rounded-2xl border <?= $type=='success'?'bg-green-50 border-green-200 text-green-800':'bg-red-50 border-red-200 text-red-800' ?> shadow-sm animate-fade-in">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?= $type=='success'?'M5 13l4 4L19 7':'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z' ?>"/>
                </svg>
                <span class="text-sm font-semibold"><?= session()->getFlashdata($type) ?></span>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm flex items-start gap-4">
            <div class="p-3 bg-blue-50 rounded-xl text-blue-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.58 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.58 4 8 4s8-1.79 8-4M4 7c0-2.21 3.58-4 8-4s8 1.79 8 4m0 5c0 2.21-3.58 4-8 4s-8-1.79-8-4"/></svg>
            </div>
            <div>
                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Format Restore</h4>
                <p class="text-sm font-bold text-gray-700">Wajib .JSON</p>
            </div>
        </div>
        <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm flex items-start gap-4">
            <div class="p-3 bg-green-50 rounded-xl text-green-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <div>
                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Fungsi CSV</h4>
                <p class="text-sm font-bold text-gray-700">Audit Eksternal</p>
            </div>
        </div>
        <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm flex items-start gap-4">
            <div class="p-3 bg-orange-50 rounded-xl text-orange-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
            </div>
            <div>
                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Integritas</h4>
                <p class="text-sm font-bold text-gray-700">Restored Mark</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50/50 border-b border-gray-100">
                    <th class="px-8 py-5 text-[11px] font-black text-gray-400 uppercase tracking-widest">Periode Data Arsip</th>
                    <th class="px-8 py-5 text-[11px] font-black text-gray-400 uppercase tracking-widest text-center">Volume Data</th>
                    <th class="px-8 py-5 text-[11px] font-black text-gray-400 uppercase tracking-widest text-center">Tgl. Pencadangan</th>
                    <th class="px-8 py-5 text-[11px] font-black text-gray-400 uppercase tracking-widest text-right">Manajemen File</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-50">
                <?php if (empty($backups)): ?>
                    <tr>
                        <td colspan="4" class="text-center py-24">
                            <div class="flex flex-col items-center">
                                <div class="bg-gray-50 p-4 rounded-full mb-4">
                                    <svg class="w-12 h-12 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                                </div>
                                <p class="text-gray-400 font-medium italic">Belum ada file cadangan yang tersimpan.</p>
                            </div>
                        </td>
                    </tr>
                <?php else: foreach ($backups as $b): ?>
                    <tr class="hover:bg-gray-50/80 transition-all group">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center border border-blue-100">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-gray-800 tracking-tight leading-none mb-1"><?= esc($b['period']) ?></p>
                                    <p class="text-[10px] text-gray-400 font-semibold uppercase tracking-tighter">System Recovery Point</p>
                                </div>
                            </div>
                        </td>

                        <td class="px-8 py-6 text-center">
                            <div class="inline-flex flex-col">
                                <span class="text-sm font-black text-red-600 bg-red-50 px-3 py-1 rounded-lg">
                                    <?= number_format($b['total']) ?>
                                </span>
                                <span class="text-[10px] font-bold text-gray-300 uppercase mt-1">Record Log</span>
                            </div>
                        </td>

                        <td class="px-8 py-6 text-center">
                            <p class="text-sm font-semibold text-gray-600"><?= date('d M Y', strtotime($b['created_at'])) ?></p>
                            <p class="text-[10px] text-gray-400 font-medium tracking-widest"><?= date('H:i', strtotime($b['created_at'])) ?> WIB</p>
                        </td>

                        <td class="px-8 py-6 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="<?= base_url('admin/activity-logs/backup/download/'.$b['csv_file']) ?>"
                                   class="inline-flex items-center gap-2 px-4 py-2.5 text-[11px] font-black bg-white border border-gray-200 hover:border-green-500 hover:text-green-600 text-gray-600 rounded-xl shadow-sm transition-all"
                                   title="Download format audit Excel">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    AUDIT CSV
                                </a>

                                <form action="<?= base_url('admin/activity-logs/backup/restore') ?>"
                                      method="post"
                                      class="inline"
                                      onsubmit="return confirm('Sistem akan memulihkan data ke Log Aktif. Lanjutkan?');">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="file" value="<?= esc($b['json_file']) ?>">
                                    <button
                                        class="inline-flex items-center gap-2 px-5 py-2.5 text-[11px] font-black bg-[#003366] hover:bg-blue-800 text-white rounded-xl shadow-md shadow-blue-900/10 transition-all transform hover:-translate-y-0.5 active:scale-95">
                                        <svg class="w-4 h-4 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                        RESTORE
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; endif; ?>
            </tbody>
        </table>
    </div>

    <div class="mt-10 flex flex-col items-center">
        <div class="w-12 h-1 bg-gray-100 rounded-full mb-4"></div>
        <p class="text-[11px] text-gray-400 text-center max-w-lg leading-relaxed uppercase tracking-widest font-semibold">
            Keamanan data adalah prioritas utama. Selalu lakukan verifikasi setelah melakukan proses pemulihan (restore) data.
        </p>
    </div>

</div>

<style>
    @keyframes fade-in {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        animation: fade-in 0.3s ease-out forwards;
    }
</style>

<?= $this->endSection() ?>