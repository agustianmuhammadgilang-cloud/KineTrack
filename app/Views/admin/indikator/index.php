<?= $this->extend('layout/admin_template') ?>
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

    /* Animasi Smooth */
    .animate-in {
        animation: fadeIn 0.4s ease-out;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(8px); }
        to { opacity: 1; transform: translateY(0); }
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

    /* Action Buttons Style */
    .btn-action {
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .btn-edit { background-color: #fefce8; color: #a16207; border: 1px solid #fef08a; }
    .btn-edit:hover { background-color: #fef08a; transform: translateY(-1px); }

    .btn-delete { background-color: #fef2f2; color: #991b1b; border: 1px solid #fee2e2; }
    .btn-delete:hover { background-color: #fee2e2; transform: translateY(-1px); }

    .btn-primary-polban {
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

    .btn-primary-polban:hover {
        background-color: #004a94;
        box-shadow: 0 4px 12px rgba(0, 51, 102, 0.2);
    }

    .btn-back {
        color: var(--slate-600);
        font-size: 13px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: var(--transition);
    }

    .btn-back:hover { color: var(--polban-blue); }

    .label-badge {
        font-size: 10px;
        text-transform: uppercase;
        color: var(--polban-gold);
        font-weight: 800;
        display: block;
        margin-bottom: 2px;
    }
</style>

<div class="p-6 max-w-[1600px] mx-auto animate-in">
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-2">
        <div>
            <h2 class="text-2xl font-black text-slate-800 flex items-center gap-3">
                <span class="w-2 h-8 bg-blue-900 rounded-full"></span>
                Indikator Kinerja
            </h2>
            <p class="text-sm text-slate-400 mt-1">Kelola parameter penilaian keberhasilan kinerja</p>
        </div>

        <a href="<?= base_url('admin/indikator/create') ?>" class="btn-primary-polban shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Indikator
        </a>
    </div>

    <div class="report-card">
        <div class="overflow-x-auto">
            <table class="table-report">
                <thead>
                    <tr>
                        <th style="width: 80px;">Kode</th>
                        <th>Indikator Kinerja</th>
                        <th style="width: 100px;">Satuan</th>
                        <th>Sasaran Terkait</th>
                        <th style="width: 100px;">Tahun</th>
                        <th style="width: 200px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($indikator)): ?>
                        <?php foreach($indikator as $i): ?>
                        <tr class="row-hover">
                            <td class="text-center font-bold text-blue-900 bg-slate-50/50">
                                <?= esc($i['kode_indikator']) ?>
                            </td>
                            <td class="font-semibold text-slate-700">
                                <?= esc($i['nama_indikator']) ?>
                            </td>
                            <td class="text-center italic text-slate-500 font-medium">
                                <?= esc($i['satuan']) ?>
                            </td>
                            <td>
                                <span class="label-badge">Sasaran Strategis</span>
                                <span class="text-xs text-slate-600 leading-tight block">
                                    <?= esc($i['nama_sasaran']) ?>
                                </span>
                            </td>
                            <td class="text-center font-bold text-slate-400">
                                <?= esc($i['tahun']) ?>
                            </td>
                            <td class="text-center">
                                <div class="flex justify-center gap-2">
                                    <a href="<?= base_url('admin/indikator/edit/'.$i['id']) ?>" class="btn-action btn-edit">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                        Edit
                                    </a>
                                    <a href="<?= base_url('admin/indikator/delete/'.$i['id']) ?>" 
                                       onclick="return confirm('Apakah Anda yakin ingin menghapus indikator ini?')"
                                       class="btn-action btn-delete">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        Hapus
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="p-20 text-center text-slate-300 font-medium italic">
                                Belum ada data indikator kinerja tersedia.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>