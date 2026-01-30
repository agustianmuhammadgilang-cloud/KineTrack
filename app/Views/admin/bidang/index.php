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

    /* Row Styling */
    .row-jurusan {
        background-color: #f8fafc;
        border-left: 4px solid var(--polban-gold);
    }

    .row-prodi {
        transition: var(--transition-smooth);
    }

    .row-prodi:hover {
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

    .type-badge {
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        padding: 2px 10px;
        border-radius: 20px;
        letter-spacing: 0.5px;
    }
</style>

<div class="px-4 py-8 max-w-7xl mx-auto">
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
        <div class="flex items-center gap-5">
            <div class="w-16 h-16 bg-slate-50 border border-slate-100 rounded-2xl flex items-center justify-center shadow-sm">
                <svg class="w-9 h-9 text-blue-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
            </div>
            <div>
                <h4 class="text-2xl font-black text-blue-900 tracking-tight">
                    Manajemen <span class="text-slate-400 font-light">|</span> <span class="text-blue-600">Unit Kerja</span>
                </h4>
                <p class="text-[11px] text-slate-400 font-semibold uppercase tracking-[0.2em] mt-1">
                    Pengelolaan Jurusan dan Program Studi E-Kinerja
                </p>
            </div>
        </div>

        <div>
<div class="flex items-center gap-3">
    <div class="relative">
        <input 
            type="text" 
            id="searchBidang"
            placeholder="Cari jurusan / prodi..."
            class="pl-10 pr-4 py-2 border border-slate-200 rounded-xl text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-blue-100 w-64"
        >
        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </span>
    </div>

    <a href="<?= base_url('admin/bidang/create') ?>" 
       class="btn-add-polban inline-flex items-center gap-2 px-6 py-3 rounded-xl text-xs font-bold uppercase tracking-wider">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 4v16m8-8H4" />
        </svg>
        Tambah Unit Kerja
    </a>
</div>

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
                        <th class="p-5 w-20 text-center">No</th>
                        <th class="p-5">Nama Unit Kerja / Struktur</th>
                        <th class="p-5 text-center w-32">Tipe</th>
                        <th class="p-5 text-center w-48">Aksi</th>
                    </tr>
                </thead>

                <tbody class="text-sm text-slate-600">
                    <?php $no = 1; ?>
                    <?php foreach($jurusan as $j): ?>
                        <tr class="row-jurusan border-b border-slate-100"
                            data-type="jurusan"
                            data-name="<?= strtolower($j['nama_bidang']) ?>"
                            data-id="<?= $j['id'] ?>">
                            <td class="p-5 text-center font-bold text-slate-400"><?= $no++ ?></td>
                            <td class="p-5">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-blue-900 text-white flex items-center justify-center shrink-0 shadow-sm">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12V14a1 1 0 00.528.87l4.5 2.5a1 1 0 00.944 0l4.5-2.5a1 1 0 00.528-.87v-3.88l1.69-.724a1 1 0 000-1.838l-7-3a1 1 0 00-.787 0l-7 3a1 1 0 000 1.838z" /></svg>
                                    </div>
                                    <span class="font-black text-blue-900 uppercase tracking-tight text-base">
                                        <?= esc($j['nama_bidang']) ?>
                                    </span>
                                </div>
                            </td>
                            <td class="p-5 text-center">
                                <span class="type-badge bg-blue-100 text-blue-800 border border-blue-200">Jurusan</span>
                            </td>
                            <td class="p-5">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="<?= base_url('admin/bidang/edit/'.$j['id']) ?>" 
                                       class="px-3 py-1.5 rounded-lg bg-white border border-slate-200 text-blue-700 hover:bg-blue-600 hover:text-white transition-all shadow-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" stroke-width="2" /></svg>
                                    </a>
<button type="button" 
        onclick="confirmDelete('<?= base_url('admin/bidang/delete/'.$j['id']) ?>', '<?= esc($j['nama_bidang']) ?>', 'Jurusan')"
        class="px-3 py-1.5 rounded-lg bg-white border border-slate-200 text-red-600 hover:bg-red-600 hover:text-white transition-all shadow-sm">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-width="2" />
    </svg>
</button>
                                </div>
                            </td>
                        </tr>

                        <?php foreach($prodi as $p): ?>
                            <?php if($p['parent_id'] == $j['id']): ?>
                            <tr class="row-prodi border-b border-slate-50"
                                data-type="prodi"
                                data-name="<?= strtolower($p['nama_bidang']) ?>"
                                data-parent="<?= $p['parent_id'] ?>">
                                <td class="p-4"></td>
                                <td class="p-4 pl-12">
                                    <div class="flex items-center gap-3">
                                        <span class="text-slate-300 text-lg font-light">└─</span>
                                        <span class="font-semibold text-slate-700 italic"><?= esc($p['nama_bidang']) ?></span>
                                    </div>
                                </td>
                                <td class="p-4 text-center">
                                    <span class="type-badge bg-amber-50 text-amber-700 border border-amber-100">Prodi</span>
                                </td>
                                <td class="p-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="<?= base_url('admin/bidang/edit/'.$p['id']) ?>" class="text-slate-400 hover:text-blue-600 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" stroke-width="2" /></svg>
                                        </a>
<button type="button" 
        onclick="confirmDelete('<?= base_url('admin/bidang/delete/'.$p['id']) ?>', '<?= esc($p['nama_bidang']) ?>', 'Prodi')"
        class="text-slate-400 hover:text-red-600 transition-colors">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-width="2" />
    </svg>
</button>
                                    </div>
                                </td>
                            </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>

                    <?php endforeach; ?>
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
                    Struktur unit kerja menentukan pengelompokan indikator dan user pada <span class="text-blue-900 font-bold">E-Kinerja Polban</span>.
                </p>
            </div>
            <span class="text-[10px] font-bold text-slate-300 uppercase tracking-[0.3em]">Administrator Panel</span>
        </div>
    </div>
</div>

<script>
document.getElementById('searchBidang').addEventListener('input', function () {
    const keyword = this.value.toLowerCase();

    const jurusanRows = document.querySelectorAll('tr[data-type="jurusan"]');
    const prodiRows   = document.querySelectorAll('tr[data-type="prodi"]');

    // Reset
    jurusanRows.forEach(j => j.style.display = '');
    prodiRows.forEach(p => p.style.display = '');

    if (!keyword) return;

    jurusanRows.forEach(jurusan => {
        const jurusanName = jurusan.dataset.name;
        const jurusanId   = jurusan.dataset.id;

        const jurusanMatch = jurusanName.includes(keyword);

        let hasProdiMatch = false;

        prodiRows.forEach(prodi => {
            if (prodi.dataset.parent === jurusanId) {
                const prodiMatch = prodi.dataset.name.includes(keyword);

                if (prodiMatch) {
                    hasProdiMatch = true;
                    prodi.style.display = '';
                } else {
                    // SEMBUNYIKAN prodi hanya kalau jurusannya juga tidak match
                    prodi.style.display = jurusanMatch ? '' : 'none';
                }
            }
        });

        if (jurusanMatch || hasProdiMatch) {
            jurusan.style.display = '';
        } else {
            jurusan.style.display = 'none';
        }
    });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function confirmDelete(url, namaUnit, tipe) {
        // Pesan khusus jika yang dihapus adalah Jurusan (peringatan hierarki)
        const extraNote = tipe === 'Jurusan' 
            ? '<p class="text-[10px] text-amber-600 mt-2 font-bold uppercase tracking-widest">Peringatan: Prodi di bawah jurusan ini mungkin akan terpengaruh!</p>' 
            : '';

        Swal.fire({
            title: `<div class="text-2xl font-black text-blue-900 tracking-tight mb-2">Hapus ${tipe}</div>`,
            html: `
                <div class="text-slate-500 text-sm font-medium leading-relaxed">
                    Anda akan menghapus unit kerja: <br>
                    <span class="text-blue-600 font-bold">"${namaUnit}"</span>
                    ${extraNote}
                    <p class="text-[10px] text-red-400 mt-4 uppercase tracking-[0.2em] font-bold">Data yang dihapus tidak dapat dipulihkan</p>
                </div>
            `,
            icon: 'warning',
            iconColor: '#D4AF37',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus Unit',
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
                Swal.fire({
                    title: '<span class="text-sm font-bold text-slate-500 uppercase tracking-widest">Menghapus Unit Kerja...</span>',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                        const loader = Swal.getHtmlContainer().querySelector('.swal2-loader');
                        if (loader) loader.style.borderTopColor = '#003366';
                    },
                    showConfirmButton: false,
                    customClass: { popup: 'rounded-[20px]' }
                });
                window.location.href = url;
            }
        });
    }

</script>

<?= $this->endSection() ?>