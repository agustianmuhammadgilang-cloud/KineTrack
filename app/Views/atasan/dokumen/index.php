<?= $this->extend('layout/atasan_template') ?>
<?= $this->section('content') ?>

<div class="min-h-screen bg-slate-50 px-6 py-8 font-sans text-slate-800">

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight flex items-center gap-3">
                <span class="w-2 h-8 bg-indigo-600 rounded-full"></span>
                Dokumen Masuk
            </h1>
            <p class="text-slate-500 mt-1 text-sm font-medium ml-5">
                Verifikasi dan review pengajuan kinerja dari unit kerja Anda.
            </p>
        </div>

        <div class="flex items-center gap-3 bg-white px-5 py-3 rounded-2xl border border-slate-200 shadow-sm">
            <div class="w-10 h-10 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none">Antrean</p>
                <p class="text-lg font-black text-slate-800 leading-none"><?= count($dokumen) ?> <span class="text-xs font-bold text-slate-400 uppercase">Berkas</span></p>
            </div>
        </div>
    </div>

    <?php if (empty($dokumen)): ?>
        <div class="bg-white border-2 border-dashed border-slate-200 rounded-[2rem] p-20 text-center shadow-sm">
            <div class="mx-auto w-24 h-24 bg-slate-50 rounded-3xl flex items-center justify-center mb-6 text-slate-300 transform rotate-12">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                </svg>
            </div>
            <h5 class="text-2xl font-bold text-slate-800 tracking-tight">Kotak Masuk Kosong</h5>
            <p class="text-slate-400 mt-2 max-w-sm mx-auto leading-relaxed">Belum ada dokumen baru yang memerlukan persetujuan Anda saat ini.</p>
        </div>
    <?php else: ?>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <?php foreach ($dokumen as $d): ?>
            <div class="group bg-white rounded-3xl border border-slate-200 transition-all duration-500 hover:shadow-2xl hover:shadow-indigo-900/5 hover:border-indigo-200 flex flex-col relative overflow-hidden">
                
                <div class="absolute top-0 right-0 w-40 h-40 -mr-20 -mt-20 bg-slate-50 rounded-full opacity-40 group-hover:bg-indigo-50 group-hover:scale-150 transition-all duration-700"></div>

                <div class="p-7 relative flex-1">
                    <div class="flex items-start justify-between mb-6">
                        <div class="p-3 bg-slate-50 rounded-2xl group-hover:bg-indigo-50 transition-colors duration-500">
                            <svg class="w-8 h-8 text-slate-400 group-hover:text-indigo-500 transition-colors duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <span class="inline-flex items-center px-4 py-1.5 rounded-xl border border-amber-100 bg-amber-50 text-amber-700 text-[11px] font-black uppercase tracking-wider shadow-sm">
                            <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Menunggu Review
                        </span>
                    </div>

                    <div class="mb-6">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="px-2 py-0.5 bg-indigo-100 text-indigo-600 text-[10px] font-bold rounded-md tracking-tighter uppercase">ID #<?= $d['id'] ?></span>
                            <span class="w-1 h-1 bg-slate-300 rounded-full"></span>
                            <span class="text-[11px] font-bold text-slate-400 tracking-wide uppercase italic">Dikirim: <?= date('d M Y', strtotime($d['created_at'])) ?></span>
                        </div>
                        <h5 class="text-xl font-black text-slate-800 leading-tight tracking-tight group-hover:text-indigo-600 transition-colors line-clamp-2">
                            <?= esc($d['judul']) ?>
                        </h5>
                    </div>

                    <div class="bg-slate-50/80 backdrop-blur-sm rounded-2xl p-5 border border-slate-100 group-hover:bg-white group-hover:border-indigo-100 transition-all">
                        <div class="flex items-center gap-2 mb-2">
                            <div class="w-5 h-5 bg-white rounded-md flex items-center justify-center shadow-sm border border-slate-100">
                                <svg class="w-3 h-3 text-indigo-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <h6 class="text-[10px] font-black text-slate-500 uppercase tracking-[0.1em]">Informasi Pengirim</h6>
                        </div>
                        <p class="text-sm text-slate-700 font-bold leading-none">
                            Unit: <?= esc($d['nama_unit_asal'] ?? '-') ?>
                        </p>
                        <p class="text-[11px] text-slate-400 mt-1">Status: Pegawai Aktif</p>
                    </div>
                </div>

                <div class="px-7 py-5 bg-slate-50/50 border-t border-slate-100 flex items-center justify-between group-hover:bg-indigo-50/30 transition-colors rounded-b-3xl">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-white border border-slate-200 flex items-center justify-center font-black text-[11px] text-indigo-600 shadow-sm group-hover:scale-110 transition-transform">PDF</div>
                        <div class="flex flex-col">
                            <span class="text-[10px] font-bold text-slate-400 uppercase leading-none mb-0.5 tracking-tighter">Status Berkas</span>
                            <span class="text-xs font-black text-slate-700 leading-none tracking-tight">Siap Review</span>
                        </div>
                    </div>

                    <a href="<?= base_url('atasan/dokumen/review/'.$d['id']) ?>"
                       class="flex items-center gap-2 bg-slate-900 hover:bg-indigo-600 text-white px-6 py-3 rounded-xl text-xs font-black shadow-xl shadow-slate-200 transition-all hover:scale-105 active:scale-95">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        REVIEW DOKUMEN
                    </a>
                </div>
            </div>
        <?php endforeach ?>
    </div>
    <?php endif; ?>

    <div class="mt-20 pt-8 border-t border-slate-200/60 flex flex-col md:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-3 opacity-60">
            <div class="w-10 h-10 bg-white border border-slate-200 rounded-xl flex items-center justify-center font-black text-slate-400 text-sm shadow-sm">KT</div>
            <p class="text-xs text-slate-400 font-bold tracking-widest uppercase">
                Sistem Verifikasi &copy; <?= date('Y') ?> <span class="text-slate-900 font-black">KINETRACK</span>
            </p>
        </div>
    </div>
</div>

<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;  
        overflow: hidden;
    }
</style>

<?= $this->endSection() ?>