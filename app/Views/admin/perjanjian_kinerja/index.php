<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<style>
    :root {
        --polban-blue: #003366;
        --polban-gold: #D4AF37;
        --slate-50: #f8fafc;
        --slate-100: #f1f5f9; /* Untuk border */
        --slate-200: #e2e8f0;
        --slate-600: #475569;
        --transition: all 0.3s ease;
    }

    .report-card {
        background: white;
        border-radius: 16px;
        border: 1px solid var(--slate-200);
        box-shadow: 0 4px 20px -5px rgba(0, 51, 102, 0.05);
        overflow: hidden;
        margin-top: 1.5rem;
    }

    .table-report {
        width: 100%;
        border-collapse: collapse; /* Penting agar border menyatu */
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
        border-right: 1px solid rgba(255, 255, 255, 0.1); /* Garis vertikal tipis di header */
        text-align: center;
    }

    /* Garis pembatas horizontal dan vertikal */
    .table-report tbody td {
        padding: 14px 15px;
        font-size: 13px;
        color: var(--slate-600);
        border-bottom: 1px solid var(--slate-200); /* Garis horizontal */
        border-right: 1px solid var(--slate-100);  /* Garis vertikal */
        line-height: 1.5;
    }

    /* Menghilangkan garis di kolom terakhir */
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

    .text-sasaran {
        font-weight: 700;
        color: var(--polban-blue);
        background-color: #fafbfc; /* Warna beda sedikit untuk sasaran */
    }

    .label-mini {
        font-size: 10px;
        text-transform: uppercase;
        color: var(--polban-gold);
        font-weight: 800;
        display: block;
        margin-bottom: 4px;
    }

    .col-highlight {
        background-color: rgba(212, 175, 55, 0.05); /* Kuning emas transparan */
        font-weight: 700;
        color: var(--polban-blue) !important;
    }

    /* Button Base Styling (Sama dengan menu user) */
    .btn-polban-action {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-size: 0.75rem; /* text-xs */
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        color: white;
        border: none;
        cursor: pointer;
    }

    /* Warna Biru Polban */
    .btn-polban-blue {
        background-color: var(--polban-blue);
    }
    .btn-polban-blue:hover {
        background-color: #004a94;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 51, 102, 0.2);
        color: white;
    }

    /* Warna Hijau Excel */
    .btn-polban-excel {
        background-color: #059669;
    }
    .btn-polban-excel:hover {
        background-color: #047857;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(5, 150, 105, 0.2);
        color: white;
    }

    /* Warna Merah PDF (Outline style agar variatif) */
    .btn-polban-pdf {
        background-color: #ef4444;
    }
    .btn-polban-pdf:hover {
        background-color: #dc2626;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.2);
        color: white;
    }

    /* Efek klik */
    .btn-polban-action:active {
        transform: scale(0.95);
    }
</style>

<div class="p-6 max-w-[1600px] mx-auto">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-black text-slate-800 flex items-center gap-3">
                <span class="w-2 h-8 bg-blue-900 rounded-full"></span>
                Report Perjanjian Kinerja
            </h2>
            <div class="flex items-center gap-2 mt-2">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Tahun Aktif:</span>
                <span class="px-2 py-1 bg-amber-50 text-amber-700 text-xs font-bold rounded border border-amber-100 italic">
                    <?= esc($tahunAktif['tahun']) ?>
                </span>
            </div>
        </div>
        
       <div class="flex gap-3">
    <a href="<?= base_url('admin/perjanjian-kinerja/export-excel') ?>" class="btn-polban-action btn-polban-excel">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
        </svg>
        Export Excel
    </a>

    <a href="<?= base_url('admin/perjanjian-kinerja/export-pdf') ?>" class="btn-polban-action btn-polban-pdf">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
        </svg>
        Export PDF
    </a>
</div>
    </div>

    <div class="report-card">
        <div class="overflow-x-auto">
            <table class="table-report border-all">
                <thead>
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th style="width: 250px;">Sasaran</th>
                        <th style="width: 350px;">Indikator</th>
                        <th style="width: 100px;">Satuan</th>
                        <th style="width: 100px;">Target PK</th>
                        <th>TW1</th>
                        <th>TW2</th>
                        <th>TW3</th>
                        <th>TW4</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($sasaran as $s): ?>
                        <?php
                        $indikatorSasaran = array_filter($indikator, function($i) use ($s) {
                            return $i['sasaran_id'] == $s['id'];
                        });
                        $rowspan = count($indikatorSasaran);
                        $isFirst = true;
                        ?>
                        
                        <?php foreach ($indikatorSasaran as $i): ?>
                        <tr class="row-hover">
                            <?php if ($isFirst): ?>
                                <td class="text-center font-bold text-slate-400" rowspan="<?= $rowspan ?>">
                                    <?= $no++ ?>
                                </td>
                                <td class="text-sasaran" rowspan="<?= $rowspan ?>">
                                    <span class="label-mini">Sasaran Strategis</span>
                                    <?= esc($s['nama_sasaran']) ?>
                                </td>
                            <?php endif; ?>
                            
                            <td class="font-medium">
                                <span class="label-mini text-slate-400">Indikator Kinerja</span>
                                <?= esc($i['nama_indikator']) ?>
                            </td>
                            <td class="text-center italic text-slate-500 font-medium"><?= esc($i['satuan']) ?></td>
                            <td class="text-center col-highlight"><?= esc($i['target_pk']) ?></td>
                            <td class="text-center"><?= esc($i['target_tw1']) ?></td>
                            <td class="text-center"><?= esc($i['target_tw2']) ?></td>
                            <td class="text-center"><?= esc($i['target_tw3']) ?></td>
                            <td class="text-center"><?= esc($i['target_tw4']) ?></td>
                        </tr>
                        <?php $isFirst = false; endforeach; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>