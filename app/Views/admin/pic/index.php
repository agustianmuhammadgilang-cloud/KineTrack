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

        <a href="<?= base_url('admin/pic/export-excel') ?>" 
   class="btn-add-polban inline-flex items-center gap-2 px-6 py-3 rounded-xl text-xs font-bold uppercase tracking-wider"
   style="background:#059669;">
    Export Excel
</a>

            <a href="<?= base_url('admin/pic/export_pdf') ?>" 
   class="btn-add-polban inline-flex items-center gap-2 px-6 py-3 rounded-xl text-xs font-bold uppercase tracking-wider">
   <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
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