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

    .btn-polban {
        transition: var(--transition-smooth);
        background: var(--polban-blue);
    }

    .btn-polban:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px -5px rgba(0, 51, 102, 0.3);
        filter: brightness(1.1);
    }

    .info-badge {
        background: linear-gradient(135deg, rgba(0, 51, 102, 0.03) 0%, rgba(212, 175, 55, 0.05) 100%);
        border-left: 4px solid var(--polban-gold);
    }
</style>

<div class="px-4 py-8 max-w-2xl mx-auto">
    <div class="flex items-center gap-5 mb-10">
        <div class="w-14 h-14 bg-blue-50 border border-blue-100 rounded-2xl flex items-center justify-center shadow-sm text-blue-900">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
        </div>
        <div>
            <h4 class="text-2xl font-black text-blue-900 tracking-tight">
                Konfigurasi <span class="text-slate-400 font-light">|</span> <span class="text-blue-600">Tambah Jabatan</span>
            </h4>
            <p class="text-[11px] text-slate-400 font-semibold uppercase tracking-[0.2em] mt-1">
                Manajemen struktur organisasi internal
            </p>
        </div>
    </div>

    <div class="form-card overflow-hidden">
        <div class="p-8 md:p-10">
            
            <form action="<?= base_url('admin/jabatan/store'); ?>" method="POST" class="space-y-8">
                
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">
                        Nama Jabatan <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="text" name="nama_jabatan" required
                               placeholder="Contoh: Ketua Jurusan, Staff Prodi"
                               class="input-field w-full px-5 py-4 rounded-2xl text-blue-900 font-semibold placeholder:text-slate-300">
                    </div>
                </div>

                <div class="info-badge p-5 rounded-2xl">
                    <div class="flex gap-4">
                        <div class="shrink-0 w-8 h-8 bg-white rounded-lg shadow-sm flex items-center justify-center">
                            <svg class="w-4 h-4 text-polban-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <p class="text-[11px] text-slate-500 font-medium leading-relaxed">
                            Pastikan penulisan nama jabatan menggunakan format yang baku karena akan mempengaruhi 
                            <span class="text-blue-900 font-bold tracking-tight italic">Otomatisasi Role</span> pada sistem manajemen user.
                        </p>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 pt-4">
                    <button type="submit" class="btn-polban flex-[2] text-white font-black py-4 rounded-2xl uppercase tracking-widest text-xs">
                        Simpan Jabatan
                    </button>
                    <a href="<?= base_url('admin/jabatan'); ?>" class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-500 font-black py-4 rounded-2xl uppercase tracking-widest text-xs text-center transition-colors">
                        Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>