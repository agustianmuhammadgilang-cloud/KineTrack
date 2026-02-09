<?= $this->extend('layout/pimpinan_template') ?>
<?= $this->section('content') ?>

<style>
    :root {
        --polban-blue: #003366;
        --polban-blue-light: #004a94;
        --polban-gold: #D4AF37;
        --slate-soft: #f8fafc;
        --transition-smooth: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .doc-card {
        background: white;
        border-radius: 32px;
        border: 1px solid #eef2f6;
        transition: var(--transition-smooth);
        box-shadow: 0 10px 30px -12px rgba(0, 51, 102, 0.05);
    }

    .doc-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 50px -12px rgba(0, 51, 102, 0.12);
        border-color: rgba(29, 47, 131, 0.1);
    }

    .btn-polban {
        transition: all 0.25s ease-out;
        background: var(--polban-blue);
        color: white !important;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-polban:hover {
        background-color: var(--polban-blue-light);
        box-shadow: 0 4px 12px rgba(29, 47, 131, 0.2);
    }

    .btn-outline-polban {
        border: 2px solid var(--polban-blue);
        color: var(--polban-blue) !important;
        transition: all 0.25s ease-out;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-outline-polban:hover {
        background: rgba(29, 47, 131, 0.05);
    }

    .input-premium {
        transition: var(--transition-smooth);
        border: 1.5px solid #e2e8f0;
        background-color: #f8fafc;
    }

    .input-premium:focus {
        background-color: white;
        border-color: var(--polban-blue);
        box-shadow: 0 0 0 4px rgba(29, 47, 131, 0.05);
        outline: none;
    }
</style>

<div class="px-6 py-10 max-w-7xl mx-auto min-h-screen">

    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-8 mb-12">
        <div class="flex items-center gap-6">
            <div class="w-16 h-16 bg-blue-50 border border-blue-100 rounded-2xl flex items-center justify-center shadow-sm text-blue-900">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <div>
                <h4 class="text-3xl font-black text-blue-900 tracking-tight">Monitoring <span class="text-blue-600">Dokumen</span></h4>
                <p class="text-[11px] text-slate-400 font-semibold uppercase tracking-[0.2em] mt-1">Kinetrack — Panel Eksklusif Pimpinan</p>
            </div>
        </div>
    </div>

    <section>
        <form method="get" class="max-w-3xl mb-14 relative group">
            <input type="text" name="search" placeholder="Cari judul, pemilik, atau unit..." 
                class="input-premium w-full pl-16 pr-44 py-5 rounded-[2rem] shadow-sm text-blue-900 font-medium"
                value="<?= esc($search ?? '') ?>">
            
            <div class="absolute left-6 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-blue-900 transition-colors duration-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                </svg>
            </div>

            <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 btn-polban px-7 py-3 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em]">
                Cari Data
            </button>
        </form>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
            <?php if (empty($documents)): ?>
                <div class="col-span-full py-32 text-center bg-white rounded-[3rem] border-2 border-dashed border-slate-100">
                    <p class="text-slate-400 font-black uppercase tracking-[0.3em] text-[10px]">Belum ada dokumen yang diunggah</p>
                </div>
            <?php else: ?>
                <?php foreach ($documents as $doc): ?>
                    <div class="doc-card p-8 flex flex-col relative overflow-hidden group">
                        <div class="absolute top-0 right-0">
                            <div class="bg-blue-50 text-blue-700 text-[8px] font-black px-4 py-1.5 rounded-bl-2xl uppercase tracking-widest border-l border-b border-blue-100">
                                <?= esc($doc['scope']) ?>
                            </div>
                        </div>

                        <div class="w-14 h-14 bg-blue-50 text-blue-900 rounded-2xl flex items-center justify-center border border-blue-100 mb-6 group-hover:bg-blue-900 group-hover:text-white transition-colors duration-500 shadow-sm">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        </div>
                        
                        <h6 class="font-black text-blue-900 mb-6 text-lg leading-tight line-clamp-2 min-h-[3.5rem] tracking-tight">
                            <?= esc($doc['judul']) ?>
                        </h6>

                        <div class="space-y-4 pt-6 border-t border-slate-100 mt-auto">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center text-slate-400 border border-slate-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                </div>
                                <div>
                                    <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest">Pemilik</p>
                                    <p class="text-xs font-bold text-slate-700"><?= esc($doc['nama_pemilik']) ?></p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center text-slate-400 border border-slate-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                                </div>
                                <div>
                                    <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest">Unit</p>
                                    <p class="text-xs font-bold text-slate-700"><?= esc($doc['nama_unit'] ?? 'N/A') ?></p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 grid grid-cols-2 gap-3">
<a href="<?= base_url('pimpinan/dokumen/view/' . $doc['file_path']) ?>" target="_blank"
   class="btn-outline-polban py-3 rounded-2xl text-[9px] font-black uppercase tracking-wider flex items-center gap-2">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
    </svg>
    Pratinjau
</a>

<a href="<?= base_url('pimpinan/dokumen/download/' . $doc['file_path']) ?>" 
   class="btn-polban py-3 rounded-2xl text-[9px] font-black uppercase tracking-wider shadow-lg shadow-blue-900/10 flex items-center gap-2">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
    </svg>
    Unduh
</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>

    <div class="mt-20 text-center pb-10">
        <p class="text-[10px] text-slate-400 font-black uppercase tracking-[0.3em]">
            © <?= date('Y') ?> Kinetrack — Politeknik Negeri Bandung
        </p>
    </div>
</div>

<?= $this->endSection() ?>