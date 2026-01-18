<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<style>
    :root {
        --polban-blue: #003366;
        --polban-gold: #D4AF37;
        --transition-smooth: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .form-card {
        background: white;
        border-radius: 32px;
        border: 1px solid #eef2f6;
        box-shadow: 0 20px 50px -12px rgba(0, 51, 102, 0.08);
    }

    .input-field {
        transition: var(--transition-smooth);
        border: 1.5px solid #e2e8f0;
    }

    .input-field:focus {
        border-color: var(--polban-blue);
        box-shadow: 0 0 0 4px rgba(0, 51, 102, 0.05);
        outline: none;
    }

    .btn-polban {
        transition: var(--transition-smooth);
        background: var(--polban-blue);
    }

    .btn-polban:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px -5px rgba(0, 51, 102, 0.3);
        filter: brightness(1.1);
    }

    /* Animasi untuk field yang muncul-hilang */
    #parent-wrapper {
        transition: var(--transition-smooth);
    }
    .hidden-field {
        display: none;
        opacity: 0;
        transform: translateY(-10px);
    }
    .show-field {
        display: block;
        opacity: 1;
        transform: translateY(0);
    }
</style>

<div class="px-4 py-8 max-w-2xl mx-auto">
    <div class="flex items-center gap-5 mb-10">
        <div class="w-14 h-14 bg-blue-50 border border-blue-100 rounded-2xl flex items-center justify-center shadow-sm text-blue-900">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
            </svg>
        </div>
        <div>
            <h4 class="text-2xl font-black text-blue-900 tracking-tight">
                Entitas Baru <span class="text-slate-400 font-light">|</span> <span class="text-blue-600">Unit Kerja</span>
            </h4>
            <p class="text-[11px] text-slate-400 font-semibold uppercase tracking-[0.2em] mt-1">
                Manajemen Departemen dan Program Studi
            </p>
        </div>
    </div>

    <div class="form-card overflow-hidden">
        <div class="p-8 md:p-10">
            
            <?php if(session()->getFlashdata('error')): ?>
                <div class="mb-8 p-4 rounded-2xl bg-rose-50 border border-rose-100 text-rose-700 text-sm font-bold flex items-center gap-3">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('admin/bidang/store'); ?>" method="POST" class="space-y-8">

                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Nama Unit Kerja</label>
                    <input type="text" name="nama_bidang" required value="<?= old('nama_bidang') ?>"
                           placeholder="Misal: Teknik Komputer & Informatika"
                           class="input-field w-full px-5 py-4 rounded-2xl text-blue-900 font-semibold">
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Jenis Level Unit</label>
                    <select name="jenis_unit" id="jenis_unit" required
                            class="input-field w-full px-5 py-4 rounded-2xl text-blue-900 font-bold bg-slate-50/50">
                        <option value="">-- Pilih Jenis Unit --</option>
                        <option value="jurusan" <?= old('jenis_unit') === 'jurusan' ? 'selected' : '' ?>>Jurusan / Departemen</option>
                        <option value="prodi"   <?= old('jenis_unit') === 'prodi' ? 'selected' : '' ?>>Program Studi</option>
                    </select>
                </div>

                <div id="parent-wrapper" class="<?= old('jenis_unit') === 'prodi' ? 'show-field' : 'hidden-field' ?> space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1 text-blue-600">Terikat pada Jurusan</label>
                    <select name="parent_id"
                            class="input-field w-full px-5 py-4 rounded-2xl text-blue-900 font-bold border-blue-100 bg-blue-50/30">
                        <option value="">-- Pilih Induk Jurusan --</option>
                        <?php foreach ($jurusan as $j): ?>
                            <option value="<?= $j['id'] ?>" <?= old('parent_id') == $j['id'] ? 'selected' : '' ?>>
                                <?= esc($j['nama_bidang']) ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-slate-50">
                    <button type="submit" class="btn-polban flex-[2] text-white font-black py-4 rounded-2xl uppercase tracking-widest text-xs">
                        Simpan Unit Kerja
                    </button>
                    <a href="<?= base_url('admin/bidang'); ?>" class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-500 font-black py-4 rounded-2xl uppercase tracking-widest text-xs text-center transition-colors">
                        Kembali
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('jenis_unit').addEventListener('change', function () {
    const parentWrapper = document.getElementById('parent-wrapper');
    if (this.value === 'prodi') {
        parentWrapper.classList.remove('hidden-field');
        parentWrapper.classList.add('show-field');
    } else {
        parentWrapper.classList.remove('show-field');
        parentWrapper.classList.add('hidden-field');
    }
});
</script>

<?= $this->endSection() ?>