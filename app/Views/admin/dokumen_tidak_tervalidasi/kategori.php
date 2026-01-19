<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<style>
    :root {
        --polban-blue: #003366;
        --polban-blue-light: #004a94;
        --polban-gold: #D4AF37;
        --polban-gold-soft: #FCF8E3;
        --polban-amber: #f59e0b;
        --polban-red: #ef4444;
        --transition-smooth: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .review-card {
        transition: var(--transition-smooth);
        background: white;
        border-radius: 24px;
        border: 1px solid #f1f5f9;
        position: relative;
    }

    .review-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05);
    }

    /* Status Badge Styling */
    .status-badge {
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 4px 12px;
        border-radius: 99px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-action {
        background-color: var(--polban-blue);
        transition: var(--transition-smooth);
    }

    .btn-action:hover {
        background-color: var(--polban-gold);
        transform: scale(1.02);
    }
</style>

<div class="px-4 py-8 max-w-7xl mx-auto">
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
        <div class="flex items-center gap-5">
            <div class="w-16 h-16 bg-white border border-slate-100 rounded-2xl flex items-center justify-center shadow-sm text-amber-500">
                <svg class="w-9 h-9" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <div>
                <nav class="flex items-center gap-2 text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mb-1">
                    <span>Admin</span>
                    <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-width="3"/></svg>
                    <span class="text-blue-900">Validation Queue</span>
                </nav>
                <h1 class="text-3xl font-black text-blue-900 tracking-tight">
                    Antrean <span class="text-blue-600">Validasi</span>
                </h1>
                <p class="text-sm text-slate-500 italic font-medium">Tinjau dan verifikasi dokumen yang diajukan oleh staff.</p>
            </div>
        </div>

        <form method="get" class="mb-0 w-full max-w-md">
    <div class="relative group">
        <input
            type="text"
            name="q"
            value="<?= esc($keyword ?? '') ?>"
            placeholder="Cari kategori pending/rejected..."
            class="block w-full pl-5 pr-24 py-3.5 text-sm bg-white border border-slate-200 rounded-2xl
                   focus:ring-4 focus:ring-blue-50 focus:border-blue-600 focus:outline-none
                   transition-all duration-300 shadow-sm"
        >
        <div class="absolute inset-y-1.5 right-1.5 flex gap-1.5">
            <?php if (!empty($keyword)): ?>
                <a href="<?= base_url('admin/dokumen-tidak-tervalidasi') ?>" 
                   class="flex items-center justify-center px-3 rounded-xl text-slate-400 hover:bg-slate-100 hover:text-red-500 transition-all"
                   title="Reset Pencarian">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </a>
            <?php endif; ?>
            
            <button type="submit" class="bg-blue-900 text-white px-5 py-2 rounded-xl text-xs font-bold uppercase tracking-wider hover:bg-blue-700 transition-colors">
                Cari
            </button>
        </div>
    </div>
</form>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php if (empty($kategori)): ?>
            <div class="col-span-full py-24 bg-white border-2 border-dashed border-slate-100 rounded-[3rem] text-center">
                <div class="flex flex-col items-center">
                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center text-slate-200 mb-4">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7" /></svg>
                    </div>
                    <h4 class="text-xl font-bold text-slate-400">Semua Terkendali</h4>
                    <p class="text-slate-400 text-sm italic">Tidak ada kategori yang menunggu validasi saat ini.</p>
                </div>
            </div>
        <?php else: ?>
            <?php foreach ($kategori as $k): ?>
                <div class="review-card p-7 flex flex-col h-full border-l-4 <?= $k['status'] === 'rejected' ? 'border-l-red-500' : 'border-l-amber-500' ?>">
                    
                    <div class="flex justify-between items-start mb-6">
                        <?php if ($k['status'] === 'pending'): ?>
                            <span class="status-badge bg-amber-50 text-amber-700 border border-amber-100">
                                <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span> Pending Review
                            </span>
                        <?php else: ?>
                            <span class="status-badge bg-red-50 text-red-700 border border-red-100">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" /></svg> Rejected
                            </span>
                        <?php endif; ?>

                        <span class="text-[10px] font-black text-slate-300 uppercase tracking-widest">#<?= str_pad($k['id'], 3, '0', STR_PAD_LEFT) ?></span>
                    </div>

                    <div class="flex-grow">
                        <h3 class="text-lg font-black text-blue-900 mb-2 italic uppercase tracking-tight group-hover:text-blue-600 transition-colors">
                            <?= esc($k['nama_kategori']) ?>
                        </h3>
                        <p class="text-xs text-slate-500 leading-relaxed italic line-clamp-2">
                            <?= esc($k['deskripsi'] ?: 'Staff tidak memberikan deskripsi tambahan untuk kategori ini.') ?>
                        </p>
                    </div>

                    <div class="mt-8 pt-6 border-t border-slate-50 flex items-center justify-between">
                        <div class="flex flex-col">
                            <span class="text-[9px] font-black text-slate-300 uppercase tracking-widest leading-none mb-1">Total Item</span>
                            <div class="flex items-center gap-1.5">
                                <span class="text-sm font-black text-slate-700"><?= $k['total'] ?></span>
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">Dokumen</span>
                            </div>
                        </div>

                        <a href="<?= base_url('admin/dokumen-tidak-tervalidasi/dokumen/' . $k['id']) ?>" 
                           class="btn-action inline-flex items-center gap-2 text-white px-5 py-2.5 rounded-xl text-[11px] font-bold uppercase tracking-wider shadow-md">
                            Periksa
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" /></svg>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>