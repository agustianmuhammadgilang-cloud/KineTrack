<?= $this->extend('layout/staff_template') ?>
<?= $this->section('content') ?>

<style>
    :root {
        --polban-blue: #003366;
        --polban-gold: #D4AF37;
        --slate-50: #f8fafc;
        --slate-100: #f1f5f9;
        --slate-200: #e2e8f0;
        --slate-600: #475569;
        --transition: all 0.3s ease;
    }

    /* Card Container */
    .report-card {
        background: white;
        border-radius: 16px;
        border: 1px solid var(--slate-200);
        box-shadow: 0 4px 20px -5px rgba(0, 51, 102, 0.05);
        overflow: hidden;
        margin-top: 1.5rem;
    }

    /* Table Styling */
    .table-report {
        width: 100%;
        border-collapse: collapse;
    }

    .table-report thead th {
        background-color: var(--polban-blue);
        color: white;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-weight: 700;
        padding: 15px;
        border-bottom: 3px solid var(--polban-gold);
        border-right: 1px solid rgba(255, 255, 255, 0.1);
        text-align: center;
    }

    .table-report tbody td {
        padding: 14px 15px;
        font-size: 13px;
        color: var(--slate-600);
        border-bottom: 1px solid var(--slate-200);
        border-right: 1px solid var(--slate-100);
        line-height: 1.5;
    }

    .table-report tbody td:last-child, 
    .table-report thead th:last-child {
        border-right: none;
    }

    .row-hover {
        transition: var(--transition);
    }

    .row-hover:hover {
        background-color: #fbfcfe;
    }

    /* Status Badge */
    .badge-verified {
        background-color: #f0fdf4;
        color: #15803d;
        border: 1px solid #dcfce7;
        padding: 4px 10px;
        border-radius: 99px;
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
    }

    /* Button Styling */
    .btn-pdf {
        background-color: var(--polban-blue);
        color: white;
        padding: 10px 18px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-pdf:hover {
        background-color: #004a94;
        box-shadow: 0 4px 12px rgba(0, 51, 102, 0.2);
    }

    .btn-view-soft {
        background-color: #f0f7ff;
        color: #003366;
        border: 1px solid #e0eefe;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 11px;
        font-weight: 700;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-view-soft:hover {
        background-color: #e0eefe;
        transform: translateY(-1px);
    }
</style>

<div class="p-6 max-w-[1600px] mx-auto">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-2">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center text-blue-900 shadow-sm border border-blue-100">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
            </div>
            <div>
                <h2 class="text-2xl font-black text-slate-800 flex items-center gap-3 leading-none">
                    Arsip Dokumen Saya
                </h2>
                <p class="text-xs text-slate-400 mt-1 font-bold uppercase tracking-widest">Laporan Kinerja yang telah disetujui</p>
            </div>
        </div>

        <a href="<?= base_url('staff/dokumen/export_pdf') ?>" class="btn-pdf">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
            </svg>
            Export PDF Laporan
        </a>
    </div>

    <div class="report-card">
        <div class="overflow-x-auto">
            <table class="table-report">
                <thead>
                    <tr>
                        <th style="width: 50%;">Judul Dokumen</th>
                        <th style="width: 20%;">Tanggal Disetujui</th>
                        <th style="width: 15%;">Status</th>
                        <th style="width: 15%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($dokumen)): ?>
                        <?php foreach ($dokumen as $d): ?>
                        <tr class="row-hover">
                            <td class="p-5">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 bg-slate-50 rounded-lg flex items-center justify-center border border-slate-200 text-slate-400 group-hover:text-blue-900 transition-colors">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="block font-bold text-slate-700 leading-tight"><?= esc($d['judul']) ?></span>
                                        <span class="text-[10px] text-slate-400 font-bold tracking-wider uppercase">ID: #<?= esc($d['id']) ?></span>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center font-medium text-slate-500">
                                <?= date('d M Y', strtotime($d['updated_at'])) ?>
                            </td>
                            <td class="text-center">
                                <span class="badge-verified">Verified</span>
                            </td>
                            <td class="text-center">
                                <a href="<?= base_url('uploads/dokumen/'.$d['file_path']) ?>" target="_blank" class="btn-view-soft">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Buka File
                                </a>
                            </td>
                        </tr>
                        <?php endforeach ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="p-20 text-center text-slate-300 font-medium italic">
                                Belum ada dokumen yang disetujui untuk ditampilkan.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6 p-4 bg-slate-50 rounded-2xl border border-slate-100 flex items-center gap-3">
        <svg class="w-5 h-5 text-blue-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <p class="text-[11px] text-slate-500 font-medium">
            Data ini diambil secara otomatis dari sistem pengukuran yang telah divalidasi oleh Atasan. 
            Silakan gunakan tombol <span class="text-blue-900 font-bold italic">Export</span> untuk mengunduh laporan gabungan.
        </p>
    </div>
</div>

<?= $this->endSection() ?>