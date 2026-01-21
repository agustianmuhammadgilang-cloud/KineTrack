<?= $this->extend('layout/staff_template') ?>
<?= $this->section('content') ?>

<style>
    :root {
        --polban-blue: #1D2F83;
        --polban-blue-light: #1D2F83;
        --polban-gold: #D4AF37;
        --slate-soft: #f8fafc;
        --transition-smooth: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .glass-card {
        background: white;
        border-radius: 32px;
        border: 1px solid #eef2f6;
        box-shadow: 0 20px 50px -12px rgba(0, 51, 102, 0.05);
    }

    .filter-input {
        transition: var(--transition-smooth);
        border: 1.5px solid #e2e8f0;
    }

    .filter-input:focus {
        border-color: var(--polban-blue);
        box-shadow: 0 0 0 4px rgba(0, 51, 102, 0.05);
        outline: none;
    }

    .action-btn {
        transition: var(--transition-smooth);
    }

    .action-btn:hover {
        transform: translateY(-2px);
    }
</style>

<div class="px-6 py-10 max-w-7xl mx-auto font-sans">
    
    <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-8 mb-12">
        <div class="flex items-center gap-5">
            <div class="w-16 h-16 bg-blue-50 border border-blue-100 rounded-2xl flex items-center justify-center shadow-sm text-blue-900">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
            </div>
            <div>
                <h1 class="text-3xl font-black text-blue-900 tracking-tight leading-none">Arsip Dokumen</h1>
                <p class="text-[11px] text-slate-400 mt-2 font-black uppercase tracking-[0.2em]">Laporan Kinerja Terverifikasi & Terkunci</p>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <a href="<?= base_url('staff/dokumen/exportArsipExcel') ?>" 
               class="action-btn inline-flex items-center gap-2.5 bg-emerald-50 text-emerald-700 border border-emerald-100 px-6 py-3.5 rounded-2xl font-black text-[11px] uppercase tracking-widest hover:bg-emerald-600 hover:text-white transition-all shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Export Excel
            </a>
            <a href="<?= base_url('staff/dokumen/export_pdf') ?>" 
               class="action-btn inline-flex items-center gap-2.5 bg-rose-50 text-rose-700 border border-rose-100 px-6 py-3.5 rounded-2xl font-black text-[11px] uppercase tracking-widest hover:bg-rose-600 hover:text-white transition-all shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                </svg>
                Export PDF
            </a>
        </div>
    </div>

    <div class="glass-card p-6 mb-8">
        <form method="get" class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
            <div class="md:col-span-5 relative">
                <span class="absolute inset-y-0 left-4 flex items-center text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-width="2.5" stroke-linecap="round"/></svg>
                </span>
                <input type="text" name="q" value="<?= esc($_GET['q'] ?? '') ?>" 
                       placeholder="Cari judul dokumen..."
                       class="filter-input w-full pl-11 pr-4 py-3.5 rounded-2xl text-sm font-bold text-blue-900 bg-slate-50/50">
            </div>

            <div class="md:col-span-4">
                <input type="date" name="date" value="<?= esc($_GET['date'] ?? '') ?>"
                       class="filter-input w-full px-5 py-3.5 rounded-2xl text-sm font-bold text-blue-900 bg-slate-50/50">
            </div>

            <div class="md:col-span-3 flex gap-2">
                <button type="submit" class="flex-1 bg-blue-900 text-white font-black py-3.5 rounded-2xl text-[10px] uppercase tracking-widest hover:bg-blue-800 transition-all">
                    Filter
                </button>
                <a href="<?= current_url() ?>" class="flex-1 bg-slate-100 text-slate-500 font-black py-3.5 rounded-2xl text-[10px] uppercase tracking-widest text-center hover:bg-slate-200 transition-all">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <div class="glass-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-100">
                        <th class="px-8 py-6 text-left text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Detail Dokumen</th>
                        <th class="px-8 py-6 text-center text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Penyelesaian</th>
                        <th class="px-8 py-6 text-center text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Status</th>
                        <th class="px-8 py-6 text-right text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Opsi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <?php if (!empty($dokumen)): ?>
                        <?php foreach ($dokumen as $d): ?>
                        <tr class="group hover:bg-blue-50/40 transition-all duration-300">
                            <td class="px-8 py-7">
                                <div class="flex items-center gap-5">
                                    <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center border border-slate-100 text-slate-400 group-hover:text-blue-600 group-hover:border-blue-100 group-hover:shadow-sm transition-all shadow-sm">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="block font-black text-blue-900 text-base leading-tight"><?= esc($d['judul']) ?></span>
                                        <div class="flex items-center gap-2 mt-1.5">
                                            <span class="text-[10px] bg-slate-100 text-slate-500 px-2 py-0.5 rounded font-black uppercase tracking-tighter">ID: #<?= esc($d['id']) ?></span>
                                            <span class="w-1 h-1 bg-slate-300 rounded-full"></span>
                                            <span class="text-[10px] text-slate-400 font-bold uppercase tracking-tight italic">Verified Data</span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-7 text-center">
                                <div class="inline-flex flex-col items-center">
                                    <span class="text-sm font-black text-slate-700"><?= date('d M', strtotime($d['updated_at'])) ?></span>
                                    <span class="text-[10px] font-bold text-slate-400 uppercase"><?= date('Y', strtotime($d['updated_at'])) ?></span>
                                </div>
                            </td>
                            <td class="px-8 py-7 text-center">
                                <span class="inline-flex items-center px-4 py-2 rounded-2xl border-2 border-emerald-50 bg-emerald-50 text-emerald-700 text-[10px] font-black uppercase tracking-widest shadow-sm">
                                    <svg class="w-3.5 h-3.5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Terverifikasi
                                </span>
                            </td>
                            <td class="px-8 py-7 text-right">
                                <a href="<?= base_url('uploads/dokumen/'.$d['file_path']) ?>" target="_blank" 
                                   class="inline-flex items-center gap-2.5 bg-white border border-slate-200 text-slate-600 hover:text-blue-600 hover:border-blue-500 hover:shadow-lg hover:shadow-blue-900/10 px-6 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-width="2"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" stroke-width="2"/>
                                    </svg>
                                    Buka File
                                </a>
                            </td>
                        </tr>
                        <?php endforeach ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="px-8 py-24 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center text-slate-200 mb-6 border border-slate-100">
                                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                        </svg>
                                    </div>
                                    <p class="text-slate-400 font-black text-sm uppercase tracking-widest italic">Arsip Kosong</p>
                                    <p class="text-slate-300 text-xs mt-2">Belum ada dokumen yang disetujui dalam arsip Anda.</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-8 p-8 bg-blue-900 rounded-[2.5rem] text-white flex flex-col md:flex-row items-center gap-6 shadow-2xl shadow-blue-900/20 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-32 h-32 bg-blue-800 rounded-full -mr-16 -mt-16 opacity-50"></div>
        <div class="w-14 h-14 bg-white/10 rounded-2xl flex items-center justify-center text-polban-gold shrink-0 backdrop-blur-sm border border-white/10">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div class="relative z-10 text-center md:text-left">
            <h5 class="font-black uppercase tracking-widest text-xs mb-1 text-blue-200">Informasi Arsip Digital</h5>
            <p class="text-xs text-blue-100 font-medium leading-relaxed opacity-80">
                Data arsip ini bersifat <span class="text-white font-black italic underline decoration-polban-gold">Read-Only</span>. Semua dokumen di sini telah melalui proses verifikasi berjenjang oleh Atasan dan telah dikunci demi integritas data kinerja Kinetrack.
            </p>
        </div>
    </div>
</div>

<?= $this->endSection() ?>