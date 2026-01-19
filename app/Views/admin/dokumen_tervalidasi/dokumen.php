<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<style>
    :root {
        --polban-blue: #003366;
        --polban-blue-light: #004a94;
        --polban-gold: #D4AF37;
        --polban-gold-soft: #FCF8E3;
        --transition-smooth: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .doc-card {
        transition: var(--transition-smooth);
        border: 1px solid #f1f5f9;
        background: white;
    }

    .doc-card:hover {
        transform: translateX(8px);
        border-color: var(--polban-blue);
        box-shadow: 0 10px 15px -3px rgba(0, 51, 102, 0.05);
    }

    .glass-search {
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.5);
    }

    dialog::backdrop {
        background: rgba(0, 51, 102, 0.3);
        backdrop-filter: blur(4px);
    }
</style>

<div class="px-4 py-8 max-w-7xl mx-auto min-h-screen">
    
    <div class="flex items-center justify-between mb-8">
        <a href="<?= base_url('admin/dokumen-tervalidasi') ?>"
           class="group inline-flex items-center gap-3 text-sm font-bold text-blue-900 hover:text-blue-600 transition-all">
            <div class="p-2.5 rounded-xl bg-white shadow-sm border border-slate-100 group-hover:border-blue-900 group-hover:bg-blue-50 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"/></svg>
            </div>
            Kembali ke Daftar Kategori
        </a>
        <div class="hidden md:block text-[10px] font-black uppercase tracking-[0.2em] text-slate-300 italic">
            Repository System | Secure Archive
        </div>
    </div>

    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
        <div class="flex items-center gap-5">
            <div class="w-16 h-16 bg-blue-900 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-blue-900/20">
                <svg class="w-9 h-9" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
            </div>
            <div>
                <h1 class="text-3xl font-black text-blue-900 tracking-tight italic uppercase"><?= esc($kategori['nama_kategori']) ?></h1>
                <p class="text-sm text-slate-500 font-medium">Manajemen berkas yang telah <span class="text-blue-600 font-bold">Tervalidasi Final</span></p>
            </div>
        </div>
        
        <div class="bg-white px-6 py-4 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
            <div class="text-right">
                <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest leading-none mb-1">Populasi Data</p>
                <p class="text-2xl font-black text-blue-900 leading-none"><?= count($dokumen) ?> <span class="text-[14px] text-slate-400">Berkas</span></p>
            </div>
        </div>
    </div>

    <div class="glass-search sticky top-6 z-20 rounded-2xl shadow-xl shadow-blue-900/5 p-3 mb-10">
        <form method="get" class="flex flex-col md:flex-row gap-3">
            <div class="md:w-1/4">
                <select name="bidang" class="w-full bg-slate-50 border-slate-100 rounded-xl px-4 py-3 text-xs font-bold text-slate-600 focus:ring-2 focus:ring-blue-900 transition-all">
                    <option value="">Semua Unit Kerja</option>
                    <?php foreach ($bidang as $b): ?>
                        <option value="<?= $b['id'] ?>" <?= request()->getGet('bidang') == $b['id'] ? 'selected' : '' ?>>
                            <?= esc($b['nama_bidang']) ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="flex-1 relative group">
                <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-slate-300 group-focus-within:text-blue-900 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                </div>
                <input type="text" name="q" value="<?= esc(request()->getGet('q')) ?>" placeholder="Cari judul dokumen..."
                       class="w-full bg-slate-50 border-slate-100 rounded-xl pl-11 pr-4 py-3 text-xs font-bold focus:ring-2 focus:ring-blue-900 transition-all placeholder:text-slate-300">
            </div>
            <button type="submit" class="bg-blue-900 hover:bg-blue-700 text-white font-black px-8 py-3 rounded-xl transition-all shadow-lg shadow-blue-900/10 uppercase text-[10px] tracking-widest">
                Terapkan
            </button>
            <?php if(request()->getGet('q') || request()->getGet('bidang')): ?>
                <a href="<?= current_url() ?>" class="bg-slate-100 hover:bg-slate-200 text-slate-500 flex items-center justify-center px-4 rounded-xl transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-width="2.5"/></svg>
                </a>
            <?php endif; ?>
        </form>
    </div>

    <div class="grid grid-cols-1 gap-4">
        <?php if (empty($dokumen)): ?>
            <div class="bg-white rounded-[2.5rem] p-20 text-center border-2 border-dashed border-slate-100">
                <div class="text-slate-200 mb-4 opacity-30">
                    <svg class="h-20 w-20 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                </div>
                <p class="text-slate-400 font-bold italic text-lg tracking-tight">Data tidak ditemukan dalam kategori ini</p>
            </div>
        <?php endif ?>

        <?php foreach ($dokumen as $d): ?>
        <div class="doc-card rounded-2xl p-5 group">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                
                <div class="flex items-start gap-5 flex-1">
                    <div class="h-12 w-12 bg-slate-50 group-hover:bg-blue-900 group-hover:text-white rounded-xl flex items-center justify-center text-slate-300 transition-all shrink-0">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                    </div>
                    <div>
                        <div class="flex items-center gap-2 mb-1.5">
                            <span class="text-[9px] font-black text-blue-900 uppercase tracking-widest bg-blue-50 px-2 py-0.5 rounded shadow-sm border border-blue-100">ID: #<?= $d['id'] ?></span>
                            <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Verified</span>
                        </div>
                        <h3 class="text-md font-black text-slate-700 group-hover:text-blue-900 transition-colors italic leading-tight uppercase tracking-tight"><?= esc($d['judul']) ?></h3>
                        
                        <div class="flex flex-wrap items-center gap-x-5 gap-y-1 mt-3">
                            <span class="text-[10px] font-bold text-slate-400 flex items-center gap-1.5 uppercase">
                                <svg class="w-3.5 h-3.5 text-blue-900/30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1" stroke-width="2"/></svg>
                                <?= esc($d['nama_bidang'] ?? '-') ?>
                            </span>
                            <span class="text-[10px] font-bold text-slate-400 flex items-center gap-1.5 uppercase">
                                <svg class="w-3.5 h-3.5 text-blue-900/30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-width="2"/></svg>
                                Validated: <?= date('d M Y', strtotime($d['updated_at'])) ?>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-3 shrink-0">
                    <a href="<?= base_url('uploads/dokumen/' . $d['file_path']) ?>" target="_blank"
                       class="h-10 w-10 flex items-center justify-center rounded-lg bg-slate-50 text-slate-400 hover:bg-blue-900 hover:text-white transition-all group/view">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" stroke-width="2"/></svg>
                    </a>

                    <button onclick="document.getElementById('edit<?= $d['id'] ?>').showModal()"
                            class="flex items-center gap-2 bg-blue-50 text-blue-900 hover:bg-blue-900 hover:text-white font-black px-5 py-2.5 rounded-xl text-[10px] uppercase transition-all shadow-sm">
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" stroke-width="2.5"/></svg>
                        Relokasi
                    </button>
                </div>
            </div>
        </div>

        <dialog id="edit<?= $d['id'] ?>" class="rounded-[2rem] w-full max-w-lg shadow-2xl p-0 overflow-hidden border-none animate-fade-in">
            <div class="bg-white">
                <div class="bg-blue-900 p-8 text-white relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-8 text-blue-400 opacity-10">
                        <svg class="h-24 w-24" fill="currentColor" viewBox="0 0 24 24"><path d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" /></svg>
                    </div>
                    <h3 class="text-xl font-black italic uppercase tracking-tight">Pindahkan Berkas</h3>
                    <p class="text-blue-200 text-[11px] font-bold uppercase tracking-widest mt-1 opacity-80">Relokasi Kategori Dokumen</p>
                </div>
                
                <form method="post" action="<?= base_url('admin/dokumen-tervalidasi/update-kategori/' . $d['id']) ?>" class="p-8">
                    <?= csrf_field() ?>
                    <div class="mb-8">
                        <label class="text-[10px] font-black text-slate-300 uppercase tracking-widest mb-2 block">Judul Dokumen</label>
                        <p class="text-blue-900 font-bold italic text-sm border-l-4 border-blue-900 pl-4 py-1"><?= esc($d['judul']) ?></p>
                    </div>

                    <div class="space-y-3">
                        <label class="text-[10px] font-black uppercase text-slate-500 tracking-widest ml-1">Kategori Destinasi</label>
                        <select name="kategori_id" class="w-full bg-slate-50 border-slate-100 rounded-xl px-5 py-4 focus:ring-2 focus:ring-blue-900 transition-all font-bold text-sm text-slate-700">
                            <?php foreach ($kategoriList as $kl): ?>
                                <option value="<?= $kl['id'] ?>" <?= $kl['id'] == $kategori['id'] ? 'selected' : '' ?>>
                                    FOLDER: <?= esc($kl['nama_kategori']) ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <div class="flex gap-3 mt-10">
                        <button type="button" onclick="this.closest('dialog').close()" class="flex-1 py-3.5 text-xs font-black uppercase text-slate-400 hover:text-slate-600 transition-colors">Batal</button>
                        <button type="submit" class="flex-[2] bg-blue-900 text-white py-3.5 rounded-xl font-black text-xs uppercase tracking-widest shadow-lg shadow-blue-900/20 hover:bg-blue-700 transition-all">Konfirmasi</button>
                    </div>
                </form>
            </div>
        </dialog>
        <?php endforeach ?>
    </div>
</div>

<style>
    @keyframes fade-in {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }
    .animate-fade-in { animation: fade-in 0.3s ease-out; }
</style>

<?= $this->endSection() ?>