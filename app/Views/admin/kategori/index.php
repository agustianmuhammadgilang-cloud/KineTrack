<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<div class="min-h-screen bg-[#F8FAFC] pb-12">
    <div class="h-2 w-full flex">
        <div class="h-full w-1/2 bg-[#1D2F83]"></div>
        <div class="h-full w-1/2 bg-[#F58025]"></div>
    </div>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        
<div class="container mx-auto px-4 sm:px-6 lg:px-8">
        
    <div class="py-8 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="animate-fade-in-down">
            <nav class="flex items-center gap-2 text-xs font-semibold uppercase tracking-widest text-gray-400 mb-3">
                <span class="hover:text-[#1D2F83] cursor-pointer transition-colors">Dashboard</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7" />
                </svg>
                <span class="text-[#1D2F83]">Kategori Dokumen</span>
            </nav>
            <h1 class="text-4xl font-black text-[#1D2F83] tracking-tight">
                Master <span class="text-[#F58025]">Kategori</span>
            </h1>
            <p class="text-gray-500 mt-1 font-medium italic">Manajemen repositori dokumen kinerja POLBAN.</p>
        </div>
        
        <div class="flex gap-3">
            <!-- Tombol Export -->
            <a href="<?= base_url('admin/kategori-dokumen/export') ?>"
               class="group relative inline-flex items-center justify-center gap-3 bg-[#F58025] hover:bg-orange-600 text-white font-bold px-8 py-4 rounded-2xl shadow-xl shadow-orange-100 transition-all hover:-translate-y-1 active:scale-95 overflow-hidden">
                <div class="absolute inset-0 w-3 bg-white/10 skew-x-[-20deg] group-hover:left-full transition-all duration-700 -left-full"></div>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4" />
                </svg>
                Export Dokumen
            </a>

            <!-- Tombol Buat Wadah -->
            <button onclick="document.getElementById('modal-create').showModal()"
                    class="group relative inline-flex items-center justify-center gap-3 bg-[#1D2F83] hover:bg-[#253a9e] text-white font-bold px-8 py-4 rounded-2xl shadow-xl shadow-blue-100 transition-all hover:-translate-y-1 active:scale-95 overflow-hidden">
                <div class="absolute inset-0 w-3 bg-white/10 skew-x-[-20deg] group-hover:left-full transition-all duration-700 -left-full"></div>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#F58025]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Buat Wadah Baru
            </button>
        </div>
    </div>


        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 text-white">
            <div class="bg-gradient-to-br from-[#1D2F83] to-[#2d46b8] p-6 rounded-3xl shadow-lg border-b-4 border-blue-900">
                <p class="text-blue-200 text-sm font-bold uppercase tracking-wider">Total Kategori</p>
                <h3 class="text-3xl font-black mt-1"><?= count($kategori) ?> <span class="text-sm font-normal text-blue-300">Item</span></h3>
            </div>
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex items-center justify-between group">
                <div>
                    <p class="text-gray-400 text-sm font-bold uppercase tracking-wider">Status Aktif</p>
                    <h3 class="text-3xl font-black mt-1 text-gray-800">
                        <?= count(array_filter($kategori, fn($k) => $k['status'] === 'aktif')) ?>
                    </h3>
                </div>
                <div class="p-4 bg-green-50 rounded-2xl text-green-500 group-hover:rotate-12 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden relative">
            <div class="overflow-x-auto p-4">
                <table class="w-full border-separate border-spacing-y-3">
                    <thead>
                        <tr class="text-left text-gray-400 text-xs font-black uppercase tracking-[0.2em]">
                            <th class="px-6 py-4">ID</th>
                            <th class="px-6 py-4">Detail Wadah</th>
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4 text-right">Opsi Pengelola</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($kategori)): ?>
                        <tr>
                            <td colspan="4" class="py-20 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="p-6 bg-gray-50 rounded-full mb-4 text-gray-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" /></svg>
                                    </div>
                                    <h4 class="text-xl font-bold text-gray-400 tracking-tight">Belum Ada Kategori Terdaftar</h4>
                                    <p class="text-gray-400 text-sm mt-1 px-4">Silakan klik tombol "Buat Wadah Baru" untuk memulai sistem pengarsipan.</p>
                                </div>
                            </td>
                        </tr>
                        <?php endif; ?>

                        <?php foreach ($kategori as $i => $k): ?>
                        <tr class="group bg-white hover:bg-[#F8FAFC] transition-all border border-gray-100">
                            <td class="px-6 py-5 rounded-l-2xl border-y border-l border-gray-50">
                                <span class="bg-gray-100 text-gray-500 text-[10px] font-black px-2 py-1 rounded-md">#<?= $k['id'] ?></span>
                            </td>
                            <td class="px-6 py-5 border-y border-gray-50">
                                <div class="flex items-center gap-4">
                                    <div class="h-12 w-12 rounded-2xl bg-[#1D2F83]/5 flex items-center justify-center text-[#1D2F83] shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" /></svg>
                                    </div>
                                    <div>
                                        <h4 class="text-base font-bold text-gray-800 tracking-tight group-hover:text-[#1D2F83] transition-colors"><?= esc($k['nama_kategori']) ?></h4>
                                        <p class="text-xs text-gray-400 mt-0.5 max-w-xs truncate"><?= esc($k['deskripsi']) ?: 'Tanpa catatan tambahan.' ?></p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5 border-y border-gray-50">
                                <div class="flex justify-center">
                                    <?php if ($k['status'] === 'aktif'): ?>
                                        <span class="px-4 py-1.5 rounded-xl text-[10px] font-black uppercase bg-green-50 text-green-600 border border-green-100 flex items-center gap-2">
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-ping"></span> Aktif
                                        </span>
                                    <?php else: ?>
                                        <span class="px-4 py-1.5 rounded-xl text-[10px] font-black uppercase bg-gray-50 text-gray-400 border border-gray-100">Non-Aktif</span>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td class="px-6 py-5 rounded-r-2xl border-y border-r border-gray-50 text-right">
                                <div class="flex justify-end gap-2">
                                    <button onclick="document.getElementById('modal-edit-<?= $k['id'] ?>').showModal()"
                                            class="h-10 w-10 flex items-center justify-center rounded-xl bg-blue-50 text-blue-600 hover:bg-[#1D2F83] hover:text-white transition-all shadow-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                                    </button>
                                    <a href="<?= base_url('admin/kategori-dokumen/toggle/'.$k['id']) ?>" 
                                       class="h-10 w-10 flex items-center justify-center rounded-xl <?= $k['status']==='aktif' ? 'bg-orange-50 text-[#F58025] hover:bg-[#F58025]' : 'bg-green-50 text-green-600 hover:bg-green-600' ?> hover:text-white transition-all shadow-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" /></svg>
                                    </a>
                                </div>
                            </td>
                        </tr>

                        <dialog id="modal-edit-<?= $k['id'] ?>" class="rounded-3xl shadow-2xl backdrop:bg-[#1D2F83]/40 p-0 overflow-hidden w-full max-w-lg">
                            <div class="bg-white">
                                <div class="h-2 bg-[#F58025]"></div>
                                <div class="p-8">
                                    <h3 class="text-2xl font-black text-[#1D2F83]">Penyesuaian Wadah</h3>
                                    <p class="text-gray-400 text-sm mb-8 italic italic">ID: #<?= $k['id'] ?></p>

                                    <form method="post" action="<?= base_url('admin/kategori-dokumen/update/'.$k['id']) ?>" class="space-y-6">
                                        <?= csrf_field() ?>
                                        <div class="space-y-2">
                                            <label class="text-xs font-black uppercase tracking-widest text-gray-500 ml-1">Nama Kategori</label>
                                            <input type="text" name="nama_kategori" required value="<?= esc($k['nama_kategori']) ?>"
                                                   class="w-full bg-gray-50 border-none rounded-2xl px-5 py-4 focus:ring-2 focus:ring-[#F58025] transition-all font-bold text-gray-700">
                                        </div>
                                        <div class="space-y-2">
                                            <label class="text-xs font-black uppercase tracking-widest text-gray-500 ml-1">Keterangan</label>
                                            <textarea name="deskripsi" rows="4" class="w-full bg-gray-50 border-none rounded-2xl px-5 py-4 focus:ring-2 focus:ring-[#F58025] transition-all text-gray-600"><?= esc($k['deskripsi']) ?></textarea>
                                        </div>
                                        <div class="flex gap-4 pt-4">
                                            <button type="button" onclick="this.closest('dialog').close()" class="flex-1 py-4 font-bold text-gray-400 hover:text-gray-600 transition-colors">Batalkan</button>
                                            <button type="submit" class="flex-[2] bg-[#1D2F83] text-white py-4 rounded-2xl font-black shadow-lg shadow-blue-100 hover:bg-[#2d46b8] transition-all">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </dialog>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<dialog id="modal-create" class="rounded-3xl shadow-2xl backdrop:bg-[#1D2F83]/40 p-0 overflow-hidden w-full max-w-lg animate-fade-in">
    <div class="bg-white">
        <div class="h-2 bg-[#F58025]"></div>
        <div class="p-10">
            <div class="flex items-center gap-4 mb-8">
                <div class="h-14 w-14 bg-orange-50 rounded-2xl flex items-center justify-center text-[#F58025]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <div>
                    <h3 class="text-2xl font-black text-[#1D2F83]">Tambah Kategori</h3>
                    <p class="text-gray-400 text-sm italic">Definisikan wadah dokumen kinerja baru</p>
                </div>
            </div>

            <form method="post" action="<?= base_url('admin/kategori-dokumen/store') ?>" class="space-y-6">
                <?= csrf_field() ?>
                <div class="group">
                    <label class="block text-xs font-black uppercase tracking-widest text-gray-500 mb-2 ml-1 transition-colors group-focus-within:text-[#F58025]">Nama Kategori</label>
                    <input type="text" name="nama_kategori" required placeholder="Misal: Dokumen Penjaminan Mutu"
                           class="w-full bg-gray-50 border-2 border-transparent focus:border-[#F58025] focus:bg-white rounded-2xl px-5 py-4 focus:ring-0 transition-all font-bold text-gray-700">
                </div>
                <div>
                    <label class="block text-xs font-black uppercase tracking-widest text-gray-500 mb-2 ml-1">Deskripsi Singkat</label>
                    <textarea name="deskripsi" rows="4" placeholder="Jelaskan tujuan kategori ini..."
                              class="w-full bg-gray-50 border-2 border-transparent focus:border-[#F58025] focus:bg-white rounded-2xl px-5 py-4 focus:ring-0 transition-all text-gray-600"></textarea>
                </div>
                <div class="flex items-center gap-6 pt-6">
                    <button type="button" onclick="this.closest('dialog').close()" class="text-sm font-bold text-gray-400 hover:text-gray-600">Tutup</button>
                    <button type="submit" class="flex-1 bg-[#F58025] text-white py-4 rounded-2xl font-black shadow-xl shadow-orange-100 hover:bg-orange-600 transition-all hover:-translate-y-1">Resmikan Kategori</button>
                </div>
            </form>
        </div>
    </div>
</dialog>

<style>
    @keyframes fade-in-down {
        0% { opacity: 0; transform: translateY(-10px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-down { animation: fade-in-down 0.5s ease-out; }
    
    dialog::backdrop {
        backdrop-filter: blur(4px);
    }
    
    /* Custom Scrollbar for better UI */
    ::-webkit-scrollbar { width: 8px; }
    ::-webkit-scrollbar-track { background: #f1f1f1; }
    ::-webkit-scrollbar-thumb { background: #1D2F83; border-radius: 10px; }
    ::-webkit-scrollbar-thumb:hover { background: #F58025; }
</style>

<?= $this->endSection() ?>