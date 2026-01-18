<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<style>
    :root {
        --polban-blue: #003366;
        --polban-blue-light: #004a94;
        --polban-gold: #D4AF37;
        --slate-soft: #f8fafc;
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

    .btn-update {
        transition: var(--transition-smooth);
        background: #f59e0b; /* Amber 500 */
    }

    .btn-update:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px -5px rgba(245, 158, 11, 0.3);
        filter: brightness(1.05);
    }

    .info-badge {
        background: linear-gradient(135deg, rgba(0, 51, 102, 0.03) 0%, rgba(212, 175, 55, 0.05) 100%);
        border-left: 4px solid var(--polban-gold);
    }
</style>

<div class="px-4 py-8 max-w-2xl mx-auto">
    <div class="flex items-center gap-5 mb-10">
        <div class="w-14 h-14 bg-amber-50 border border-amber-100 rounded-2xl flex items-center justify-center shadow-sm text-amber-600">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
        </div>
        <div>
            <h4 class="text-2xl font-black text-blue-900 tracking-tight">
                Modifikasi <span class="text-slate-400 font-light">|</span> <span class="text-blue-600">Edit Jabatan</span>
            </h4>
            <p class="text-[11px] text-slate-400 font-semibold uppercase tracking-[0.2em] mt-1">
                Memperbarui data struktur organisasi
            </p>
        </div>
    </div>

    <div class="form-card overflow-hidden">
        <div class="p-8 md:p-10">
            
            <form action="<?= base_url('admin/jabatan/update/'.$jabatan['id']); ?>" method="POST" class="space-y-8">
                
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">
                        Nama Jabatan Saat Ini <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="nama_jabatan" required
                           value="<?= esc($jabatan['nama_jabatan']) ?>"
                           placeholder="Masukkan nama jabatan"
                           class="input-field w-full px-5 py-4 rounded-2xl text-blue-900 font-semibold">
                </div>

                <div class="info-badge p-5 rounded-2xl">
                    <div class="flex gap-4">
                        <div class="shrink-0 w-8 h-8 bg-white rounded-lg shadow-sm flex items-center justify-center">
                            <svg class="w-4 h-4 text-polban-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <p class="text-[11px] text-slate-500 font-medium leading-relaxed">
                            Perubahan pada nama jabatan mungkin akan mempengaruhi penentuan 
                            <span class="text-blue-900 font-bold tracking-tight italic">Role Otomatis</span> pada pengguna yang sudah terdaftar dengan jabatan ini.
                        </p>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 pt-4">
                    <button type="submit" class="btn-update flex-[2] text-white font-black py-4 rounded-2xl uppercase tracking-widest text-xs">
                        Perbarui Data
                    </button>
                    <a href="<?= base_url('admin/jabatan'); ?>" class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-500 font-black py-4 rounded-2xl uppercase tracking-widest text-xs text-center transition-colors">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>