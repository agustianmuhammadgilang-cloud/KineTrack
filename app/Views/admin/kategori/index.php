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

    /* Konsistensi Card dari User View */
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

    /* Row Styling agar konsisten dengan User Row */
    .category-row {
        transition: var(--transition-smooth);
        border-bottom: 1px solid #f1f5f9;
    }

    .category-row:hover {
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

    .btn-outline-excel {
        border: 1.5px solid #10b981;
        color: #10b981;
        transition: var(--transition-smooth);
    }

    .btn-outline-excel:hover {
        background-color: #f0fdf4;
        transform: translateY(-2px);
    }

    dialog::backdrop {
        backdrop-filter: blur(4px);
        background: rgba(0, 51, 102, 0.3);
    }
</style>

<div class="px-4 py-8 max-w-7xl mx-auto">
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
        <div class="flex items-center gap-5">
            <div class="w-16 h-16 bg-slate-50 border border-slate-100 rounded-2xl flex items-center justify-center shadow-sm">
                <svg class="w-9 h-9 text-blue-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
            </div>
            <div>
                <h4 class="text-2xl font-black text-blue-900 tracking-tight">
                    Repository <span class="text-slate-400 font-light">|</span> <span class="text-blue-600">Kategori Dokumen</span>
                </h4>
                <p class="text-[11px] text-slate-400 font-semibold uppercase tracking-[0.2em] mt-1">
                    Kelola struktur wadah arsip digital kinerja
                </p>
            </div>
        </div>

        <form method="get" class="mb-0 w-full max-w-xl">
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
                placeholder="Cari kategori atau deskripsi..."
                class="block w-full pl-11 pr-24 py-3.5 text-sm bg-white border border-slate-200 rounded-2xl
                       focus:ring-4 focus:ring-blue-50 focus:border-blue-600 focus:outline-none
                       transition-all duration-300 shadow-sm"
            >

            <div class="absolute inset-y-1.5 right-1.5 flex gap-1.5">
                <?php if (!empty($keyword)): ?>
                    <a href="<?= base_url('admin/kategori-dokumen') ?>" 
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
            <a href="<?= base_url('admin/kategori-dokumen/export-excel') ?>" 
               class="btn-outline-excel inline-flex items-center gap-2 px-5 py-3 rounded-xl text-xs font-bold uppercase tracking-wider">
                Export Excel
            </a>
            <button onclick="document.getElementById('modal-create').showModal()" 
                class="btn-polban inline-flex items-center gap-2 px-6 py-3 rounded-xl text-xs font-bold uppercase tracking-wider active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                Tambah Wadah
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        <div class="bg-blue-50 border border-blue-100 p-4 rounded-2xl">
            <p class="text-[10px] font-bold text-blue-600 uppercase tracking-widest">Total Kategori</p>
            <p class="text-2xl font-black text-blue-900"><?= count($kategori) ?></p>
        </div>
        <div class="bg-emerald-50 border border-emerald-100 p-4 rounded-2xl">
            <p class="text-[10px] font-bold text-emerald-600 uppercase tracking-widest">Status Aktif</p>
            <p class="text-2xl font-black text-emerald-900"><?= count(array_filter($kategori, fn($k) => $k['status'] === 'aktif')) ?></p>
        </div>
    </div>

    <div class="unit-card">
        <div class="unit-header-polban flex items-center justify-between">
            <h5 class="text-white text-xs font-bold uppercase tracking-widest flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" stroke-width="2" /></svg>
                Daftar Kategori Dokumen Terdaftar
            </h5>
        </div>

        <div class="divide-y divide-slate-50">
            <?php if(empty($kategori)): ?>
                <div class="p-20 text-center text-slate-400">
                    <p class="font-bold">Data tidak ditemukan.</p>
                </div>
            <?php endif; ?>

            <?php foreach ($kategori as $k): ?>
            <div class="category-row p-5 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-slate-50 flex items-center justify-center shrink-0 border border-slate-100 text-blue-900">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" /></svg>
                    </div>
                    <div>
                        <div class="flex items-center gap-2 mb-0.5">
                            <span class="font-bold text-slate-800 text-lg"><?= esc($k['nama_kategori']) ?></span>
                            <?php if($k['status'] === 'aktif'): ?>
                                <span class="text-[9px] bg-emerald-100 text-emerald-700 font-black uppercase px-2 py-0.5 rounded-full border border-emerald-200">Aktif</span>
                            <?php else: ?>
                                <span class="text-[9px] bg-slate-100 text-slate-400 font-black uppercase px-2 py-0.5 rounded-full border border-slate-200">Non-Aktif</span>
                            <?php endif; ?>
                        </div>
                        <p class="text-xs text-slate-500 max-w-xl"><?= esc($k['deskripsi'] ?: 'Tidak ada deskripsi tambahan.') ?></p>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 min-w-[200px]">
    <button onclick="document.getElementById('modal-edit-<?= $k['id'] ?>').showModal()"
        class="w-20 inline-flex items-center justify-center gap-1.5 px-3 py-2 rounded-lg bg-blue-50 text-blue-700 text-xs font-bold hover:bg-blue-600 hover:text-white transition-all shadow-sm border border-blue-100">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" stroke-width="2" />
        </svg>
        Edit
    </button>

    <a href="<?= base_url('admin/kategori-dokumen/toggle/'.$k['id']) ?>" 
       class="w-32 inline-flex items-center justify-center gap-1.5 px-3 py-2 rounded-lg transition-all shadow-sm border text-xs font-bold
       <?= $k['status']==='aktif' ? 'bg-orange-50 text-orange-600 border-orange-100 hover:bg-orange-600' : 'bg-emerald-50 text-emerald-600 border-emerald-100 hover:bg-emerald-600' ?> hover:text-white">
       
       <?php if($k['status'] === 'aktif'): ?>
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" /></svg>
            Non-aktif
       <?php else: ?>
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
            Aktifkan
       <?php endif; ?>
    </a>
</div>
            </div>

            <dialog id="modal-edit-<?= $k['id'] ?>" class="rounded-3xl shadow-2xl p-0 overflow-hidden w-full max-w-lg">
                <div class="bg-white">
                    <div class="h-2 bg-blue-900"></div>
                    <div class="p-8">
                        <h3 class="text-2xl font-black text-blue-900">Edit Kategori</h3>
                        <form method="post" action="<?= base_url('admin/kategori-dokumen/update/'.$k['id']) ?>" class="space-y-5 mt-6">
                            <?= csrf_field() ?>
                            <div>
                                <label class="text-[10px] font-black uppercase text-slate-400 ml-1">Nama Kategori</label>
                                <input type="text" name="nama_kategori" required value="<?= esc($k['nama_kategori']) ?>"
                                       class="w-full bg-slate-50 border-slate-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 transition-all font-bold">
                            </div>
                            <div>
                                <label class="text-[10px] font-black uppercase text-slate-400 ml-1">Deskripsi</label>
                                <textarea name="deskripsi" rows="3" class="w-full bg-slate-50 border-slate-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 transition-all"><?= esc($k['deskripsi']) ?></textarea>
                            </div>
                            <div class="flex gap-3 pt-4">
                                <button type="button" onclick="this.closest('dialog').close()" class="flex-1 py-3 text-sm font-bold text-slate-400">Batal</button>
                                <button type="submit" class="flex-[2] btn-polban py-3 rounded-xl font-bold shadow-lg">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </dialog>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<dialog id="modal-create" class="rounded-3xl shadow-2xl p-0 overflow-hidden w-full max-w-lg">
    <div class="bg-white">
        <div class="h-2 bg-blue-900"></div>
        <div class="p-10 text-center">
            <h3 class="text-2xl font-black text-blue-900">Tambah Wadah Baru</h3>
            <p class="text-xs text-slate-400 mt-1 uppercase tracking-widest font-bold">Arsip Kinerja Polban</p>
            
            <form method="post" action="<?= base_url('admin/kategori-dokumen/store') ?>" class="space-y-5 mt-8 text-left">
                <?= csrf_field() ?>
                <div>
                    <label class="text-[10px] font-black uppercase text-slate-400 ml-1">Nama Kategori</label>
                    <input type="text" name="nama_kategori" required placeholder="Contoh: Dokumen Penelitian"
                           class="w-full bg-slate-50 border-slate-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 transition-all font-bold">
                </div>
                <div>
                    <label class="text-[10px] font-black uppercase text-slate-400 ml-1">Deskripsi</label>
                    <textarea name="deskripsi" rows="3" placeholder="Jelaskan isi kategori ini..."
                              class="w-full bg-slate-50 border-slate-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 transition-all"></textarea>
                </div>
                <div class="flex items-center gap-4 pt-6">
                    <button type="button" onclick="this.closest('dialog').close()" class="text-sm font-bold text-slate-400">Tutup</button>
                    <button type="submit" class="flex-1 btn-polban py-4 rounded-2xl font-black shadow-xl">Resmikan Kategori</button>
                </div>
            </form>
        </div>
    </div>
</dialog>

<?= $this->endSection() ?>