<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<style>
    :root {
        --polban-blue: #003366;
        --polban-blue-light: #004a94;
        --polban-gold: #D4AF37;
        --polban-gold-soft: #FCF8E3;
        --slate-soft: #f8fafc;
        --transition-smooth: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Card Styling */
    .archive-card {
        transition: var(--transition-smooth);
        background: white;
        border: 1px solid #eef2f6;
        border-radius: 24px;
        position: relative;
        overflow: hidden;
    }

    .archive-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(0, 51, 102, 0.08);
        border-color: var(--polban-blue);
    }

    .btn-polban {
        transition: var(--transition-smooth);
        background-color: var(--polban-blue);
        color: white;
    }
    
    .btn-polban:hover {
        background-color: var(--polban-blue-light);
    }

    /* Background Icon Decorative */
    .bg-deco {
        position: absolute;
        bottom: -20px;
        right: -20px;
        opacity: 0.03;
        transform: rotate(-15deg);
        transition: var(--transition-smooth);
    }

    .archive-card:hover .bg-deco {
        opacity: 0.07;
        transform: rotate(0deg) scale(1.1);
        color: var(--polban-blue);
    }
</style>

<div class="px-4 py-8 max-w-7xl mx-auto">
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
        <div class="flex items-center gap-5">
            <div class="w-16 h-16 bg-slate-50 border border-slate-100 rounded-2xl flex items-center justify-center shadow-sm text-blue-900">
                <svg class="w-9 h-9" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <h4 class="text-2xl font-black text-blue-900 tracking-tight">
                    Repository <span class="text-slate-400 font-light">|</span> <span class="text-blue-600">Arsip Tervalidasi</span>
                </h4>
                <p class="text-[11px] text-slate-400 font-semibold uppercase tracking-[0.2em] mt-1">
                    Koleksi kategori dokumen yang telah disahkan sistem
                </p>
            </div>
        </div>

        <form method="get" class="mb-0 w-full max-w-md">
            <div class="relative group">
                <input
                    type="text"
                    name="q"
                    value="<?= esc($keyword ?? '') ?>"
                    placeholder="Cari kategori tervalidasi..."
                    class="block w-full pl-5 pr-24 py-3.5 text-sm bg-white border border-slate-200 rounded-2xl
                           focus:ring-4 focus:ring-blue-50 focus:border-blue-600 focus:outline-none
                           transition-all duration-300 shadow-sm"
                >
                <div class="absolute inset-y-1.5 right-1.5 flex gap-1.5">
                    <?php if (!empty($keyword)): ?>
                        <a href="<?= base_url('admin/dokumen-tervalidasi') ?>" 
                           class="flex items-center justify-center px-3 rounded-xl text-slate-400 hover:bg-slate-100 transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                        </a>
                    <?php endif; ?>
                    <button type="submit" class="btn-polban px-5 py-2 rounded-xl text-xs font-bold uppercase tracking-wider">
                        Cari
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-12">
        <div class="bg-blue-900 border border-blue-800 p-5 rounded-3xl shadow-lg shadow-blue-900/20">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[10px] font-bold text-blue-300 uppercase tracking-widest mb-1">Total Kategori</p>
                    <p class="text-3xl font-black text-white"><?= count($kategori) ?></p>
                </div>
                <div class="w-12 h-12 bg-blue-800/50 rounded-2xl flex items-center justify-center text-blue-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php if (empty($kategori)): ?>
            <div class="col-span-full py-20 bg-slate-50 border-2 border-dashed border-slate-200 rounded-[2.5rem] text-center">
                <div class="flex flex-col items-center text-slate-300">
                    <svg class="h-20 w-20 mb-4 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V5a2 2 0 00-2-2H6a2 2 0 00-2 2v8m16 0l-2 5H6l-2-5m16 0H4" /></svg>
                    <h4 class="text-lg font-bold uppercase tracking-widest">Arsip Belum Tersedia</h4>
                </div>
            </div>
        <?php else: ?>
            <?php foreach ($kategori as $k): ?>
                <a href="<?= base_url('admin/dokumen-tervalidasi/' . $k['id']) ?>" class="archive-card group p-7 flex flex-col h-full">
                    <div class="flex justify-between items-start mb-6">
                        <div class="w-14 h-14 bg-slate-50 border border-slate-100 rounded-2xl flex items-center justify-center text-blue-900 group-hover:bg-blue-900 group-hover:text-white transition-all duration-300">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                            </svg>
                        </div>
                        <div class="flex flex-col items-end">
                            <span class="text-[9px] font-black text-slate-300 uppercase tracking-widest mb-1">ID Dokumen</span>
                            <span class="text-xs font-bold text-slate-400">#<?= str_pad($k['id'], 3, '0', STR_PAD_LEFT) ?></span>
                        </div>
                    </div>

                    <div class="flex-grow">
                        <h3 class="text-lg font-black text-blue-900 group-hover:text-blue-600 transition-colors italic leading-snug mb-2 uppercase tracking-tight">
                            <?= esc($k['nama_kategori']) ?>
                        </h3>
                        <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed italic">
                            <?= esc($k['deskripsi'] ?: 'Kategori tervalidasi tanpa keterangan tambahan.') ?>
                        </p>
                    </div>

                    <div class="mt-8 pt-6 border-t border-slate-50 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="flex flex-col">
                                <span class="text-[9px] font-black text-slate-300 uppercase tracking-widest leading-none mb-1 text-left">Penyimpanan</span>
                                <div class="flex items-center gap-1.5">
                                    <span class="text-sm font-black text-slate-700"><?= $k['total'] ?></span>
                                    <span class="text-[10px] font-bold text-slate-400 uppercase">Berkas</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-1 text-blue-900 font-black text-[10px] uppercase tracking-wider opacity-0 group-hover:opacity-100 transition-all transform translate-x-2 group-hover:translate-x-0">
                            Jelajahi
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                        </div>
                    </div>

                    <div class="bg-deco">
                        <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24"><path d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" /></svg>
                    </div>
                </a>
            <?php endforeach ?>
        <?php endif ?>
    </div>
</div>

<?= $this->endSection() ?>