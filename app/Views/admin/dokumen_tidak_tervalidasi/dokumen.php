<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<style>
    :root {
        --polban-red: #DC2626; /* Red-600 */
        --polban-amber: #D97706; /* Amber-600 */
        --transition-smooth: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .doc-card {
        transition: var(--transition-smooth);
        border: 1px solid #f1f5f9;
        background: white;
    }

    .doc-card:hover {
        transform: translateX(8px);
        border-color: var(--polban-red);
        box-shadow: 0 10px 15px -3px rgba(220, 38, 38, 0.05);
    }

    .glass-search {
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.5);
    }

    .status-badge {
        font-size: 9px;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 2px 8px;
        border-radius: 6px;
    }
</style>

<div class="px-4 py-8 max-w-7xl mx-auto min-h-screen">
    
    <div class="flex items-center justify-between mb-8">
        <a href="<?= base_url('admin/dokumen-tidak-tervalidasi') ?>"
           class="group inline-flex items-center gap-3 text-sm font-bold text-red-600 hover:text-red-800 transition-all">
            <div class="p-2.5 rounded-xl bg-white shadow-sm border border-slate-100 group-hover:border-red-600 group-hover:bg-red-50 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"/></svg>
            </div>
            Kembali ke Review Kategori
        </a>
        <div class="hidden md:block text-[10px] font-black uppercase tracking-[0.2em] text-slate-300 italic">
            Validation Queue | Pending Review
        </div>
    </div>

    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
        <div class="flex items-center gap-5">
            <div class="w-16 h-16 bg-red-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-red-900/20">
                <svg class="w-9 h-9" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <div>
                <div class="flex items-center gap-3 mb-1">
                    <h1 class="text-3xl font-black text-slate-800 tracking-tight italic uppercase"><?= esc($kategori['nama_kategori']) ?></h1>
                    <span class="status-badge <?= $kategori['status'] === 'pending' ? 'bg-amber-100 text-amber-600' : 'bg-red-100 text-red-600' ?>">
                        <?= $kategori['status'] ?>
                    </span>
                </div>
                <p class="text-sm text-slate-500 font-medium italic">Review berkas sebelum melakukan pengesahan final.</p>
            </div>
        </div>
        
        <div class="bg-white px-6 py-4 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
            <div class="text-right">
                <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest leading-none mb-1">Berkas Menunggu</p>
                <p class="text-2xl font-black text-red-600 leading-none"><?= count($dokumen) ?> <span class="text-[14px] text-slate-400">Item</span></p>
            </div>
        </div>
    </div>

    <div class="glass-search sticky top-6 z-20 rounded-2xl shadow-xl shadow-red-900/5 p-3 mb-10">
        <form method="get" class="flex flex-col md:flex-row gap-3">
            <div class="md:w-1/4">
                <select name="bidang" class="w-full bg-slate-50 border-slate-100 rounded-xl px-4 py-3 text-xs font-bold text-slate-600 focus:ring-2 focus:ring-red-600 transition-all">
                    <option value="">Semua Unit Kerja</option>
                    <?php foreach ($bidang as $b): ?>
                        <option value="<?= $b['id'] ?>" <?= service('request')->getGet('bidang') == $b['id'] ? 'selected' : '' ?>>
                            <?= esc($b['nama_bidang']) ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="flex-1 relative group">
                <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-slate-300 group-focus-within:text-red-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                </div>
                <input type="text" name="q" value="<?= esc(service('request')->getGet('q')) ?>" placeholder="Cari judul dokumen..."
                       class="w-full bg-slate-50 border-slate-100 rounded-xl pl-11 pr-4 py-3 text-xs font-bold focus:ring-2 focus:ring-red-600 transition-all placeholder:text-slate-300">
            </div>
            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-black px-8 py-3 rounded-xl transition-all shadow-lg shadow-red-600/10 uppercase text-[10px] tracking-widest">
                Terapkan
            </button>
            <?php if(service('request')->getGet()): ?>
                <a href="<?= current_url() ?>" class="bg-slate-100 hover:bg-slate-200 text-slate-500 flex items-center justify-center px-4 rounded-xl transition-all" title="Reset">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-width="2.5"/></svg>
                </a>
            <?php endif; ?>
        </form>
    </div>

    <div class="grid grid-cols-1 gap-4">
        <?php if (empty($dokumen)): ?>
            <div class="bg-white rounded-[2.5rem] p-20 text-center border-2 border-dashed border-slate-100">
                <div class="text-slate-200 mb-4 opacity-30">
                    <svg class="h-20 w-20 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 13V5a2 2 0 00-2-2H6a2 2 0 00-2 2v8m16 0l-2 5H6l-2-5m16 0H4"/></svg>
                </div>
                <p class="text-slate-400 font-bold italic text-lg tracking-tight uppercase">Wadah ini masih kosong</p>
            </div>
        <?php endif ?>

        <?php foreach ($dokumen as $d): ?>
        <div class="doc-card rounded-2xl p-5 group">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                
                <div class="flex items-start gap-5 flex-1">
                    <div class="h-12 w-12 bg-slate-50 group-hover:bg-red-600 group-hover:text-white rounded-xl flex items-center justify-center text-slate-300 transition-all shrink-0">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                    </div>
                    <div>
                        <div class="flex items-center gap-2 mb-1.5">
                            <span class="text-[9px] font-black text-red-600 uppercase tracking-widest bg-red-50 px-2 py-0.5 rounded shadow-sm">Review Mode</span>
                            <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">ID: #<?= $d['id'] ?></span>
                        </div>
                        <h3 class="text-md font-black text-slate-700 group-hover:text-red-700 transition-colors italic leading-tight uppercase tracking-tight"><?= esc($d['judul']) ?></h3>
                        
                        <div class="flex flex-wrap items-center gap-x-5 gap-y-1 mt-3">
                            <span class="text-[10px] font-bold text-slate-400 flex items-center gap-1.5 uppercase">
                                <svg class="w-3.5 h-3.5 text-red-400/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1" stroke-width="2"/></svg>
                                <?= esc($d['nama_bidang'] ?? '-') ?>
                            </span>
                            <span class="text-[10px] font-bold text-slate-400 flex items-center gap-1.5 uppercase">
                                <svg class="w-3.5 h-3.5 text-red-400/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2"/></svg>
                                Diajukan: <?= date('d M Y', strtotime($d['updated_at'])) ?>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-3 shrink-0">
                    <a href="<?= base_url('uploads/dokumen/' . $d['file_path']) ?>" target="_blank"
                       class="flex items-center gap-3 bg-white border-2 border-red-600 text-red-600 hover:bg-red-600 hover:text-white font-black px-6 py-2.5 rounded-xl text-[10px] uppercase transition-all shadow-sm group/btn">
                        Pratinjau Berkas
                        <svg class="h-4 w-4 transform group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach ?>
    </div>

    <div class="mt-12 bg-amber-50 rounded-2xl p-6 border border-amber-100 flex items-start gap-4">
        <div class="h-10 w-10 bg-amber-500 rounded-xl flex items-center justify-center text-white shrink-0 shadow-lg shadow-amber-200">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
        </div>
        <div>
            <h4 class="text-xs font-black text-amber-800 uppercase tracking-widest mb-1">Catatan Peninjauan</h4>
            <p class="text-xs text-amber-700 leading-relaxed font-medium italic">Halaman ini hanya untuk <b>verifikasi konten</b>. Untuk mengubah status kategori menjadi VALID atau REJECT secara permanen, silakan gunakan menu <a href="<?= base_url('admin/pengajuan-kategori') ?>" class="font-black underline decoration-2 underline-offset-4 hover:text-amber-900 transition-colors">Pengajuan Kategori</a>.</p>
        </div>
    </div>
</div>

<?= $this->endSection() ?>