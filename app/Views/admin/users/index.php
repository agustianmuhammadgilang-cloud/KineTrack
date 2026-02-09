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

    /* Container Styling */
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

    /* Hover Effect for User Rows */
    .user-row {
        transition: var(--transition-smooth);
        border-bottom: 1px solid #f1f5f9;
    }

    .user-row:hover {
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
    
    .user-row:hover .avatar-icon {
        border-color: var(--polban-blue);
        background-color: white;
    }
</style>

<div class="px-4 py-8 max-w-7xl mx-auto">
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
        <div class="flex items-center gap-5">
            <div class="w-16 h-16 bg-slate-50 border border-slate-100 rounded-2xl flex items-center justify-center shadow-sm">
                <svg class="w-9 h-9 text-blue-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
            <div>
                <h4 class="text-2xl font-black text-blue-900 tracking-tight">
                    Manajemen <span class="text-slate-400 font-light">|</span> <span class="text-blue-600">Daftar User</span>
                </h4>
                <p class="text-[11px] text-slate-400 font-semibold uppercase tracking-[0.2em] mt-1">
                    Kelola data pengguna berdasarkan unit kerja dan jabatan
                </p>
            </div>
        </div>

<form method="get" class="mb-8 w-full max-w-2xl">
    <div class="group relative flex items-center transition-all duration-300">
        <div class="relative flex-1 group">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="w-5 h-5 text-slate-400 group-focus-within:text-blue-600 transition-colors" 
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 103.5 10.5a7.5 7.5 0 0013.15 6.15z" />
                </svg>
            </div>
            
            <input
                type="text"
                name="q"
                value="<?= esc($keyword ?? '') ?>"
                placeholder="Cari nama, email, jabatan..."
                class="block w-full pl-11 pr-24 py-3.5 text-sm bg-white border border-slate-200 rounded-2xl
                       focus:ring-4 focus:ring-blue-50 focus:border-blue-600 focus:outline-none
                       transition-all duration-300 shadow-sm"
            >

            <div class="absolute inset-y-1.5 right-1.5 flex gap-1.5">
                <?php if (!empty($keyword)): ?>
                    <a href="<?= base_url('admin/users') ?>" 
                       title="Reset pencarian"
                       class="flex items-center justify-center px-3 rounded-xl text-slate-400 hover:bg-slate-100 hover:text-red-500 transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </a>
                <?php endif; ?>
                
                <button type="submit"
                    class="btn-polban px-5 py-2 rounded-xl text-xs font-bold uppercase tracking-wider shadow-md active:scale-95">
                    Cari
                </button>
            </div>
        </div>
    </div>
</form>


        <div class="flex gap-3">
            <div class="flex gap-3">
    <a href="<?= base_url('admin/users/export-excel') ?>" class="btn-polban-action btn-polban-excel">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
        </svg>
        Export Excel
    </a>

    <a href="<?= base_url('admin/users/export-pdf') ?>" class="btn-polban-action btn-polban-pdf">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
        </svg>
        Export PDF
    </a>
            <a href="<?= base_url('admin/users/create') ?>" 
               class="btn-polban inline-flex items-center gap-2 px-6 py-3 rounded-xl text-xs font-bold uppercase tracking-wider active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah User Baru
            </a>
            </div>
        </div>
    </div>

    <?php if(session()->getFlashdata('error')): ?>
    <div class="mb-6 flex items-center gap-3 bg-red-50 border border-red-100 text-red-700 px-5 py-4 rounded-2xl shadow-sm">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span class="text-sm font-semibold"><?= session()->getFlashdata('error') ?></span>
    </div>
    <?php endif; ?>

    <?php
$groupedUsers = [];
foreach ($users as $u) {

    if ($u['role'] === 'admin') {
        $unit = 'ADMINISTRATOR';

    } elseif ($u['role'] === 'pimpinan') {
        $unit = 'PIMPINAN';

    } else {
        $unit = $u['nama_bidang'] ?? 'Tanpa Unit Kerja';
    }

    $groupedUsers[$unit][] = $u;
}

?>

    <div class="space-y-8">
        <?php foreach ($groupedUsers as $unitName => $unitUsers): ?>
        <div class="unit-card">
            <div class="unit-header-polban flex items-center justify-between">
                <h5 class="text-white text-xs font-bold uppercase tracking-widest flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" stroke-width="2" /></svg>
                    <?= esc($unitName) ?>
                </h5>
                <span class="bg-white/20 text-white text-[10px] px-2 py-1 rounded-md"><?= count($unitUsers) ?> Personil</span>
            </div>

            <div class="divide-y divide-slate-50">
                <?php foreach ($unitUsers as $u): ?>
                <div class="user-row p-5 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="avatar-icon w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-slate-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" />
                            </svg>
                        </div>
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <span class="font-bold text-slate-800"><?= esc($u['nama']) ?></span>
                            <?php if ($u['role'] === 'admin'): ?>
    <span class="text-[9px] bg-purple-100 text-purple-700 font-black uppercase px-2 py-0.5 rounded-full border border-purple-200">
        Admin
    </span>

<?php elseif ($u['role'] === 'pimpinan'): ?>
    <span class="text-[9px] bg-indigo-100 text-indigo-700 font-black uppercase px-2 py-0.5 rounded-full border border-indigo-200">
        Pimpinan
    </span>

<?php elseif ($u['role'] === 'atasan'): ?>
    <span class="text-[9px] bg-amber-100 text-amber-700 font-black uppercase px-2 py-0.5 rounded-full border border-amber-200">
        Atasan
    </span>

<?php else: ?>
    <span class="text-[9px] bg-slate-100 text-slate-500 font-black uppercase px-2 py-0.5 rounded-full border border-slate-200">
        Staff
    </span>
<?php endif; ?>

                            </div>
                            <p class="text-xs text-slate-500"><?= esc($u['nama_jabatan']) ?> <span class="mx-1 text-slate-300">•</span> <?= esc($u['email']) ?></p>
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        <?php if ($u['role'] !== 'admin'): ?>
                        <a href="<?= base_url('admin/users/edit/'.$u['id']) ?>" 
                           class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg bg-blue-50 text-blue-700 text-xs font-bold hover:bg-blue-600 hover:text-white transition-all shadow-sm border border-blue-100">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" stroke-width="2" /></svg>
                            Edit
                        </a>
                        
<form id="delete-form-<?= $u['id'] ?>" action="<?= base_url('admin/users/delete/'.$u['id']) ?>" method="post">
    <?= csrf_field() ?>
    <button type="button" 
            onclick="confirmDeleteUser('<?= $u['id'] ?>', '<?= esc($u['nama']) ?>')"
            class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg bg-red-50 text-red-600 text-xs font-bold hover:bg-red-600 hover:text-white transition-all shadow-sm border border-red-100 active:scale-95">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-width="2" />
        </svg>
        Hapus
    </button>
</form>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <div class="mt-8">
        <div class="p-6 rounded-3xl bg-slate-50 border border-slate-100 flex flex-col md:flex-row items-center gap-4 justify-between">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-blue-900 shadow-sm border border-slate-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <p class="text-xs text-slate-500 font-medium">
                    Manajemen user memungkinkan pembagian akses berdasarkan unit kerja untuk sistem <span class="text-blue-900 font-bold">E-Kinerja Polban</span>.
                </p>
            </div>
            <span class="text-[10px] font-bold text-slate-300 uppercase tracking-[0.3em]">Administrator Panel</span>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function confirmDeleteUser(userId, userName) {
        Swal.fire({
            title: '<div class="text-2xl font-black text-blue-900 tracking-tight mb-2">Hapus Pengguna</div>',
            html: `
                <div class="text-slate-500 text-sm font-medium leading-relaxed">
                    Anda akan menghapus akun: <br>
                    <span class="text-blue-600 font-bold">"${userName}"</span>
                    <p class="text-[10px] text-red-400 mt-4 uppercase tracking-[0.2em] font-bold italic border-t border-slate-100 pt-3">
                        Akses pengguna ini ke sistem akan dicabut permanen
                    </p>
                </div>
            `,
            icon: 'warning',
            iconColor: '#D4AF37',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus User',
            cancelButtonText: 'Batalkan',
            reverseButtons: true,
            buttonsStyling: false,
            customClass: {
                popup: 'rounded-[30px] border border-slate-100 shadow-2xl',
                confirmButton: 'px-6 py-3 mx-2 rounded-xl text-xs font-bold uppercase tracking-wider bg-red-600 text-white hover:bg-red-700 transition-all active:scale-95',
                cancelButton: 'px-6 py-3 mx-2 rounded-xl text-xs font-bold uppercase tracking-wider bg-slate-100 text-slate-500 hover:bg-slate-200 transition-all active:scale-95'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Tampilkan loading saat proses penghapusan
                Swal.fire({
                    title: '<span class="text-sm font-bold text-slate-500 uppercase tracking-widest">Menghapus Akun...</span>',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                        const loader = Swal.getHtmlContainer().querySelector('.swal2-loader');
                        if (loader) loader.style.borderTopColor = '#003366';
                    },
                    showConfirmButton: false,
                    customClass: { popup: 'rounded-[20px]' }
                });
                
                // Submit form secara manual
                document.getElementById('delete-form-' + userId).submit();
            }
        });
    }

    // Penanganan Notifikasi Flashdata (Success & Error)
</script>


<?= $this->endSection() ?>