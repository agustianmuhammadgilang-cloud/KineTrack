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

    /* Konsistensi Card */
    .unit-card {
        border-radius: 20px;
        overflow: hidden;
        border: 1px solid #eef2f6;
        background: white;
        box-shadow: 0 10px 25px -5px rgba(0, 51, 102, 0.04);
        margin-bottom: 2rem;
    }

    .unit-header-polban {
        background-color: var(--polban-blue);
        border-bottom: 3px solid var(--polban-gold);
        padding: 1rem 1.5rem;
    }

    /* Row Styling agar konsisten */
    .category-row {
        transition: var(--transition-smooth);
        border-bottom: 1px solid #f1f5f9;
    }

    .category-row:hover {
        background-color: var(--slate-soft);
        box-shadow: inset 4px 0 0 0 var(--polban-blue);
    }

    .btn-polban {
        transition: var(--transition-smooth);
        background-color: var(--polban-blue);
        color: white;
    }
    
    .btn-polban:hover {
        background-color: var(--polban-blue-light);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 51, 102, 0.2);
    }

    /* Filter Chips */
    .filter-chip {
        transition: var(--transition-smooth);
        font-size: 0.7rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
</style>

<div class="px-4 py-8 max-w-7xl mx-auto">
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
        <div class="flex items-center gap-5">
            <div class="w-16 h-16 bg-slate-50 border border-slate-100 rounded-2xl flex items-center justify-center shadow-sm text-blue-900">
                <svg class="w-9 h-9" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V5a2 2 0 00-2-2H6a2 2 0 00-2 2v8m16 0l-2 5H6l-2-5m16 0H4" />
                </svg>
            </div>
            <div>
                <h4 class="text-2xl font-black text-blue-900 tracking-tight">
                    Inbox <span class="text-slate-400 font-light">|</span> <span class="text-blue-600">Pengajuan Kategori</span>
                </h4>
                <p class="text-[11px] text-slate-400 font-semibold uppercase tracking-[0.2em] mt-1">
                    Tinjau dan validasi permohonan wadah dokumen dari staff
                </p>
            </div>
        </div>

        <div class="flex bg-white p-1.5 rounded-2xl border border-slate-200 shadow-sm items-center">
            <?php
            $filters = [
                '' => 'Semua',
                'pending' => 'Pending',
                'approved' => 'Disetujui',
                'rejected' => 'Ditolak'
            ];
            foreach ($filters as $key => $label):
                $isActive = ($statusFilter == $key || ($key == '' && !$statusFilter));
            ?>
                <a href="<?= base_url('admin/pengajuan-kategori?status=' . $key) ?>"
                   class="filter-chip px-5 py-2.5 rounded-xl transition-all duration-300
                   <?= $isActive ? 'bg-[#003366] text-white shadow-md' : 'text-slate-500 hover:bg-slate-50' ?>">
                    <?= $label ?>
                </a>
            <?php endforeach ?>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-amber-50 border border-amber-100 p-4 rounded-2xl">
            <p class="text-[10px] font-bold text-amber-600 uppercase tracking-widest">Perlu Tindakan</p>
            <p class="text-2xl font-black text-amber-900">
                <?= count(array_filter($pengajuan, fn($p) => $p['status'] === 'pending')) ?>
            </p>
        </div>
    </div>

    <div class="unit-card">
        <div class="unit-header-polban flex items-center justify-between">
            <h5 class="text-white text-xs font-bold uppercase tracking-widest flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" stroke-width="2" /></svg>
                Antrean Permohonan Kategori Baru
            </h5>
        </div>

        <div class="divide-y divide-slate-50">
            <?php if (empty($pengajuan)): ?>
                <div class="p-20 text-center text-slate-400">
                    <svg class="w-16 h-16 mx-auto mb-4 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M20 13V5a2 2 0 00-2-2H6a2 2 0 00-2 2v8m16 0l-2 5H6l-2-5m16 0H4" stroke-width="1.5" /></svg>
                    <p class="font-bold uppercase tracking-widest text-xs">Tidak ada data pengajuan</p>
                </div>
            <?php endif; ?>

            <?php foreach ($pengajuan as $p): ?>
            <div class="category-row p-6 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="flex items-center gap-5">
                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center shrink-0 border 
                        <?php 
                            if($p['status'] == 'pending') echo 'bg-amber-50 border-amber-100 text-amber-600';
                            elseif(in_array($p['status'], ['approved', 'approved_auto'])) echo 'bg-emerald-50 border-emerald-100 text-emerald-600';
                            else echo 'bg-red-50 border-red-100 text-red-600';
                        ?>">
                        <?php if($p['status'] == 'pending'): ?>
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3" /></svg>
                        <?php elseif(in_array($p['status'], ['approved', 'approved_auto'])): ?>
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        <?php else: ?>
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                        <?php endif; ?>
                    </div>

                    <div>
                        <div class="flex items-center gap-3 mb-1">
                            <span class="font-bold text-slate-800 text-lg italic tracking-tight"><?= esc($p['nama_kategori']) ?></span>
                            <span class="text-[9px] font-black uppercase px-2 py-0.5 rounded-full border 
                                <?php 
                                    if($p['status'] == 'pending') echo 'bg-amber-100 text-amber-700 border-amber-200';
                                    elseif(in_array($p['status'], ['approved', 'approved_auto'])) echo 'bg-blue-100 text-blue-700 border-blue-200';
                                    else echo 'bg-red-100 text-red-700 border-red-200';
                                ?>">
                                <?= ucfirst(str_replace('_', ' ', $p['status'])) ?>
                            </span>
                        </div>
                        <p class="text-xs text-slate-500 max-w-md italic">
                            "<?= esc($p['deskripsi'] ?: 'Tanpa catatan tambahan.') ?>"
                        </p>
                        <p class="text-[10px] text-slate-400 mt-2 font-bold uppercase tracking-tighter">
                            Diajukan pada: <?= date('d M Y', strtotime($p['created_at'] ?? 'now')) ?>
                        </p>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 shrink-0">
                    <?php if ($p['status'] == 'pending'): ?>
                        <a href="<?= base_url('admin/pengajuan-kategori/approve/'.$p['id']) ?>"
                           onclick="return confirm('Apakah Anda yakin menyetujui kategori ini?')"
                           class="w-28 flex items-center justify-center gap-2 bg-emerald-50 hover:bg-emerald-600 text-emerald-600 hover:text-white px-3 py-2.5 rounded-xl text-[10px] font-black transition-all active:scale-95 shadow-sm border border-emerald-100 uppercase tracking-widest">
                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            Setuju
                        </a>

                        <a href="<?= base_url('admin/pengajuan-kategori/reject/'.$p['id']) ?>"
                           onclick="return confirm('Tolak pengajuan kategori ini?')"
                           class="w-28 flex items-center justify-center gap-2 bg-red-50 hover:bg-red-600 text-red-600 hover:text-white px-3 py-2.5 rounded-xl text-[10px] font-black transition-all active:scale-95 shadow-sm border border-red-100 uppercase tracking-widest">
                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                            Tolak
                        </a>
                    <?php else: ?>
                        <div class="flex items-center gap-2 text-slate-300 font-bold text-[10px] uppercase tracking-[0.2em] px-5 py-2.5 italic bg-slate-50/50 rounded-xl border border-slate-100">
                            <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            Selesai Diproses
                        </div>
                    <?php endif ?>
                </div>
            </div>
            <?php endforeach ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>