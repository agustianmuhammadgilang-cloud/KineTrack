<?= $this->extend('layout/admin_template') ?>

<?= $this->section('content') ?>

<div class="mb-8">
    <div class="flex items-center space-x-3 mb-2">
        <div class="p-2 bg-blue-100 rounded-lg text-blue-900">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <h1 class="text-3xl font-bold text-gray-800 tracking-tight">Manajemen Siklus Log</h1>
    </div>
    <p class="text-gray-500 ml-11">
        Otomatisasi pembersihan dan pengarsipan data untuk menjaga performa database tetap optimal.
    </p>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-200 text-green-700 shadow-sm flex items-center animate-fade-in">
        <div class="bg-green-500 rounded-full p-1 mr-3">
            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
        </div>
        <span class="font-medium"><?= session()->getFlashdata('success') ?></span>
    </div>
<?php endif; ?>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <div class="lg:col-span-1 space-y-6">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200">
            <h3 class="font-bold text-gray-800 mb-6 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                Alur Retensi Data
            </h3>
            
            <div class="relative">
                <div class="flex items-center mb-8 relative z-10">
                    <div class="flex-shrink-0 w-10 h-10 bg-green-100 text-green-600 rounded-full flex items-center justify-center font-bold">1</div>
                    <div class="ml-4">
                        <h4 class="text-sm font-bold text-gray-800">Data Aktif</h4>
                        <p class="text-xs text-gray-500">Log baru yang sedang berjalan</p>
                    </div>
                </div>
                <div class="absolute left-5 top-10 w-0.5 h-10 bg-gray-200"></div>

                <div class="flex items-center mb-8 relative z-10">
                    <div class="flex-shrink-0 w-10 h-10 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center font-bold">2</div>
                    <div class="ml-4">
                        <h4 class="text-sm font-bold text-gray-800">Arsip Otomatis</h4>
                        <p class="text-xs text-gray-500">Dipindahkan setelah <span class="text-blue-600 font-semibold"><?= $config['archive_after_months'] ?? '?' ?> bln</span></p>
                    </div>
                </div>
                <div class="absolute left-5 top-24 w-0.5 h-10 bg-gray-200"></div>

                <div class="flex items-center relative z-10">
                    <div class="flex-shrink-0 w-10 h-10 bg-red-100 text-red-600 rounded-full flex items-center justify-center font-bold">3</div>
                    <div class="ml-4">
                        <h4 class="text-sm font-bold text-gray-800">Hapus Permanen</h4>
                        <p class="text-xs text-gray-500">Dihapus setelah <span class="text-red-600 font-semibold"><?= $config['delete_after_months'] ?? '?' ?> bln</span></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-blue-900 text-white p-6 rounded-2xl shadow-lg">
            <h3 class="font-semibold text-lg mb-3">Tips Keamanan</h3>
            <p class="text-blue-100 text-sm leading-relaxed mb-4">
                Disarankan menyimpan arsip minimal 6-12 bulan untuk kebutuhan audit atau pemeriksaan data historis.
            </p>
            <div class="p-3 bg-blue-800 rounded-lg border border-blue-700">
                <p class="text-xs text-blue-200 italic font-mono">
                    Last Run: <?= date('Y-m-d H:i') ?> (Cron OK)
                </p>
            </div>
        </div>
    </div>

    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gray-50 px-8 py-4 border-b border-gray-200">
                <h2 class="text-lg font-bold text-gray-800">Konfigurasi Penjadwal</h2>
            </div>
            
            <form method="post" action="<?= base_url('admin/activity-logs/schedule') ?>" class="p-8" id="scheduleForm">
                <?= csrf_field() ?>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-gray-700">
                            Ambang Batas Pengarsipan
                        </label>
                        <div class="relative group">
                            <input type="number" min="1" name="archive_after_months"
                                   value="<?= esc($config['archive_after_months'] ?? '') ?>"
                                   class="w-full pl-4 pr-16 py-3 border-2 border-gray-100 rounded-xl focus:border-blue-500 focus:ring-0 transition-all text-gray-800 font-semibold text-lg"
                                   required>
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                <span class="text-gray-400 font-medium">Bulan</span>
                            </div>
                        </div>
                        <p class="text-xs text-gray-500">Kapan log aktif dipindah ke tabel arsip.</p>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-gray-700 text-red-600">
                            Batas Penghapusan Permanen
                        </label>
                        <div class="relative group">
                            <input type="number" min="1" name="delete_after_months"
                                   value="<?= esc($config['delete_after_months'] ?? '') ?>"
                                   class="w-full pl-4 pr-16 py-3 border-2 border-red-50 border-gray-100 rounded-xl focus:border-red-500 focus:ring-0 transition-all text-gray-800 font-semibold text-lg"
                                   required>
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                <span class="text-gray-400 font-medium">Bulan</span>
                            </div>
                        </div>
                        <p class="text-xs text-gray-500">Data akan hilang selamanya setelah waktu ini.</p>
                    </div>
                </div>

                <div class="mt-8 p-4 bg-orange-50 border border-orange-100 rounded-xl flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-orange-100 text-orange-600 rounded-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                        </div>
                        <div>
                            <span class="block text-sm font-bold text-gray-900">Backup Otomatis (CSV/SQL)</span>
                            <span class="block text-xs text-gray-600 italic">Sangat disarankan sebelum penghapusan data.</span>
                        </div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="auto_backup" value="1" class="sr-only peer" <?= (!empty($config) && $config['auto_backup']) ? 'checked' : '' ?>>
                        <div class="w-14 h-7 bg-gray-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-green-600"></div>
                    </label>
                </div>

                <div class="mt-10 flex items-center justify-between">
                    <div class="text-sm text-gray-500 flex items-center">
                        <svg class="w-4 h-4 mr-1 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z"></path></svg>
                        Pastikan Cron Job server sudah aktif.
                    </div>
                    <button type="submit" onclick="return confirm('Simpan perubahan jadwal log?')" class="px-8 py-3 bg-blue-900 hover:bg-black text-white font-bold rounded-xl shadow-lg transition-all transform hover:scale-105 active:scale-95 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Perbarui Sistem
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>