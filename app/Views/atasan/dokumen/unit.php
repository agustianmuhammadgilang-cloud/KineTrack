<?= $this->extend('layout/atasan_template') ?>
<?= $this->section('content') ?>

<div class="min-h-screen bg-slate-50 px-6 py-8 font-sans text-slate-800">

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center text-blue-600 shadow-xl shadow-blue-900/5 border border-slate-100">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <div>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight leading-none">
                    Dokumen Unit Kerja
                </h1>
                <p class="text-xs text-slate-400 mt-2 font-black uppercase tracking-[0.2em]">Kolaborasi & Arsip Bersama Anggota Unit</p>
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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
            <h3 class="text-xl font-black text-slate-800 tracking-tight">Belum Ada Dokumen Unit</h3>
            <p class="text-sm text-slate-400 mt-2 font-medium max-w-xs mx-auto">
                Dokumen unit yang telah masuk ke sistem akan muncul secara otomatis di galeri ini.
            </p>
        </div>
    <?php else: ?>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
        <?php foreach ($dokumen as $d): ?>
            <?php
                $statusMap = [
                    'pending_kaprodi'  => ['Dalam Proses', 'bg-amber-50 text-amber-600 border-amber-100'],
                    'pending_kajur'    => ['Dalam Proses', 'bg-amber-50 text-amber-600 border-amber-100'],
                    'rejected_kaprodi' => ['Ditolak', 'bg-rose-50 text-rose-600 border-rose-100'],
                    'rejected_kajur'   => ['Ditolak', 'bg-rose-50 text-rose-600 border-rose-100'],
                    'archived'         => ['Disetujui', 'bg-emerald-50 text-emerald-600 border-emerald-100'],
                ];
                [$label, $class] = $statusMap[$d['status']] ?? [ucfirst($d['status']), 'bg-slate-100 text-slate-600 border-slate-200'];
            ?>

            <div class="group bg-white rounded-[2rem] border border-slate-200 shadow-xl shadow-slate-200/40 hover:shadow-blue-900/10 transition-all duration-300 flex flex-col overflow-hidden hover:-translate-y-2">
                
                <div class="p-6 border-b border-slate-50 relative">
                    <div class="flex items-start justify-between gap-4 mb-4">
                        <div class="w-10 h-10 bg-slate-50 rounded-xl flex items-center justify-center text-slate-400 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <span class="px-3 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-wider border <?= $class ?> shadow-sm">
                            <?= $label ?>
                        </span>
                    </div>

                    <h5 class="font-black text-slate-800 leading-tight group-hover:text-blue-600 transition-colors line-clamp-2 min-h-[2.5rem]">
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
                    <p class="text-xs font-medium text-slate-500 leading-relaxed line-clamp-3">
                        <?= esc($d['deskripsi'] ?? 'Tidak ada deskripsi tambahan untuk berkas unit ini.') ?>
                    </p>

                    <div class="grid grid-cols-1 gap-y-2.5 pt-4 border-t border-slate-200/50">
                        <div class="flex items-center justify-between">
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-tighter">Kategori</span>
                            <span class="text-[11px] font-bold text-slate-700"><?= esc($d['nama_kategori'] ?? '-') ?></span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-tighter">Pengirim</span>
                            <span class="text-[11px] font-bold text-slate-700"><?= esc($d['nama_pengirim'] ?? '-') ?></span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-tighter">Jabatan/Unit</span>
                            <span class="text-[11px] font-bold text-blue-600 truncate max-w-[150px] text-right">
                                <?= esc($d['nama_jabatan'] ?? '-') ?> (<?= esc($d['nama_unit'] ?? '-') ?>)
                            </span>
                        </div>
                    </div>
                </div>

                <div class="p-6 pt-0">
                    <a href="<?= base_url('uploads/dokumen/'.$d['file_path']) ?>"
                       target="_blank"
                       class="w-full inline-flex items-center justify-center gap-2 bg-white border border-slate-200 text-slate-600 hover:text-blue-600 hover:border-blue-200 py-3.5 rounded-2xl text-[11px] font-black uppercase tracking-widest transition-all shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-width="2"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" stroke-width="2"/>
                        </svg>
                        Buka Dokumen
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
                Unit Workspace &copy; <?= date('Y') ?> <span class="text-slate-900">KINETRACK</span>
            </p>
        </div>
    </div>
</div>

<?= $this->endSection() ?>