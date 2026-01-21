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

    /* Icon Decoration */
    .pic-avatar {
        transition: var(--transition-smooth);
        border: 1.5px solid #e2e8f0;
    }
    
    .row-hover:hover .pic-avatar {
        border-color: var(--polban-blue);
        background-color: white;
    }
</style>

<div class="px-4 py-8 max-w-7xl mx-auto">
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
        <div class="flex items-center gap-5">
            <div class="w-16 h-16 bg-slate-50 border border-slate-100 rounded-2xl flex items-center justify-center shadow-sm">
                <svg class="w-9 h-9 text-blue-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <div>
                <h4 class="text-2xl font-black text-blue-900 tracking-tight">
                    Manajemen <span class="text-slate-400 font-light">|</span> <span class="text-blue-600">Daftar PIC</span>
                </h4>
                <p class="text-[11px] text-slate-400 font-semibold uppercase tracking-[0.2em] mt-1">
                    Pengaturan Penanggung Jawab Indikator
                </p>
            </div>
        </div>
<div>
    <div class="flex-1 max-w-md">
    <form method="get" action="<?= base_url('admin/pic') ?>" class="relative group">
        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
            <svg class="w-4 h-4 text-slate-400 group-focus-within:text-blue-600 transition-colors" 
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </div>

        <input 
            type="text"
            name="q"
            value="<?= esc($keyword ?? '') ?>"
            placeholder="Cari indikator, PIC, atau tahun..."
            class="block w-full pl-10 pr-12 py-2.5 bg-white border border-slate-200 rounded-xl text-xs font-semibold
                   placeholder:text-slate-400 placeholder:font-normal
                   focus:outline-none focus:ring-4 focus:ring-blue-50 focus:border-blue-500 
                   transition-all duration-300 shadow-sm"
        >

        <div class="absolute inset-y-1 right-1 flex items-center gap-1">
            <?php if (!empty($keyword)): ?>
                <a href="<?= base_url('admin/pic') ?>" 
                   class="p-1.5 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors"
                   title="Reset Pencarian">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </a>
            <?php endif; ?>
            
            <button type="submit" 
                    class="p-1.5 bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white rounded-lg transition-all duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>
    </form>
    
    <?php if (!empty($keyword)): ?>
        <p class="absolute mt-1.5 text-[10px] text-slate-400 italic">
            Hasil pencarian untuk: <span class="text-blue-600 font-bold">"<?= esc($keyword) ?>"</span>
        </p>
    <?php endif; ?>
</div>

</div>
        <div class="flex gap-3">
            <a href="<?= base_url('admin/pic/export-excel') ?>" class="btn-polban-action btn-polban-excel">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
        </svg>
        Export Excel
    </a>

            <a href="<?= base_url('admin/pic/export_pdf') ?>" class="btn-polban-action btn-polban-pdf">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
        </svg>
        Export PDF
    </a>
            <a href="<?= base_url('admin/pic/create') ?>" 
               class="btn-add-polban inline-flex items-center gap-2 px-6 py-3 rounded-xl text-xs font-bold uppercase tracking-wider active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah PIC Baru
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
                        <th class="p-5">Informasi Indikator</th>
                        <th class="p-5">Penanggung Jawab (PIC)</th>
                        <th class="p-5">Bidang / Jabatan</th>
                        <th class="p-5 text-center">Tahun</th>
                    </tr>
                </thead>

                <tbody class="text-sm text-slate-600 divide-y divide-slate-100">
                    <?php if (!empty($pic_list)): ?>
                        <?php foreach ($pic_list as $p): ?>
                        <tr class="row-hover group">
                            <td class="p-5">
                                <div class="flex flex-col">
                                    <span class="block font-bold text-slate-800 group-hover:text-blue-900 transition-colors leading-tight mb-1">
                                        <?= esc($p['nama_indikator']) ?>
                                    </span>
                                    <span class="text-[10px] text-slate-400 font-bold tracking-wider">ID: #<?= esc($p['id']) ?></span>
                                </div>
                            </td>
                            <td class="p-5">
                                <div class="flex items-center gap-3">
                                    <div class="pic-avatar w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center shrink-0">
                                        <svg class="w-4 h-4 text-slate-400 group-hover:text-blue-600 transition-colors" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <span class="font-semibold text-slate-700"><?= esc($p['nama_pic']) ?></span>
                                </div>
                            </td>
                            <td class="p-5">
                                <div class="flex flex-col">
                                    <span class="text-xs font-medium text-slate-600"><?= esc($p['nama_bidang']) ?></span>
                                    <span class="text-[10px] text-slate-400 italic"><?= esc($p['nama_jabatan']) ?></span>
                                </div>
                            </td>
                            <td class="p-5 text-center">
                                <span class="px-3 py-1 rounded-lg bg-slate-100 text-slate-600 text-[11px] font-bold">
                                    <?= esc($p['tahun']) ?>
                                </span>
                            </td>
                        </tr>
                        <?php endforeach ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="p-20 text-center">
                                <div class="flex flex-col items-center">
                                    <svg class="w-16 h-16 text-slate-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                    <p class="text-slate-400 font-medium text-base">Data PIC tidak ditemukan.</p>
                                    <p class="text-slate-300 text-xs mt-1">Silakan tambahkan PIC baru melalui tombol di atas.</p>
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
                    Data PIC ini digunakan untuk menentukan alur koordinasi pada sistem <span class="text-blue-900 font-bold">E-Kinerja Polban</span>.
                </p>
            </div>
            <span class="text-[10px] font-bold text-slate-300 uppercase tracking-[0.3em]">Administrator Panel</span>
        </div>
    </div>
</div>

<?= $this->endSection() ?>