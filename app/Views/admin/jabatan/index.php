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

    /* Button Styling */
    .btn-add-polban {
        transition: var(--transition-smooth);
        background-color: var(--polban-blue);
        color: white;
    }
    
    .btn-add-polban:hover {
        background-color: var(--polban-blue-light);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 51, 102, 0.2);
    }

    /* Badge Style for ID/No */
    .no-badge {
        background: #f1f5f9;
        color: #64748b;
        font-weight: 700;
        padding: 2px 8px;
        border-radius: 6px;
        font-size: 11px;
    }
</style>

<div class="px-4 py-8 max-w-7xl mx-auto">
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
        <div class="flex items-center gap-5">
            <div class="w-16 h-16 bg-slate-50 border border-slate-100 rounded-2xl flex items-center justify-center shadow-sm">
                <svg class="w-9 h-9 text-blue-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </div>
            <div>
                <h4 class="text-2xl font-black text-blue-900 tracking-tight">
                    Manajemen <span class="text-slate-400 font-light">|</span> <span class="text-blue-600">Daftar Jabatan</span>
                </h4>
                <p class="text-[11px] text-slate-400 font-semibold uppercase tracking-[0.2em] mt-1">
                    Pengaturan struktur posisi dan hierarki organisasi
                </p>
            </div>
        </div>

        <div>
            <a href="<?= base_url('admin/jabatan/create') ?>" 
               class="btn-add-polban inline-flex items-center gap-2 px-6 py-3 rounded-xl text-xs font-bold uppercase tracking-wider active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Jabatan Baru
            </a>
        </div>
    </div>

    <?php if(session()->getFlashdata('success')): ?>
    <div class="mb-6 flex items-center gap-3 bg-green-50 border border-green-100 text-green-700 px-5 py-4 rounded-2xl shadow-sm">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span class="text-sm font-semibold"><?= session()->getFlashdata('success') ?></span>
    </div>
    <?php endif; ?>

    <div class="table-container">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="table-header-polban text-white uppercase text-[11px] font-bold tracking-widest">
                        <th class="p-5 w-24 text-center">No</th>
                        <th class="p-5">Nama Jabatan</th>
                        <th class="p-5 text-center w-48">Aksi Pengelolaan</th>
                    </tr>
                </thead>

                <tbody class="text-sm text-slate-600 divide-y divide-slate-100">
                    <?php if (!empty($jabatan)): ?>
                        <?php $no=1; foreach ($jabatan as $j): ?>
                        <tr class="row-hover group">
                            <td class="p-5 text-center">
                                <span class="no-badge"><?= $no++ ?></span>
                            </td>
                            <td class="p-5">
                                <div class="flex flex-col">
                                    <span class="block font-bold text-slate-800 group-hover:text-blue-900 transition-colors leading-tight mb-1">
                                        <?= esc($j['nama_jabatan']) ?>
                                    </span>
                                    <span class="text-[10px] text-slate-400 font-bold tracking-wider uppercase">Position Rank: Core</span>
                                </div>
                            </td>
                            <td class="p-5">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="<?= base_url('admin/jabatan/edit/'.$j['id']) ?>" 
                                       class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-blue-50 text-blue-700 text-[11px] font-bold hover:bg-blue-600 hover:text-white transition-all border border-blue-100">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" stroke-width="2" /></svg>
                                        Edit
                                    </a>
                                    
                                    <a href="<?= base_url('admin/jabatan/delete/'.$j['id']) ?>" 
                                       onclick="return confirm('Hapus jabatan ini?')"
                                       class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-red-50 text-red-600 text-[11px] font-bold hover:bg-red-600 hover:text-white transition-all border border-red-100">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-width="2" /></svg>
                                        Hapus
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="p-20 text-center">
                                <div class="flex flex-col items-center">
                                    <svg class="w-16 h-16 text-slate-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    <p class="text-slate-400 font-medium text-base">Data jabatan masih kosong.</p>
                                    <p class="text-slate-300 text-xs mt-1">Klik tombol tambah untuk membuat jabatan baru.</p>
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
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <p class="text-xs text-slate-500 font-medium">
                    Data jabatan ini akan terhubung langsung dengan profil user dan penentuan role pada <span class="text-blue-900 font-bold">E-Kinerja Polban</span>.
                </p>
            </div>
            <span class="text-[10px] font-bold text-slate-300 uppercase tracking-[0.3em]">Administrator Panel</span>
        </div>
    </div>
</div>

<?= $this->endSection() ?>