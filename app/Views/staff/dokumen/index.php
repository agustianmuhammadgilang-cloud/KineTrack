<?= $this->extend('layout/staff_template') ?>
<?= $this->section('content') ?>

<style>
    :root {
        --polban-blue: #1D2F83;
        --polban-blue-light: #004a94;
        --polban-gold: #F58025;
        --polban-gold-soft: #FCF8E3;
        --slate-soft: #f8fafc;
        --transition-smooth: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Card Styling */
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

    /* Row Styling */
    .document-row {
        transition: var(--transition-smooth);
        border-bottom: 1px solid #f1f5f9;
    }

    .document-row:hover {
        background-color: var(--slate-soft);
        box-shadow: inset 4px 0 0 0 var(--polban-blue);
    }

    /* Button Styling */
    .btn-polban {
        transition: var(--transition-smooth);
        background-color: var(--polban-blue);
        color: white;
    }
    
    .btn-polban:hover {
        background-color: var(--polban-blue-light);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 51, 102, 0.2);
        color: white;
    }

    .input-premium {
        transition: all 0.3s ease;
        border: 1.5px solid #e2e8f0;
    }

    .input-premium:focus {
        border-color: var(--polban-blue);
        box-shadow: 0 0 0 4px rgba(0, 51, 102, 0.05);
        outline: none;
    }
</style>

<div class="px-6 py-8 max-w-7xl mx-auto min-h-screen font-sans">
    
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
        <div class="flex items-center gap-5">
            <div class="w-16 h-16 bg-white border border-slate-100 rounded-2xl flex items-center justify-center shadow-sm">
                <svg class="w-9 h-9 text-blue-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <div>
                <h4 class="text-2xl font-black text-blue-900 tracking-tight">Dokumen Saya</h4>
                <p class="text-[11px] text-slate-400 font-semibold uppercase tracking-[0.2em] mt-1">
                    Arsip Digital Kinerja & Riwayat Verifikasi
                </p>
            </div>
        </div>

        <a href="<?= base_url('staff/dokumen/create') ?>"
           class="btn-polban inline-flex items-center justify-center gap-3 px-7 py-3.5 rounded-2xl font-bold text-xs uppercase tracking-wider">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path d="M12 5v14M5 12h14"/>
            </svg>
            Upload Dokumen Baru
        </a>
    </div>

    <form method="get" class="bg-white p-5 rounded-[2rem] border border-slate-100 shadow-sm mb-10">
        <div class="flex flex-col lg:flex-row items-center gap-4">
            <div class="relative w-full lg:flex-1">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <input type="text" name="q" value="<?= esc($_GET['q'] ?? '') ?>" 
                       placeholder="Cari judul dokumen..."
                       class="input-premium w-full pl-11 pr-4 py-3 rounded-xl text-sm font-medium">
            </div>

            <div class="w-full lg:w-48">
                <input type="date" name="date" value="<?= esc($_GET['date'] ?? '') ?>"
                       class="input-premium w-full px-4 py-3 rounded-xl text-sm font-medium text-slate-600">
            </div>

            <div class="flex items-center gap-2 w-full lg:w-auto">
                <button type="submit"
                        class="flex-1 lg:flex-none btn-polban px-8 py-3 rounded-xl text-xs font-bold uppercase tracking-wider">
                    Filter
                </button>
                
                <?php if (!empty($_GET['q']) || !empty($_GET['date'])): ?>
                    <a href="<?= base_url('staff/dokumen') ?>"
                       class="flex items-center justify-center w-12 h-11 bg-rose-50 text-rose-500 hover:bg-rose-500 hover:text-white rounded-xl transition-all shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </form>

    <div class="unit-card">
        <div class="unit-header-polban flex items-center justify-between">
            <h5 class="text-white text-xs font-bold uppercase tracking-widest flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" stroke-width="2" /></svg>
                Daftar Dokumen Anda
            </h5>
        </div>

        <div class="divide-y divide-slate-50">
            <?php if (empty($dokumen)): ?>
                <div class="p-20 text-center">
                    <p class="text-slate-400 font-bold">Tidak ada dokumen ditemukan.</p>
                </div>
            <?php else: ?>
                <?php foreach ($dokumen as $d): ?>
                    <?php
                    $statusStyles = [
                        'pending_kaprodi'  => ['label' => 'Review Kaprodi', 'class' => 'bg-amber-100 text-amber-700 border-amber-200'],
                        'pending_kajur'    => ['label' => 'Review Kajur',    'class' => 'bg-indigo-100 text-indigo-700 border-indigo-200'],
                        'rejected_kaprodi' => ['label' => 'Revisi Kaprodi',  'class' => 'bg-rose-100 text-rose-700 border-rose-200'],
                        'rejected_kajur'   => ['label' => 'Revisi Kajur',    'class' => 'bg-rose-100 text-rose-700 border-rose-200'],
                        'archived'         => ['label' => 'Tersimpan',       'class' => 'bg-emerald-100 text-emerald-700 border-emerald-200'],
                    ];
                    $style = $statusStyles[$d['status']] ?? ['label' => $d['status'], 'class' => 'bg-slate-100 text-slate-600 border-slate-200'];
                    ?>

                    <div class="document-row p-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-slate-50 flex items-center justify-center shrink-0 border border-slate-100 text-blue-900">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                            </div>
                            <div>
                                <div class="flex items-center gap-3 mb-1">
                                    <span class="font-bold text-slate-800 text-lg"><?= esc($d['judul']) ?></span>
                                    <span class="text-[9px] font-black uppercase px-2 py-0.5 rounded-full border <?= $style['class'] ?>">
                                        <?= $style['label'] ?>
                                    </span>
                                </div>
                                <div class="flex items-center gap-3 text-[10px] text-slate-400 font-bold uppercase tracking-wider">
                                    <span>ID #<?= $d['id'] ?></span>
                                    <span class="w-1.5 h-1.5 bg-slate-200 rounded-full"></span>
                                    <span><?= date('d F Y', strtotime($d['created_at'])) ?></span>
                                </div>
                                <p class="text-xs text-slate-500 mt-2 max-w-2xl italic">
                                    "<?= esc($d['catatan'] ?? 'Belum ada umpan balik.') ?>"
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-3">
                            <?php if (in_array($d['status'], ['rejected_kaprodi', 'rejected_kajur'])): ?>
                                <a href="<?= base_url('staff/dokumen/resubmit/'.$d['id']) ?>"
                                   class="w-32 inline-flex items-center justify-center gap-2 px-4 py-2 rounded-xl bg-rose-50 text-rose-600 border border-rose-100 text-xs font-bold hover:bg-rose-600 hover:text-white transition-all">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    Perbaiki
                                </a>
                            <?php endif ?>
                            
                        </div>
                    </div>
                <?php endforeach ?>
            <?php endif; ?>
        </div>
    </div>

    <div class="mt-10 flex items-center gap-3 opacity-50">
        <div class="w-8 h-8 bg-slate-100 rounded-lg flex items-center justify-center font-black text-slate-400 text-[10px]">KT</div>
        <p class="text-[10px] text-slate-400 font-bold tracking-widest uppercase">
            &copy; <?= date('Y') ?> KINETRACK — POLITEKNIK NEGERI BANDUNG
        </p>
    </div>
</div>

<?= $this->endSection() ?>