<?= $this->extend('layout/atasan_template') ?>
<?= $this->section('content') ?>

<style>
    :root {
        --polban-blue: #003366;
        --polban-blue-light: #004a94;
        --polban-gold: #D4AF37; /* Gold yang lebih modern/deep daripada kuning terang */
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

    /* Hover Effect: Konsisten & Halus */
    .row-hover {
        transition: var(--transition-smooth);
    }

    .row-hover:hover {
        background-color: var(--slate-soft);
        /* Inset shadow agar konten tidak bergeser */
        box-shadow: inset 4px 0 0 0 var(--polban-blue);
    }

    /* Ikon Dokumen Minimalis */
    .doc-preview {
        transition: var(--transition-smooth);
        border: 1.5px solid #e2e8f0;
    }
    
    .row-hover:hover .doc-preview {
        border-color: var(--polban-blue);
        background-color: white;
        transform: translateY(-2px);
    }

    /* Badge Modern */
    .badge-ekinerja {
        background-color: #f0fdf4;
        color: #15803d;
        border: 1px solid #dcfce7;
        font-weight: 600;
    }

    /* Button Download: Tidak terlalu mencolok tapi tetap terlihat */
    .btn-download-polban {
        transition: var(--transition-smooth);
        background-color: white;
        color: var(--polban-blue);
        border: 1.5px solid var(--polban-blue);
    }
    
    .btn-download-polban:hover {
        background-color: var(--polban-blue);
        color: white;
        box-shadow: 0 4px 12px rgba(0, 51, 102, 0.15);
    }
</style>

<div class="px-4 py-8 max-w-7xl mx-auto">
    <di class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
        <div class="flex items-center gap-5">
            <div class="w-16 h-16 bg-slate-50 border border-slate-100 rounded-2xl flex items-center justify-center shadow-sm">
                <svg class="w-9 h-9 text-blue-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
            </div>
            <div>
                <h4 class="text-2xl font-black text-blue-900 tracking-tight">
                    E-Kinerja <span class="text-slate-400 font-light">|</span> <span class="text-yellow-600">Arsip</span>
                </h4>
                <p class="text-[11px] text-slate-400 font-semibold uppercase tracking-[0.2em] mt-1">
                    Politeknik Negeri Bandung
                </p>
            </div>
        </div>

        
    </div>

    <div class="table-container">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="table-header-polban text-white uppercase text-[11px] font-bold tracking-widest">
                        <th class="p-5">Dokumen Kinerja</th>
                        <th class="p-5">Unit Asal</th>
                        <th class="p-5">Tgl Terbit</th>
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
                                        <div class="absolute top-0 w-full h-1 bg-blue-900/10"></div>
                                        <svg class="w-6 h-6 text-slate-300 group-hover:text-blue-900 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="block font-bold text-slate-800 group-hover:text-blue-900 transition-colors leading-tight mb-1"><?= esc($d['judul']) ?></span>
                                        <span class="text-[10px] text-slate-400 font-bold tracking-wider">Ref: #<?= esc($d['id'] ?? 'ARK') ?></span>
                                    </div>
                                </div>
                            </td>
                            <td class="p-5">
                                <span class="text-xs font-semibold text-slate-500 italic">Unit <?= esc($d['unit_asal_id']) ?></span>
                            </td>
                            <td class="p-5">
                                <span class="text-slate-400 text-xs font-medium"><?= date('d/m/Y', strtotime($d['updated_at'])) ?></span>
                            </td>
                            <td class="p-5 text-center">
                                <span class="px-3 py-1 rounded-full text-[10px] badge-ekinerja uppercase tracking-tighter">
                                    Verified
                                </span>
                            </td>
                            <td class="p-5 text-right">
                                <a href="<?= base_url('uploads/dokumen/'.$d['file_path']) ?>" target="_blank"
                                   class="btn-download-polban inline-flex items-center gap-2 px-5 py-2 rounded-xl text-[11px] font-bold uppercase tracking-tight active:scale-95">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    Lihat Dokumen
                                </a>
                            </td>
                        </tr>
                        <?php endforeach ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="p-20 text-center text-slate-300 font-medium">
                                Belum ada arsip dokumen tersedia.
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
                <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-blue-900 shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <p class="text-xs text-slate-500 font-medium">
                    Seluruh dokumen di atas telah melewati proses verifikasi sistem <span class="text-blue-900 font-bold">E-Kinerja Polban</span>.
                </p>
            </div>
            <span class="text-[10px] font-bold text-slate-300 uppercase tracking-[0.3em]">Official Archive System</span>
        </div>
    </div>
</div>

<?= $this->endSection() ?>