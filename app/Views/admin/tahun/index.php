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

    .status-badge {
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        padding: 4px 12px;
        border-radius: 8px;
        letter-spacing: 0.5px;
    }
</style>

<div class="px-4 py-8 max-w-7xl mx-auto">
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
        <div class="flex items-center gap-5">
            <div class="w-16 h-16 bg-slate-50 border border-slate-100 rounded-2xl flex items-center justify-center shadow-sm">
                <svg class="w-9 h-9 text-blue-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
            <div>
                <h4 class="text-2xl font-black text-blue-900 tracking-tight">
                    Tahun <span class="text-slate-400 font-light">|</span> <span class="text-blue-600">Anggaran</span>
                </h4>
                <p class="text-[11px] text-slate-400 font-semibold uppercase tracking-[0.2em] mt-1">
                    Periode Aktif Pengukuran Kinerja Polban
                </p>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <a href="<?= base_url('admin/tahun/create') ?>" 
               class="btn-add-polban inline-flex items-center gap-2 px-6 py-3 rounded-xl text-xs font-bold uppercase tracking-wider active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Tahun
            </a>
        </div>
    </div>

    <div class="table-container">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="table-header-polban text-white uppercase text-[11px] font-bold tracking-widest">
                        <th class="p-5">Periode Tahun</th>
                        <th class="p-5 text-center">Status Operasional</th>
                        <th class="p-5 text-center">Aksi Pengelolaan</th>
                    </tr>
                </thead>

                <tbody class="text-sm text-slate-600 divide-y divide-slate-100">
                    <?php if (!empty($tahun)): ?>
                        <?php foreach($tahun as $t): ?>
                        <tr class="row-hover group">
                            <td class="p-5">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center border border-slate-100 group-hover:bg-white group-hover:border-blue-200 transition-colors">
                                        <span class="text-blue-900 font-black text-sm"><?= substr($t['tahun'], 2, 2) ?></span>
                                    </div>
                                    <span class="font-bold text-slate-800 text-base italic"><?= $t['tahun'] ?></span>
                                </div>
                            </td>
                            <td class="p-5 text-center">
                                <?php if($t['status'] == 'active'): ?>
                                    <span class="status-badge bg-green-50 text-green-600 border border-green-100">
                                        ● Aktif
                                    </span>
                                <?php else: ?>
                                    <span class="status-badge bg-slate-100 text-slate-400 border border-slate-200">
                                        Non-Aktif
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="p-5">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="<?= base_url('admin/tahun/edit/'.$t['id']) ?>" 
                                       class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg bg-blue-50 text-blue-700 text-xs font-bold hover:bg-blue-600 hover:text-white transition-all border border-blue-100 shadow-sm">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" stroke-width="2" /></svg>
                                        Edit
                                    </a>
                                    
                                    <button type="button" 
                                            onclick="confirmDelete('<?= base_url('admin/tahun/delete/'.$t['id']) ?>', '<?= $t['tahun'] ?>')"
                                            class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg bg-red-50 text-red-600 text-xs font-bold hover:bg-red-600 hover:text-white transition-all border border-red-100 shadow-sm">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-width="2" /></svg>
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="p-20 text-center text-slate-400">Belum ada data tahun anggaran.</td>
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
                    Hanya satu periode tahun yang dapat diset sebagai <span class="text-blue-900 font-bold">Aktif</span> untuk proses input kinerja saat ini.
                </p>
            </div>
            <span class="text-[10px] font-bold text-slate-300 uppercase tracking-[0.3em]">Administrator Panel</span>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(url, tahun) {
        Swal.fire({
            title: '<div class="text-2xl font-black text-blue-900 tracking-tight mb-2">Konfirmasi Hapus</div>',
            html: `
                <div class="text-slate-500 text-sm font-medium leading-relaxed">
                    Apakah Anda yakin ingin menghapus periode anggaran <br>
                    <span class="text-blue-600 font-bold">"Tahun ${tahun}"</span>?
                    <p class="text-[10px] text-red-400 mt-3 uppercase tracking-[0.2em] font-bold">Tindakan ini tidak dapat dibatalkan</p>
                </div>
            `,
            icon: 'warning',
            iconColor: '#D4AF37',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus Data',
            cancelButtonText: 'Batalkan',
            reverseButtons: true,
            background: '#ffffff',
            padding: '2.5rem',
            buttonsStyling: false,
            customClass: {
                popup: 'rounded-[30px] border border-slate-100 shadow-2xl',
                confirmButton: 'px-6 py-3 mx-2 rounded-xl text-xs font-bold uppercase tracking-wider bg-red-600 text-white hover:bg-red-700 transition-all active:scale-95',
                cancelButton: 'px-6 py-3 mx-2 rounded-xl text-xs font-bold uppercase tracking-wider bg-slate-100 text-slate-500 hover:bg-slate-200 transition-all active:scale-95'
            },
            showClass: {
                popup: 'animate__animated animate__fadeInUp animate__faster'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOutDown animate__faster'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: '<span class="text-sm font-bold text-slate-500 uppercase tracking-widest">Menghapus Data...</span>',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                        const loader = Swal.getHtmlContainer().querySelector('.swal2-loader');
                        if (loader) loader.style.borderTopColor = '#003366';
                    },
                    showConfirmButton: false,
                    customClass: {
                        popup: 'rounded-[20px]'
                    }
                });
                
                window.location.href = url;
            }
        });
    }
</script>

<?= $this->endSection() ?>