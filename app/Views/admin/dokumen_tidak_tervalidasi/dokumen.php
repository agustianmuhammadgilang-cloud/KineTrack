<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<div class="min-h-screen bg-[#F8FAFC] pb-12">
    <div class="h-2 w-full flex">
        <div class="h-full w-1/2 bg-red-600"></div>
        <div class="h-full w-1/2 bg-amber-500"></div>
    </div>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="py-6 flex items-center justify-between animate-fade-in-down">
            <a href="<?= base_url('admin/dokumen-tidak-tervalidasi') ?>"
               class="group inline-flex items-center gap-3 text-sm font-bold text-red-600 hover:text-red-800 transition-all">
                <div class="p-2 rounded-xl bg-white shadow-sm border border-red-50 group-hover:bg-red-50 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"/></svg>
                </div>
                Kembali ke Review Kategori
            </a>
            <div class="hidden md:block text-[10px] font-black uppercase tracking-[0.2em] text-gray-300 italic">
                Awaiting Admin Validation
            </div>
        </div>

        <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div class="flex-1">
                <div class="flex items-center gap-4 mb-2">
                    <div class="h-14 w-14 rounded-2xl bg-red-50 flex items-center justify-center text-red-600 shadow-inner">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                    </div>
                    <div>
                        <div class="flex items-center gap-3">
                            <h1 class="text-4xl font-black text-gray-800 tracking-tight italic"><?= esc($kategori['nama_kategori']) ?></h1>
                            <span class="px-3 py-1 text-[10px] font-black uppercase rounded-lg border <?= $kategori['status'] === 'pending' ? 'bg-amber-50 text-amber-600 border-amber-100' : 'bg-red-50 text-red-600 border-red-100' ?>">
                                <?= $kategori['status'] ?>
                            </span>
                        </div>
                        <p class="text-gray-500 font-medium italic mt-1 text-sm">Review berkas di dalam kategori ini sebelum melakukan pengesahan di menu Pengajuan.</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white px-6 py-4 rounded-2xl shadow-sm border border-red-50 flex items-center gap-4 shrink-0">
                <div class="text-right">
                    <p class="text-[10px] font-black text-gray-300 uppercase leading-none mb-1 text-right">Berkas Menunggu</p>
                    <p class="text-2xl font-black text-red-600 leading-none"><?= count($dokumen) ?> Item</p>
                </div>
            </div>
        </div>

        <div class="space-y-4">
            <?php if (empty($dokumen)): ?>
                <div class="bg-white rounded-[2.5rem] p-20 text-center border-2 border-dashed border-gray-100">
                    <div class="text-gray-200 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V5a2 2 0 00-2-2H6a2 2 0 00-2 2v8m16 0l-2 5H6l-2-5m16 0H4"/></svg>
                    </div>
                    <p class="text-gray-400 font-bold italic text-xl uppercase tracking-tighter">Wadah ini masih kosong</p>
                </div>
            <?php endif ?>

            <?php foreach ($dokumen as $d): ?>
            <div class="group bg-white rounded-3xl p-6 border border-gray-100 shadow-sm hover:shadow-xl hover:shadow-red-900/5 transition-all duration-300">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                    
                    <div class="flex items-start gap-5 flex-1">
                        <div class="h-14 w-14 bg-red-50 group-hover:bg-red-600 rounded-2xl flex items-center justify-center text-red-400 group-hover:text-white transition-all duration-300 shadow-inner">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                        </div>
                        
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-[10px] font-black text-red-400 uppercase tracking-widest bg-red-50 px-2 py-0.5 rounded-md">REVIEW MODE</span>
                                <span class="text-[10px] font-black text-gray-300 uppercase tracking-widest">ID: #<?= $d['id'] ?></span>
                            </div>
                            <h3 class="text-lg font-black text-gray-800 leading-tight italic group-hover:text-red-700 transition-colors"><?= esc($d['judul']) ?></h3>
                            
                            <div class="flex flex-wrap items-center gap-x-6 gap-y-1 mt-2">
                                <span class="text-xs font-bold text-gray-400 flex items-center gap-1.5 uppercase tracking-tighter">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1" /></svg>
                                    <?= esc($d['nama_bidang'] ?? '-') ?>
                                </span>
                                <span class="text-xs font-bold text-gray-400 flex items-center gap-1.5 uppercase tracking-tighter">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    Diajukan: <?= date('d M Y', strtotime($d['updated_at'])) ?>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="shrink-0">
                        <a href="<?= base_url('uploads/dokumen/' . $d['file_path']) ?>" target="_blank"
                           class="flex items-center gap-3 bg-white border-2 border-red-600 text-red-600 hover:bg-red-600 hover:text-white font-black px-8 py-3 rounded-2xl text-xs uppercase transition-all shadow-sm active:scale-95 group/btn">
                            Pratinjau Berkas
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transform group-hover/btn:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach ?>
        </div>

        <div class="mt-12 bg-amber-50 rounded-[2rem] p-8 border border-amber-100 flex items-start gap-4">
            <div class="h-10 w-10 bg-amber-500 rounded-xl flex items-center justify-center text-white shrink-0 shadow-lg shadow-amber-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
            <div>
                <h4 class="text-sm font-black text-amber-800 uppercase tracking-widest mb-1">Catatan Admin</h4>
                <p class="text-sm text-amber-700 leading-relaxed italic">Halaman ini hanya untuk <b>peninjauan isi dokumen</b>. Untuk menyetujui atau menolak kategori ini secara permanen, silakan menuju menu <a href="<?= base_url('admin/pengajuan-kategori') ?>" class="font-black underline decoration-2 underline-offset-4">Pengajuan Kategori</a>.</p>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes fade-in-down {
        0% { opacity: 0; transform: translateY(-10px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-down { animation: fade-in-down 0.6s ease-out; }
</style>

<?= $this->endSection() ?>