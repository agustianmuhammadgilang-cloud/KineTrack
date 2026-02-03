<?= $this->extend('layout/atasan_template') ?>
<?= $this->section('content') ?>

<style>
    :root {
        --polban-blue: #1D2F83;
        --polban-blue-light: #004a94;
        --polban-gold: #D4AF37;
        --slate-soft: #f8fafc;
        --transition-smooth: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Card Styling */
    .archive-card {
        transition: var(--transition-smooth);
        background: white;
        border: 1px solid #eef2f6;
        border-radius: 28px;
        position: relative;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .archive-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(0, 51, 102, 0.08);
        border-color: var(--polban-blue);
    }

    .btn-polban {
        transition: var(--transition-smooth);
        background-color: var(--polban-blue);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .btn-polban:hover {
        background-color: var(--polban-blue-light);
        color: white;
    }

    /* Background Icon Decorative */
    .bg-deco {
        position: absolute;
        bottom: -15px;
        right: -15px;
        opacity: 0.03;
        transform: rotate(-15deg);
        transition: var(--transition-smooth);
        pointer-events: none;
    }

    .archive-card:hover .bg-deco {
        opacity: 0.07;
        transform: rotate(0deg) scale(1.1);
        color: var(--polban-blue);
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
</style>

<div class="px-4 py-8 max-w-7xl mx-auto font-sans">
    
    <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-8 mb-10">
        <div class="flex items-center gap-5">
            <div class="w-16 h-16 bg-blue-50 border border-blue-100 rounded-2xl flex items-center justify-center shadow-sm text-blue-900">
                <svg class="w-9 h-9" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <div>
                <h1 class="text-3xl font-black text-blue-900 tracking-tight leading-none">Dokumen Unit Kerja</h1>
                <p class="text-[11px] text-slate-400 mt-2 font-black uppercase tracking-[0.2em]">Monitoring Arsip & Kolaborasi Unit</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-[2rem] p-5 mb-8 border border-slate-100 shadow-sm">
        <form method="get" class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
            <div class="md:col-span-3">
                <input type="text" name="q" value="<?= esc($_GET['q'] ?? '') ?>" 
                       placeholder="Cari judul..."
                       class="filter-input w-full px-5 py-3 rounded-xl text-sm font-bold text-blue-900 bg-slate-50/50">
            </div>

            <div class="md:col-span-3">
                <input type="text" name="pengirim" value="<?= esc($_GET['pengirim'] ?? '') ?>"
                       placeholder="Nama pengirim..."
                       class="filter-input w-full px-5 py-3 rounded-xl text-sm font-bold text-blue-900 bg-slate-50/50">
            </div>

            <div class="md:col-span-3">
                <input type="text" name="unit" value="<?= esc($_GET['unit'] ?? '') ?>"
                       placeholder="Nama unit..."
                       class="filter-input w-full px-5 py-3 rounded-xl text-sm font-bold text-blue-900 bg-slate-50/50">
            </div>

            <div class="md:col-span-3 flex items-center gap-2">
                <button type="submit" 
                        class="flex-1 btn-polban font-black py-3 rounded-xl text-[10px] uppercase tracking-widest h-[46px]">
                    Filter
                </button>
                
                <?php if (!empty($_GET['q']) || !empty($_GET['pengirim']) || !empty($_GET['unit'])): ?>
                    <a href="<?= current_url() ?>" 
                       class="flex items-center justify-center w-12 h-[46px] bg-rose-50 text-rose-500 hover:bg-rose-500 hover:text-white rounded-xl transition-all border border-rose-100 shadow-sm"
                       title="Reset Filter">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <?php if (empty($dokumen)): ?>
        <div class="py-20 bg-slate-50 border-2 border-dashed border-slate-200 rounded-[2.5rem] text-center">
            <div class="flex flex-col items-center text-slate-300">
                <svg class="h-20 w-20 mb-4 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <h4 class="text-lg font-bold uppercase tracking-widest">Belum Ada Dokumen Unit</h4>
                <p class="text-sm italic mt-1">Dokumen unit yang masuk ke sistem akan muncul di sini</p>
            </div>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($dokumen as $d): 
                $statusMap = [
                    'pending_kaprodi'  => ['Dalam Proses', 'bg-amber-50 text-amber-600 border-amber-100'],
                    'pending_kajur'    => ['Dalam Proses', 'bg-amber-50 text-amber-600 border-amber-100'],
                    'rejected_kaprodi' => ['Ditolak', 'bg-rose-50 text-rose-600 border-rose-100'],
                    'rejected_kajur'   => ['Ditolak', 'bg-rose-50 text-rose-600 border-rose-100'],
                    'archived'         => ['Disetujui', 'bg-emerald-50 text-emerald-600 border-emerald-100'],
                ];
                [$label, $statusClass] = $statusMap[$d['status']] ?? ['Unknown', 'bg-slate-50 text-slate-600 border-slate-100'];
            ?>
                <div class="archive-card p-7 group">
                    <div class="flex justify-between items-start mb-6">
                        <div class="w-14 h-14 bg-slate-50 border border-slate-100 rounded-2xl flex items-center justify-center text-blue-900 group-hover:bg-blue-900 group-hover:text-white transition-all duration-300 shadow-sm">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <span class="px-3 py-1.5 rounded-xl border <?= $statusClass ?> text-[9px] font-black uppercase tracking-widest">
                            <?= $label ?>
                        </span>
                    </div>

                    <div class="flex-grow">
                        <h3 class="text-lg font-black text-blue-900 group-hover:text-blue-600 transition-colors leading-snug mb-2 uppercase tracking-tight">
                            <?= esc($d['judul']) ?>
                        </h3>
                        <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed italic mb-4 min-h-[2.5rem]">
                            <?= esc($d['deskripsi'] ?: 'Tidak ada deskripsi tambahan untuk berkas ini.') ?>
                        </p>

                        <div class="space-y-2.5 mb-4 pt-4 border-t border-slate-50">
                            <div class="flex items-center justify-between text-[10px] font-bold text-slate-600">
                                <span class="text-slate-400 uppercase tracking-tighter">Pengirim</span>
                                <span class="truncate ml-4"><?= esc($d['nama_pengirim'] ?? '-') ?></span>
                            </div>
                            <div class="flex items-center justify-between text-[10px] font-bold text-slate-600">
                                <span class="text-slate-400 uppercase tracking-tighter">Jabatan</span>
                                <span class="truncate ml-4 text-blue-900"><?= esc($d['nama_jabatan'] ?? '-') ?></span>
                            </div>
                            <div class="flex items-center justify-between text-[10px] font-bold text-slate-600">
                                <span class="text-slate-400 uppercase tracking-tighter">Unit</span>
                                <span class="truncate ml-4 px-2 py-0.5 bg-slate-100 rounded-md font-black"><?= esc($d['nama_unit_asal'] ?? '-') ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 pt-6 border-t border-slate-50 flex items-center justify-between">
                        <div class="flex flex-col text-left">
                            <span class="text-[9px] font-black text-slate-300 uppercase tracking-widest mb-1 leading-none">Terarsip Pada</span>
                            <span class="text-xs font-bold text-slate-600"><?= date('d M Y', strtotime($d['created_at'])) ?></span>
                        </div>

                        <a href="<?= base_url('uploads/dokumen/'.$d['file_path']) ?>" target="_blank" 
                           class="inline-flex items-center gap-2 bg-slate-50 text-slate-600 px-4 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-blue-900 hover:text-white transition-all border border-slate-100">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-width="2"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" stroke-width="2"/></svg>
                            Buka Berkas
                        </a>
                    </div>

                    <div class="bg-deco text-blue-900">
                        <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24"><path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="mt-16 pt-8 border-t border-slate-100 flex flex-col md:flex-row justify-between items-center gap-4 opacity-50 text-center md:text-left">
        <div class="flex items-center gap-3">
             <p class="text-[10px] text-slate-500 font-black tracking-widest uppercase">
                &copy; <?= date('Y') ?> KINETRACK — UNIT COLLABORATION SPACE
            </p>
        </div>
    </div>
</div>

<?= $this->endSection() ?>