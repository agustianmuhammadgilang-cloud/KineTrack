<?= $this->extend('layout/atasan_template') ?>
<?= $this->section('content') ?>

<div class="min-h-screen bg-slate-50 px-6 py-8 font-sans text-slate-800">

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center text-indigo-600 shadow-xl shadow-indigo-900/5 border border-slate-100">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                </svg>
            </div>
            <div>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight leading-none">
                    Dokumen Publik
                </h1>
                <p class="text-xs text-slate-400 mt-2 font-black uppercase tracking-[0.2em]">Arsip Resmi Lintas Unit Kerja</p>
            </div>
        </div>
    </div>
    <form method="get" class="mb-10">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

        <input type="text" name="q"
               value="<?= esc($_GET['q'] ?? '') ?>"
               placeholder="Cari judul dokumen"
               class="px-4 py-2 rounded-xl border text-sm">

        <input type="text" name="pengirim"
               value="<?= esc($_GET['pengirim'] ?? '') ?>"
               placeholder="Nama pengirim"
               class="px-4 py-2 rounded-xl border text-sm">

        <input type="text" name="unit"
               value="<?= esc($_GET['unit'] ?? '') ?>"
               placeholder="Nama unit"
               class="px-4 py-2 rounded-xl border text-sm">

        <div class="flex gap-2">
            <button class="flex-1 bg-slate-900 text-white rounded-xl text-sm font-bold">
                Filter
            </button>
            <a href="<?= current_url() ?>"
               class="flex-1 text-center bg-slate-100 rounded-xl text-sm font-bold py-2">
                Reset
            </a>
        </div>

    </div>
</form>


    <?php if (empty($dokumen)): ?>
        <div class="bg-white border-2 border-dashed border-slate-200 rounded-[2.5rem] p-20 text-center shadow-sm">
            <div class="mx-auto w-20 h-20 flex items-center justify-center rounded-3xl bg-slate-50 text-slate-300 mb-6">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
            </div>
            <h3 class="text-xl font-black text-slate-800 tracking-tight">Belum Ada Dokumen Publik</h3>
            <p class="text-sm text-slate-400 mt-2 font-medium max-w-xs mx-auto">
                Dokumen resmi yang dipublikasikan secara global akan muncul di galeri ini.
            </p>
        </div>
    <?php else: ?>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
        <?php foreach ($dokumen as $d): ?>
            <div class="group bg-white rounded-[2rem] border border-slate-200 shadow-xl shadow-slate-200/40 hover:shadow-indigo-900/10 transition-all duration-300 flex flex-col overflow-hidden hover:-translate-y-2">
                
                <div class="p-6 border-b border-slate-50 relative">
                    <div class="flex items-start justify-between gap-4 mb-4">
                        <div class="w-10 h-10 bg-slate-50 rounded-xl flex items-center justify-center text-slate-400 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <span class="px-3 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-wider border border-emerald-100 bg-emerald-50 text-emerald-700 shadow-sm">
                            Publik
                        </span>
                    </div>

                    <h5 class="font-black text-slate-800 leading-tight group-hover:text-indigo-600 transition-colors line-clamp-2 min-h-[2.5rem]">
                        <?= esc($d['judul']) ?>
                    </h5>
                    
                    <div class="flex items-center gap-2 mt-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <?= date('d M Y', strtotime($d['created_at'])) ?>
                    </div>
                </div>

                <div class="p-6 flex-1 bg-slate-50/30 space-y-4">
                    <p class="text-xs font-medium text-slate-500 leading-relaxed line-clamp-2">
                        <?= esc($d['deskripsi'] ?? 'Tidak ada deskripsi tambahan.') ?>
                    </p>

                    <div class="grid grid-cols-1 gap-y-2 pt-2 border-t border-slate-100">
                        <div class="flex items-center justify-between">
                            <span class="text-[10px] font-black text-slate-400 uppercase">Kategori</span>
                            <span class="text-[11px] font-bold text-slate-700"><?= esc($d['nama_kategori'] ?? '-') ?></span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-[10px] font-black text-slate-400 uppercase">Pengirim</span>
                            <span class="text-[11px] font-bold text-slate-700"><?= esc($d['nama_pengirim'] ?? '-') ?></span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-[10px] font-black text-slate-400 uppercase">Unit</span>
                            <span class="text-[11px] font-bold text-indigo-600"><?= esc($d['nama_unit'] ?? '-') ?></span>
                        </div>
                    </div>
                </div>

                <div class="p-6 pt-0">
                    <a href="<?= base_url('uploads/dokumen/'.$d['file_path']) ?>"
                       target="_blank"
                       class="w-full inline-flex items-center justify-center gap-2 bg-white border border-slate-200 text-slate-600 hover:text-indigo-600 hover:border-indigo-200 py-3.5 rounded-2xl text-[11px] font-black uppercase tracking-widest transition-all shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-width="2"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" stroke-width="2"/>
                        </svg>
                        Lihat Dokumen
                    </a>
                </div>

            </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <div class="mt-20 pt-8 border-t border-slate-200 flex items-center justify-between opacity-50">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 bg-slate-200 rounded-lg flex items-center justify-center font-black text-slate-500 text-[10px]">KT</div>
            <p class="text-[10px] text-slate-500 font-black tracking-widest uppercase">
                Public Archive &copy; <?= date('Y') ?> <span class="text-slate-900">KINETRACK</span>
            </p>
        </div>
    </div>
</div>

<?= $this->endSection() ?>