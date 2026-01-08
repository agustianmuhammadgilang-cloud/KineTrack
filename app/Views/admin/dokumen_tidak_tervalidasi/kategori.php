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
                <span>Admin</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7" /></svg>
                <span class="text-[#1D2F83]">Dokumen Tidak Tervalidasi</span>
            </nav>
            <h1 class="text-4xl font-black text-[#1D2F83] tracking-tight">
                Dokumen <span class="text-[#F58025]">Tidak Tervalidasi</span>
            </h1>
            <p class="text-gray-500 mt-2 font-medium italic max-w-2xl">
                Daftar kategori yang diajukan staff. Silakan periksa isi dokumen di dalamnya sebelum memberikan validasi final.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php if (empty($kategori)): ?>
                <div class="col-span-full bg-white rounded-[2rem] border-2 border-dashed border-gray-200 p-20 text-center">
                    <div class="flex flex-col items-center">
                        <div class="p-6 bg-gray-50 rounded-full mb-4 text-gray-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                        </div>
                        <h4 class="text-xl font-bold text-gray-400">Semua Terkendali</h4>
                        <p class="text-gray-400 text-sm mt-1">Tidak ada kategori yang menunggu validasi atau ditolak saat ini.</p>
                    </div>
                </div>
            <?php else: ?>
                <?php foreach ($kategori as $k): ?>
                    <div class="group relative bg-white rounded-[2.5rem] p-8 shadow-sm border transition-all hover:shadow-xl hover:-translate-y-2 
                        <?= $k['status'] === 'rejected' ? 'border-red-100 bg-red-50/10' : 'border-gray-100' ?>">
                        
                        <div class="absolute top-6 right-6">
                            <?php if ($k['status'] === 'pending'): ?>
                                <span class="flex items-center gap-1.5 px-4 py-1.5 bg-amber-100 text-amber-700 text-[10px] font-black uppercase rounded-full border border-amber-200 tracking-wider">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span> Pending
                                </span>
                            <?php else: ?>
                                <span class="flex items-center gap-1.5 px-4 py-1.5 bg-red-100 text-red-700 text-[10px] font-black uppercase rounded-full border border-red-200 tracking-wider">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" /></svg>
                                    Rejected
                                </span>
                            <?php endif; ?>
                        </div>

                        <div class="flex flex-col h-full">
                            <div class="h-16 w-16 rounded-3xl mb-6 flex items-center justify-center transition-transform group-hover:rotate-6
                                <?= $k['status'] === 'rejected' ? 'bg-red-100 text-red-500' : 'bg-amber-100 text-amber-500' ?>">
                                <?php if ($k['status'] === 'rejected'): ?>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                <?php else: ?>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                <?php endif; ?>
                            </div>

                            <h3 class="text-xl font-black text-[#1D2F83] mb-2 line-clamp-1 italic"><?= esc($k['nama_kategori']) ?></h3>
                            <p class="text-sm text-gray-500 mb-8 line-clamp-2 flex-grow">
                                <?= esc($k['deskripsi']) ?: 'Tidak ada deskripsi yang diberikan untuk kategori ini.' ?>
                            </p>

                            <div class="flex items-center justify-between mt-auto pt-6 border-t border-gray-100">
                                <div class="flex flex-col">
                                    <span class="text-[10px] font-black text-gray-300 uppercase tracking-widest">Konten</span>
                                    <span class="text-sm font-bold text-gray-700"><?= $k['total'] ?> Dokumen</span>
                                </div>
                                
                                <a href="<?= base_url('admin/dokumen-tidak-tervalidasi/dokumen/' . $k['id']) ?>" 
                                   class="inline-flex items-center gap-2 bg-[#1D2F83] text-white px-5 py-2.5 rounded-2xl text-xs font-bold hover:bg-[#F58025] transition-all shadow-lg shadow-blue-100">
                                    Lihat Detail
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
    @keyframes fade-in-down {
        0% { opacity: 0; transform: translateY(-10px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-down { animation: fade-in-down 0.5s ease-out; }
</style>

<?= $this->endSection() ?>