<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<div class="min-h-screen bg-[#F8FAFC] pb-12">
    <div class="h-2 w-full flex">
        <div class="h-full w-1/2 bg-[#1D2F83]"></div>
        <div class="h-full w-1/2 bg-[#F58025]"></div>
    </div>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="py-8 animate-fade-in-down">
            <nav class="flex items-center gap-2 text-xs font-semibold uppercase tracking-widest text-gray-400 mb-3">
                <span class="hover:text-[#1D2F83] cursor-pointer transition-colors">Admin</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7" /></svg>
                <span class="text-[#1D2F83]">Dokumen Tervalidasi</span>
            </nav>
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-4xl font-black text-[#1D2F83] tracking-tight">
                        Arsip <span class="text-[#F58025]">Tervalidasi</span>
                    </h1>
                    <p class="text-gray-500 mt-1 font-medium italic">Repositori kategori dokumen yang telah disahkan oleh sistem.</p>
                </div>
                
                <div class="bg-blue-50 border border-blue-100 px-4 py-2 rounded-2xl flex items-center gap-3">
                    <div class="p-2 bg-[#1D2F83] rounded-lg text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-blue-400 uppercase tracking-tighter leading-none">Total Kategori</p>
                        <p class="text-lg font-black text-[#1D2F83] leading-none"><?= count($kategori) ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php if (empty($kategori)): ?>
                <div class="col-span-full bg-white rounded-[2.5rem] border-2 border-dashed border-gray-100 p-20 text-center">
                    <div class="flex flex-col items-center text-gray-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                        </svg>
                        <h4 class="text-xl font-bold">Belum Ada Arsip</h4>
                        <p class="text-sm">Kategori yang tervalidasi akan muncul di sini.</p>
                    </div>
                </div>
            <?php else: ?>
                <?php foreach ($kategori as $k): ?>
                    <a href="<?= base_url('admin/dokumen-tervalidasi/' . $k['id']) ?>"
                       class="group relative bg-white rounded-[2.5rem] p-8 shadow-sm border border-gray-100 transition-all hover:shadow-2xl hover:shadow-blue-900/5 hover:-translate-y-2 overflow-hidden flex flex-col h-full">
                        
                        <div class="absolute top-0 inset-x-0 h-1.5 bg-gradient-to-r from-[#1D2F83] to-[#F58025] transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"></div>

                        <div class="flex justify-between items-start mb-6">
                            <div class="h-16 w-16 rounded-3xl bg-blue-50 flex items-center justify-center text-[#1D2F83] group-hover:bg-[#1D2F83] group-hover:text-white transition-all duration-300 shadow-inner">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                                </svg>
                            </div>
                            <span class="text-[10px] font-black text-gray-300 group-hover:text-gray-400 tracking-widest transition-colors uppercase">
                                ID: #<?= $k['id'] ?>
                            </span>
                        </div>

                        <div class="flex-grow">
                            <h2 class="text-xl font-black text-[#1D2F83] group-hover:text-[#F58025] transition-colors italic leading-tight mb-2">
                                <?= esc($k['nama_kategori']) ?>
                            </h2>
                            <p class="text-sm text-gray-500 line-clamp-2 italic group-hover:text-gray-600">
                                <?= esc($k['deskripsi']) ?: 'Kategori dokumen tervalidasi tanpa keterangan tambahan.' ?>
                            </p>
                        </div>

                        <div class="mt-8 pt-6 border-t border-gray-50 flex items-center justify-between">
                            <div class="flex flex-col">
                                <span class="text-[10px] font-black text-gray-300 uppercase tracking-widest">Kapasitas</span>
                                <span class="text-sm font-bold text-gray-700"><?= $k['total'] ?> Berkas</span>
                            </div>
                            
                            <div class="flex items-center gap-2 text-[#F58025] font-black text-xs uppercase tracking-tighter opacity-0 group-hover:opacity-100 transition-all transform translate-x-4 group-hover:translate-x-0">
                                Buka Folder
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </div>
                        </div>

                        <div class="absolute -bottom-6 -right-6 text-gray-50 group-hover:text-blue-50/50 transition-colors pointer-events-none">
                             <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                            </svg>
                        </div>
                    </a>
                <?php endforeach ?>
            <?php endif ?>
        </div>
    </div>
</div>

<style>
    @keyframes fade-in-down {
        0% { opacity: 0; transform: translateY(-10px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-down { animation: fade-in-down 0.6s cubic-bezier(0.16, 1, 0.3, 1); }
</style>

<?= $this->endSection() ?>