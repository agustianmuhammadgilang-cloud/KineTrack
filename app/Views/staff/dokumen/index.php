<?= $this->extend('layout/staff_template') ?>
<?= $this->section('content') ?>

<div class="min-h-screen bg-slate-50 px-6 py-8 font-sans text-slate-800">

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight flex items-center gap-3">
                <span class="w-2 h-8 bg-blue-600 rounded-full"></span>
                Dokumen Saya
            </h1>
            <p class="text-slate-500 mt-1 text-sm font-medium ml-5">
                Pusat kendali berkas dan riwayat pengajuan kinerja Anda.
            </p>
        </div>

        <a href="<?= base_url('staff/dokumen/create') ?>"
           class="inline-flex items-center justify-center gap-2 bg-slate-900 hover:bg-blue-600 text-white px-6 py-3.5 rounded-2xl font-bold shadow-xl shadow-slate-200 transition-all hover:-translate-y-1 active:scale-95 group">
            <div class="p-1 bg-white/20 rounded-lg group-hover:bg-white/30 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/>
                </svg>
            </div>
            Upload Dokumen Baru
        </a>
    </div>

    <?php if (empty($dokumen)): ?>
        <div class="bg-white border-2 border-dashed border-slate-200 rounded-[2rem] p-20 text-center shadow-sm">
            <div class="mx-auto w-24 h-24 bg-slate-50 rounded-3xl flex items-center justify-center mb-6 text-slate-300 transform -rotate-12">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <h5 class="text-2xl font-bold text-slate-800 tracking-tight">Belum ada arsip</h5>
            <p class="text-slate-400 mt-2 max-w-sm mx-auto leading-relaxed">Ruang penyimpanan Anda masih kosong. Tekan tombol di atas untuk mulai mengunggah dokumen pertama Anda.</p>
        </div>
    <?php else: ?>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-8">
        <?php foreach ($dokumen as $d): ?>

            <?php
            $statusStyles = [
                'pending_kaprodi'  => ['label' => 'Review Kaprodi', 'class' => 'bg-amber-50 text-amber-700 border-amber-100', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                'pending_kajur'    => ['label' => 'Review Kajur',    'class' => 'bg-indigo-50 text-indigo-700 border-indigo-100', 'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'],
                'rejected_kaprodi' => ['label' => 'Revisi Kaprodi',  'class' => 'bg-rose-50 text-rose-700 border-rose-100', 'icon' => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z'],
                'rejected_kajur'   => ['label' => 'Revisi Kajur',    'class' => 'bg-rose-50 text-rose-700 border-rose-100', 'icon' => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z'],
                'archived'         => ['label' => 'Tersimpan',       'class' => 'bg-emerald-50 text-emerald-700 border-emerald-100', 'icon' => 'M5 13l4 4L19 7'],
            ];
            $style = $statusStyles[$d['status']] ?? ['label' => $d['status'], 'class' => 'bg-slate-100 text-slate-600', 'icon' => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'];
            ?>

            <div class="group bg-white rounded-3xl border border-slate-200 transition-all duration-500 hover:shadow-2xl hover:shadow-blue-900/5 hover:border-blue-200 flex flex-col relative overflow-hidden">
                
                <div class="absolute top-0 right-0 w-40 h-40 -mr-20 -mt-20 bg-slate-50 rounded-full opacity-40 group-hover:bg-blue-50 group-hover:scale-150 transition-all duration-700"></div>

                <div class="p-7 relative flex-1">
                    <div class="flex items-start justify-between mb-6">
                        <div class="p-3 bg-slate-50 rounded-2xl group-hover:bg-blue-50 transition-colors duration-500">
                            <svg class="w-8 h-8 text-slate-400 group-hover:text-blue-500 transition-colors duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <span class="inline-flex items-center px-4 py-1.5 rounded-xl border text-[11px] font-black uppercase tracking-wider shadow-sm <?= $style['class'] ?>">
                            <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="<?= $style['icon'] ?>" />
                            </svg>
                            <?= $style['label'] ?>
                        </span>
                    </div>

                    <div class="mb-6">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="px-2 py-0.5 bg-slate-100 text-slate-500 text-[10px] font-bold rounded-md tracking-tighter uppercase">ID #<?= $d['id'] ?></span>
                            <span class="w-1 h-1 bg-slate-300 rounded-full"></span>
                            <span class="text-[11px] font-bold text-slate-400 tracking-wide uppercase italic"><?= date('d M Y', strtotime($d['created_at'])) ?></span>
                        </div>
                        <h5 class="text-xl font-black text-slate-800 leading-tight tracking-tight group-hover:text-blue-600 transition-colors line-clamp-2">
                            <?= esc($d['judul']) ?>
                        </h5>
                    </div>

                    <div class="bg-slate-50/80 backdrop-blur-sm rounded-2xl p-5 border border-slate-100 group-hover:bg-white group-hover:border-blue-100 transition-all">
                        <div class="flex items-center gap-2 mb-2">
                            <div class="w-5 h-5 bg-white rounded-md flex items-center justify-center shadow-sm border border-slate-100">
                                <svg class="w-3 h-3 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" />
                                </svg>
                            </div>
                            <h6 class="text-[10px] font-black text-slate-500 uppercase tracking-[0.1em]">Komentar Terbaru</h6>
                        </div>
                        <p class="text-sm text-slate-600 leading-relaxed line-clamp-3">
                            <?= esc($d['catatan'] ?? 'Belum ada umpan balik dari tim verifikator.') ?>
                        </p>
                    </div>
                </div>

                <div class="px-7 py-5 bg-slate-50/50 border-t border-slate-100 flex items-center justify-between group-hover:bg-blue-50/30 transition-colors rounded-b-3xl">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-white border border-slate-200 flex items-center justify-center font-black text-[11px] text-blue-600 shadow-sm group-hover:scale-110 transition-transform">PDF</div>
                        <div class="flex flex-col">
                            <span class="text-[10px] font-bold text-slate-400 uppercase leading-none mb-0.5 tracking-tighter">Ekstensi Berkas</span>
                            <span class="text-xs font-black text-slate-700 leading-none tracking-tight">Dokumen Digital</span>
                        </div>
                    </div>

                    <?php if (in_array($d['status'], ['rejected_kaprodi', 'rejected_kajur'])): ?>
                        <a href="<?= base_url('staff/dokumen/resubmit/'.$d['id']) ?>"
                           class="flex items-center gap-2 bg-rose-600 hover:bg-rose-700 text-white px-5 py-2.5 rounded-xl text-xs font-black shadow-lg shadow-rose-200 transition-all hover:scale-105 active:scale-95">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            PERBAIKI DOKUMEN
                        </a>
                    <?php endif ?>
                </div>
            </div>
        <?php endforeach ?>
    </div>
    <?php endif; ?>

    <div class="mt-20 pt-8 border-t border-slate-200/60 flex flex-col md:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-3 opacity-60">
            <div class="w-10 h-10 bg-white border border-slate-200 rounded-xl flex items-center justify-center font-black text-slate-400 text-sm shadow-sm">KT</div>
            <p class="text-xs text-slate-400 font-bold tracking-widest uppercase">
                Monitoring Sistem &copy; <?= date('Y') ?> <span class="text-slate-900 font-black">KINETRACK</span>
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
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;  
        overflow: hidden;
    }
</style>

<?= $this->endSection() ?>