
<?= $this->extend('layout/atasan_template') ?>
<?= $this->section('content') ?>

<div class="min-h-screen bg-slate-50 px-6 py-8 font-sans text-slate-800">

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center text-blue-600 shadow-xl shadow-blue-900/5 border border-slate-100">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
            </div>
            <div>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight leading-none">
                    Arsip Dokumen Kinerja
                </h1>
                <p class="text-xs text-slate-400 mt-2 font-black uppercase tracking-[0.2em]">Laporan Terverifikasi • Politeknik Negeri Bandung</p>
            </div>
        </div>
<!-- FILTER -->
<form method="get" class="mb-6">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

        <!-- SEARCH JUDUL -->
        <input type="text"
               name="q"
               value="<?= esc($_GET['q'] ?? '') ?>"
               placeholder="Cari judul dokumen..."
               class="px-4 py-2 rounded-xl border border-slate-200 text-sm">

        <!-- FILTER TANGGAL -->
        <input type="date"
               name="date"
               value="<?= esc($_GET['date'] ?? '') ?>"
               class="px-4 py-2 rounded-xl border border-slate-200 text-sm">

        <!-- BUTTON FILTER -->
        <button type="submit"
                class="bg-slate-900 hover:bg-blue-600 text-white
                       px-5 py-2 rounded-xl text-sm font-bold transition">
            Filter
        </button>

        <!-- RESET -->
        <a href="<?= current_url() ?>"
           class="text-center bg-slate-100 hover:bg-slate-200
                  px-5 py-2 rounded-xl text-sm font-bold transition">
            Reset
        </a>

    </div>
</form>



        <div class="flex items-center gap-3">
            <a href="<?= base_url('atasan/dokumen/export_excel_arsip') ?>" 
               class="inline-flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-3 rounded-2xl font-bold shadow-lg shadow-emerald-200 transition-all hover:-translate-y-1 active:scale-95 text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Export Excel
            </a>

            <a href="<?= base_url('atasan/dokumen/export_pdf') ?>" 
               class="inline-flex items-center justify-center gap-2 bg-slate-900 hover:bg-blue-600 text-white px-5 py-3 rounded-2xl font-bold shadow-lg shadow-slate-200 transition-all hover:-translate-y-1 active:scale-95 text-sm">
                <svg class="w-4 h-4 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                </svg>
                Export PDF
            </a>
        </div>
    </div>

    <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-xl shadow-slate-200/50 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-100">
                        <th class="px-8 py-6 text-left text-[11px] font-black text-slate-400 uppercase tracking-widest">Detail Dokumen</th>
                        <th class="px-8 py-6 text-center text-[11px] font-black text-slate-400 uppercase tracking-widest">Unit Asal</th>
                        <th class="px-8 py-6 text-center text-[11px] font-black text-slate-400 uppercase tracking-widest">Tgl Selesai</th>
                        <th class="px-8 py-6 text-center text-[11px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                        <th class="px-8 py-6 text-right text-[11px] font-black text-slate-400 uppercase tracking-widest">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <?php if (!empty($dokumen)): ?>
                        <?php foreach ($dokumen as $d): ?>
                        <tr class="group hover:bg-blue-50/30 transition-colors">
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-11 h-11 bg-slate-50 rounded-xl flex items-center justify-center border border-slate-100 text-slate-400 group-hover:bg-white group-hover:text-blue-600 transition-all duration-300">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="block font-black text-slate-700 leading-tight group-hover:text-blue-600 transition-colors"><?= esc($d['judul']) ?></span>
                                        <span class="text-[10px] text-slate-400 font-bold tracking-tighter uppercase mt-1 block">Ref ID: #<?= esc($d['id']) ?></span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6 text-center">
                                <span class="text-[10px] font-black text-blue-600 bg-blue-50 border border-blue-100 px-3 py-1 rounded-lg uppercase tracking-wider">
                                    Unit <?= esc($d['unit_asal_id']) ?>
                                </span>
                            </td>
                            <td class="px-8 py-6 text-center">
                                <span class="text-xs font-bold text-slate-600">
                                    <?= date('d/m/Y', strtotime($d['updated_at'])) ?>
                                </span>
                            </td>
                            <td class="px-8 py-6 text-center">
                                <span class="inline-flex items-center px-4 py-1.5 rounded-xl border border-emerald-100 bg-emerald-50 text-emerald-700 text-[10px] font-black uppercase tracking-wider shadow-sm">
                                    <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Verified
                                </span>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <a href="<?= base_url('uploads/dokumen/'.$d['file_path']) ?>" target="_blank" 
                                   class="inline-flex items-center gap-2 bg-white border border-slate-200 text-slate-600 hover:text-blue-600 hover:border-blue-200 hover:shadow-md px-4 py-2.5 rounded-xl text-[11px] font-black transition-all uppercase tracking-widest">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-width="2"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" stroke-width="2"/>
                                    </svg>
                                    Buka Arsip
                                </a>
                            </td>
                        </tr>
                        <?php endforeach ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="px-8 py-20 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center text-slate-200 mb-4">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                        </svg>
                                    </div>
                                    <p class="text-slate-400 font-bold text-sm italic tracking-tight">Belum ada dokumen yang disetujui untuk ditampilkan.</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-8 p-6 bg-white rounded-3xl border border-slate-200 flex flex-col md:flex-row items-center gap-6 justify-between shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center text-blue-900 shadow-sm border border-slate-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04M12 2.944V22m0-19.056c1.11 0 2.129.454 2.872 1.186m-5.744 0a4.052 4.052 0 012.872-1.186" />
                </svg>
            </div>
            <div>
                <p class="text-xs text-slate-600 font-bold uppercase tracking-wide">Official Tier Access</p>
                <p class="text-[11px] text-slate-400 mt-0.5 font-medium leading-relaxed">Seluruh arsip ini telah divalidasi dan tersinkronisasi dengan sistem pusat E-Kinerja Polban.</p>
            </div>
        </div>
        <div class="flex gap-2">
            <span class="text-[10px] font-black text-slate-300 uppercase tracking-[0.3em]">SECURE SYSTEM</span>
        </div>
    </div>

    <div class="mt-20 pt-8 border-t border-slate-200 flex items-center justify-between opacity-50">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 bg-slate-200 rounded-lg flex items-center justify-center font-black text-slate-500 text-[10px]">KT</div>
            <p class="text-[10px] text-slate-500 font-black tracking-widest uppercase">
                Archive Management &copy; <?= date('Y') ?> <span class="text-slate-900">KINETRACK</span>
            </p>
        </div>
    </div>
</div>

<?= $this->endSection() ?>