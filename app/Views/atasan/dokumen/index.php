<?= $this->extend('layout/atasan_template') ?>
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

    /* Table Styling */
    .table-container {
        border-radius: 20px;
        overflow: hidden;
        border: 1px solid #eef2f6;
        background: white;
        box-shadow: 0 10px 25px -5px rgba(0, 51, 102, 0.04);
    }

    .table-header-polban {
        background-color: var(--polban-blue);
        border-bottom: 3px solid var(--polban-gold);
    }

    /* Hover Effect */
    .row-hover {
        transition: var(--transition-smooth);
    }

    .row-hover:hover {
        background-color: var(--slate-soft);
        box-shadow: inset 4px 0 0 0 var(--polban-blue);
    }

    /* Ikon Dokumen */
    .doc-preview {
        transition: var(--transition-smooth);
        border: 1.5px solid #e2e8f0;
    }
    
    .row-hover:hover .doc-preview {
        border-color: var(--polban-blue);
        background-color: white;
        transform: translateY(-2px);
    }

    /* Badge Pending/Menunggu */
    .badge-pending {
        background-color: #fff7ed;
        color: #c2410c;
        border: 1px solid #ffedd5;
        font-weight: 600;
    }

    /* Button Review */
    .btn-review-polban {
        transition: var(--transition-smooth);
        background-color: white;
        color: var(--polban-blue-light);
        border: 1.5px solid var(--polban-blue-light);
    }
    
    .btn-review-polban:hover {
        background-color: var(--polban-blue-light);
        color: white;
        box-shadow: 0 4px 12px rgba(0, 74, 148, 0.15);
    }
</style>

<div class="px-4 py-8 max-w-7xl mx-auto">
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
        <div class="flex items-center gap-5">
            <div class="w-16 h-16 bg-slate-50 border border-slate-100 rounded-2xl flex items-center justify-center shadow-sm">
                <svg class="w-9 h-9 text-blue-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
            </div>
            <div>
                <h4 class="text-2xl font-black text-blue-900 tracking-tight">
                    E-Kinerja <span class="text-slate-400 font-light">|</span> <span class="text-blue-600">Dokumen Masuk</span>
                </h4>
                <p class="text-[11px] text-slate-400 font-semibold uppercase tracking-[0.2em] mt-1">
                    Menunggu Persetujuan Atasan
                </p>
            </div>
        </div>
    </div>

    <div class="table-container">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="table-header-polban text-white uppercase text-[11px] font-bold tracking-widest">
                        <th class="p-5">Judul Dokumen</th>
                        <th class="p-5">Pengirim</th>
                        <th class="p-5">Tanggal Masuk</th>
                        <th class="p-5 text-center">Status</th>
                        <th class="p-5 text-right">Aksi</th>
                    </tr>
                </thead>

                <tbody class="text-sm text-slate-600 divide-y divide-slate-100">
                    <?php if (!empty($dokumen)): ?>
                        <?php foreach ($dokumen as $d): ?>
                        <tr class="row-hover group">
                            <td class="p-5">
                                <div class="flex items-center gap-4">
                                    <div class="doc-preview w-10 h-12 bg-white rounded-lg flex flex-col items-center justify-center relative shrink-0">
                                        <div class="absolute top-0 w-full h-1 bg-blue-600/10"></div>
                                        <svg class="w-6 h-6 text-slate-300 group-hover:text-blue-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="block font-bold text-slate-800 group-hover:text-blue-900 transition-colors leading-tight mb-1"><?= esc($d['judul']) ?></span>
                                        <span class="text-[10px] text-slate-400 font-bold tracking-wider">ID: #<?= esc($d['id']) ?></span>
                                    </div>
                                </div>
                            </td>
                            <td class="p-5">
                                <div class="flex flex-col">
                                    <span class="text-xs font-semibold text-slate-700">Unit <?= esc($d['unit_asal_id']) ?></span>
                                    <span class="text-[10px] text-slate-400 italic">Pengirim Terdaftar</span>
                                </div>
                            </td>
                            <td class="p-5">
                                <span class="text-slate-400 text-xs font-medium"><?= date('d/m/Y', strtotime($d['created_at'])) ?></span>
                            </td>
                            <td class="p-5 text-center">
                                <span class="px-3 py-1 rounded-full text-[10px] badge-pending uppercase tracking-tighter shadow-sm">
                                    Menunggu
                                </span>
                            </td>
                            <td class="p-5 text-right">
                                <a href="<?= base_url('atasan/dokumen/review/'.$d['id']) ?>"
                                   class="btn-review-polban inline-flex items-center gap-2 px-5 py-2 rounded-xl text-[11px] font-bold uppercase tracking-tight active:scale-95">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Review Berkas
                                </a>
                            </td>
                        </tr>
                        <?php endforeach ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="p-20 text-center">
                                <div class="flex flex-col items-center">
                                    <svg class="w-16 h-16 text-slate-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                    </svg>
                                    <p class="text-slate-400 font-medium text-base">Kotak masuk kosong.</p>
                                    <p class="text-slate-300 text-xs mt-1">Belum ada dokumen yang perlu di-review hari ini.</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-8">
        <div class="p-6 rounded-3xl bg-slate-50 border border-slate-100 flex flex-col md:flex-row items-center gap-4 justify-between">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-blue-900 shadow-sm border border-slate-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <p class="text-xs text-slate-500 font-medium">
                    Mohon segera periksa dokumen untuk menjaga kelancaran proses <span class="text-blue-900 font-bold">E-Kinerja Polban</span>.
                </p>
            </div>
            <span class="text-[10px] font-bold text-slate-300 uppercase tracking-[0.3em]">Validation Queue</span>
        </div>
    </div>
</div>

<?= $this->endSection() ?>