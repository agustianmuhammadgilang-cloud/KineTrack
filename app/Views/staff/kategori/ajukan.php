<?= $this->extend('layout/staff_template') ?>
<?= $this->section('content') ?>

<style>
    :root {
        --polban-blue: #1D2F83;
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
        background-color: white;
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

<div class="px-4 py-8 max-w-5xl mx-auto">
    <div class="flex items-center gap-5 mb-10">
        <div class="w-14 h-14 bg-blue-50 border border-blue-100 rounded-2xl flex items-center justify-center shadow-sm text-blue-900">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
            </svg>
        </div>
        <div>
            <h4 class="text-2xl font-black text-blue-900 tracking-tight">
                Ajukan <span class="text-blue-600">Kategori Baru</span>
            </h4>
            <p class="text-[11px] text-slate-400 font-semibold uppercase tracking-[0.2em] mt-1">
                Kinetrack — Usulkan klasifikasi dokumen baru ke sistem
            </p>
        </div>
    </div>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="mb-6 bg-rose-50 border border-rose-100 rounded-2xl p-4 flex items-center gap-3 text-rose-700 shadow-sm">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <p class="text-xs font-bold uppercase tracking-tight"><?= session()->getFlashdata('error') ?></p>
        </div>
    <?php endif; ?>

    <div class="form-card overflow-hidden">
        <div class="p-8 md:p-12">
            
            <div class="info-badge p-6 rounded-3xl mb-10">
                <div class="flex items-start gap-4">
                    <div class="shrink-0 w-10 h-10 bg-white rounded-xl flex items-center justify-center text-amber-500 shadow-sm border border-amber-50">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-blue-900 uppercase tracking-widest mb-1">Prosedur Pengajuan</p>
                        <p class="text-xs text-slate-600 font-medium leading-relaxed">
                            Kategori yang Anda ajukan bersifat usulan. Admin sistem akan melakukan peninjauan sebelum kategori ini tersedia untuk publik. Mohon gunakan penamaan yang baku.
                        </p>
                    </div>
                </div>
            </div>

            <form action="<?= base_url('staff/kategori/ajukan/store') ?>" method="POST" class="space-y-8">
                <?= csrf_field() ?>

                <div class="grid grid-cols-1 gap-8">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Nama Kategori <span class="text-rose-500">*</span></label>
                        <input type="text" name="nama_kategori" required 
                               placeholder="Contoh: Dokumen Kerja Sama Luar Negeri"
                               class="input-field w-full px-5 py-4 rounded-2xl text-blue-900 font-bold text-lg bg-slate-50/50">
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-tight px-1">Gunakan huruf kapital di setiap awal kata.</p>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Tujuan / Cakupan Kategori</label>
                        <textarea name="deskripsi" rows="4" 
                                  placeholder="Jelaskan jenis berkas apa saja yang masuk dalam kategori ini..."
                                  class="input-field w-full px-5 py-4 rounded-2xl text-blue-900 font-medium text-sm"></textarea>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 pt-8 border-t border-slate-50">
                    <button type="submit" class="btn-polban flex-1 text-white font-black py-4 rounded-2xl uppercase tracking-widest text-xs shadow-lg shadow-blue-900/10">
                        Kirim Usulan Kategori
                    </button>
                    <a href="<?= base_url('staff/dokumen/create') ?>" class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-500 font-black py-4 rounded-2xl uppercase tracking-widest text-xs text-center transition-colors">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="mt-10 text-center">
        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">
            © <?= date('Y') ?> Kinetrack — Politeknik Negeri Bandung
        </p>
    </div>
</div>

<?= $this->endSection() ?>