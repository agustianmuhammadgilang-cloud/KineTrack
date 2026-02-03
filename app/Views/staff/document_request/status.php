<?= $this->extend('layout/staff_template') ?>
<?= $this->section('content') ?>

<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<style>
    :root {
        --polban-blue: #1D2F83;
        --polban-blue-light: #004a94;
        --polban-gold: #D4AF37;
        --slate-soft: #f8fafc;
        --transition-smooth: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Navigasi Aktif dengan Aksen Gold - SAMA DENGAN INDEX */
    .nav-link-active {
        background-color: var(--polban-blue);
        color: white !important;
        box-shadow: 0 10px 20px -5px rgba(29, 47, 131, 0.25);
        border-bottom: 3px solid var(--polban-gold);
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
    }

    .btn-polban:hover {
        background-color: var(--polban-blue-light);
        box-shadow: 0 4px 12px rgba(29, 47, 131, 0.2);
        outline: none;
    }

    .btn-polban:active {
        transform: scale(0.98);
    }

    .status-badge {
        padding: 6px 16px;
        border-radius: 99px;
        font-size: 9px;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        border: 1px solid transparent;
    }

    [x-cloak] { display: none !important; }
</style>

<div class="px-6 py-10 max-w-7xl mx-auto min-h-screen">
    
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-8 mb-12">
        <div class="flex items-center gap-6">
            <div class="w-16 h-16 bg-blue-50 border border-blue-100 rounded-2xl flex items-center justify-center shadow-sm text-blue-900">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <h4 class="text-3xl font-black text-blue-900 tracking-tight">Status <span class="text-blue-600">Pengajuan</span></h4>
                <p class="text-[11px] text-slate-400 font-semibold uppercase tracking-[0.2em] mt-1">Kinetrack — Pantau Riwayat Akses Anda</p>
            </div>
        </div>

       <div class="flex bg-slate-100/50 p-1.5 rounded-2xl border border-slate-200/50 backdrop-blur-sm overflow-x-auto">
    <a href="<?= site_url('document-request') ?>" 
       class="text-slate-500 hover:text-blue-900 px-6 py-3 rounded-xl font-black text-[10px] uppercase tracking-widest transition-all flex items-center gap-2 whitespace-nowrap">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
        </svg>
        Cari Dokumen
    </a>

    <a href="<?= site_url('document-request/incoming') ?>" 
       class="relative text-slate-500 hover:text-blue-900 px-6 py-3 rounded-xl font-black text-[10px] uppercase tracking-widest transition-all flex items-center gap-2 whitespace-nowrap">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
        </svg>
        Permintaan Masuk
        <?php if (!empty($badgeIncoming)): ?>
            <span class="absolute -top-1 -right-1 bg-red-600 text-white text-[9px] font-black px-2 py-0.5 rounded-full shadow-sm">
                <?= $badgeIncoming ?>
            </span>
        <?php endif; ?>
    </a>

    <a href="<?= site_url('document-request/my-status') ?>" 
       class="nav-link-active px-6 py-3 rounded-xl font-black text-[10px] uppercase tracking-widest flex items-center gap-2 whitespace-nowrap relative">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        Status Saya
        <?php if (!empty($badgeStatus)): ?>
            <span class="absolute -top-1 -right-1 bg-red-600 text-white text-[9px] font-black px-2 py-0.5 rounded-full shadow-sm">
                <?= $badgeStatus ?>
            </span>
        <?php endif; ?>
    </a>
</div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
        <?php if (empty($requests)): ?>
            <div class="col-span-full py-32 text-center bg-white rounded-[3rem] border-2 border-dashed border-slate-100">
                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <p class="text-slate-400 font-black uppercase tracking-[0.3em] text-[10px]">Anda Belum Pernah Mengajukan Akses</p>
            </div>
        <?php else: ?>
            <?php foreach ($requests as $req): ?>
            <div class="doc-card p-8 flex flex-col group">
                <div class="flex justify-between items-start mb-6">
                    <div class="w-12 h-12 bg-slate-50 text-slate-400 rounded-2xl flex items-center justify-center border border-slate-100 group-hover:bg-blue-900 group-hover:text-white transition-colors duration-500 shadow-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    </div>

                    <?php if($req['status'] == 'approved'): ?>
                        <span class="status-badge bg-emerald-50 text-emerald-600 border-emerald-100">Disetujui</span>
                    <?php elseif($req['status'] == 'rejected'): ?>
                        <span class="status-badge bg-rose-50 text-rose-600 border-rose-100">Ditolak</span>
                    <?php else: ?>
                        <span class="status-badge bg-amber-50 text-amber-600 border-amber-100">Menunggu</span>
                    <?php endif; ?>
                </div>

                <h6 class="font-black text-blue-900 mb-6 text-lg leading-tight line-clamp-2 min-h-[3.5rem] tracking-tight">
                    <?= esc($req['judul']) ?>
                </h6>

                <div class="space-y-4 pt-6 border-t border-slate-100 mt-auto">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400 border border-slate-200">
                            <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                        </div>
                        <div>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Pemilik Dokumen</p>
                            <p class="text-xs font-bold text-slate-700"><?= esc($req['nama_pemilik']) ?></p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400 border border-slate-200">
                            <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        </div>
                        <div>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Tanggal Pengajuan</p>
                            <p class="text-xs font-bold text-blue-900/70"><?= date('d F Y', strtotime($req['created_at'])) ?></p>
                        </div>
                    </div>

                    <?php if($req['status'] == 'rejected' && $req['note']): ?>
                    <div class="p-4 bg-rose-50 rounded-2xl border border-rose-100 border-l-4 border-l-rose-500 mt-2">
                        <p class="text-[9px] font-black text-rose-900 uppercase mb-1 tracking-widest opacity-60">Alasan Penolakan:</p>
                        <p class="text-[11px] text-rose-900 font-medium italic">"<?= esc($req['note']) ?>"</p>
                    </div>
                    <?php endif; ?>
                </div>

                <div class="mt-8">
                    <?php if($req['status'] == 'approved'): ?>
                        <div class="flex gap-3">
                            <a href="<?= base_url('uploads/dokumen/' . $req['file_path']) ?>" target="_blank" 
                               class="flex-1 py-4 bg-slate-50 text-blue-900 rounded-2xl text-[10px] font-black uppercase tracking-widest text-center hover:bg-slate-100 border border-slate-100 transition-all">
                                Pratinjau
                            </a>
                            <a href="<?= base_url('uploads/dokumen/' . $req['file_path']) ?>" download 
                               class="flex-[1.5] py-4 btn-polban rounded-2xl text-[10px] font-black uppercase tracking-widest text-center shadow-lg shadow-blue-900/10">
                                Unduh
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="flex items-center justify-center gap-3 w-full py-4 bg-slate-100 text-slate-400 rounded-2xl border border-slate-200 opacity-60">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                            <span class="text-[10px] font-black uppercase tracking-[0.2em]">Akses Terkunci</span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <div class="mt-20 text-center pb-10">
        <p class="text-[10px] text-slate-400 font-black uppercase tracking-[0.3em]">
            © <?= date('Y') ?> Kinetrack — Politeknik Negeri Bandung
        </p>
    </div>
</div>

<?= $this->endSection() ?>