<?= $this->extend('layout/atasan_template') ?>
<?= $this->section('content') ?>

<div class="min-h-screen bg-slate-50 px-6 py-8 font-sans text-slate-800">

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <a href="<?= base_url('atasan/task') ?>" class="p-2 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 text-slate-500 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </a>
                <span class="text-xs font-bold text-blue-600 uppercase tracking-widest">Input Capaian Kinerja (Atasan)</span>
            </div>
            <h1 class="text-3xl font-bold text-slate-900 tracking-tight">
                Triwulan <?= esc($tw) ?> — Pengukuran
            </h1>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-1 space-y-6">
            
            <div class="bg-gradient-to-br from-blue-600 to-blue-700 rounded-2xl p-6 text-white shadow-lg shadow-blue-200">
                <div class="flex items-center gap-3 mb-4">
                    <div class="p-2 bg-white/20 rounded-lg backdrop-blur-sm text-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    <h4 class="font-bold tracking-tight">Informasi Target TW</h4>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <?php foreach ([1, 2, 3, 4] as $t): ?>
                    <div class="p-3 rounded-xl <?= $t == $tw ? 'bg-white/20 border border-white/30' : 'bg-black/5' ?>">
                        <p class="text-[10px] font-bold uppercase opacity-70">TW <?= $t ?></p>
                        <p class="text-lg font-black"><?= esc($target_tw[$t] ?? '0') ?></p>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm">
                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Detail Indikator</h4>
                <div class="space-y-4">
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase">Sasaran Strategis</p>
                        <p class="text-sm font-semibold text-slate-700 mt-0.5 leading-snug"><?= esc($sasaran['nama_sasaran']) ?></p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase">Indikator</p>
                        <p class="text-sm font-semibold text-slate-700 mt-0.5 leading-snug"><?= esc($indikator['nama_indikator']) ?></p>
                    </div>
                    <div class="flex justify-between border-t border-slate-50 pt-4">
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase">Satuan</p>
                            <p class="text-sm font-bold text-slate-700"><?= esc($indikator['satuan']) ?></p>
                        </div>
                        <div class="text-right">
                            <p class="text-[10px] font-bold text-slate-400 uppercase">Target PK <?= $tahun ?></p>
                            <p class="text-sm font-bold text-blue-600"><?= esc($indikator['target_pk']) ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-slate-800 rounded-2xl p-6 text-white shadow-sm">
                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">PIC Terkait</h4>
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-full bg-slate-700 flex items-center justify-center font-bold text-slate-300">
                        <?= substr(esc($pic['nama']), 0, 1) ?>
                    </div>
                    <div>
                        <p class="text-sm font-bold"><?= esc($pic['nama']) ?></p>
                        <p class="text-[10px] text-slate-400 font-medium tracking-wide uppercase mt-0.5"><?= esc($pic['nama_bidang'] ?? 'Staf') ?> / <?= esc($pic['nama_jabatan']) ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                    <div class="flex items-center gap-2">
                        <div class="w-1.5 h-5 bg-blue-600 rounded-full"></div>
                        <h4 class="text-lg font-bold text-slate-800">Form Pengisian</h4>
                    </div>
                </div>
                
                <form action="<?= base_url('atasan/task/store') ?>" method="post" enctype="multipart/form-data" class="p-8 space-y-6">
                    <input type="hidden" name="indikator_id" value="<?= esc($indikator_id) ?>">
                    <input type="hidden" name="triwulan" value="<?= esc($tw) ?>">
                    <input type="hidden" name="tahun" value="<?= esc($tahun) ?>">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Realisasi</label>
                            <input type="number" name="realisasi" step="any" min="0" required
                                   class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 font-bold text-slate-800 focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all"
                                   placeholder="Masukkan realisasi...">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Progress / Kegiatan</label>
                            <textarea name="progress" rows="3" required
                                      class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-slate-700 focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all"
                                      placeholder="Uraikan detail kegiatan..."></textarea>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 text-rose-500">Kendala</label>
                            <textarea name="kendala" rows="3"
                                      class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-slate-700 focus:bg-white focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 outline-none transition-all"
                                      placeholder="Hambatan yang ditemukan..."></textarea>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 text-emerald-500">Strategi</label>
                            <textarea name="strategi" rows="3"
                                      class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-slate-700 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 outline-none transition-all"
                                      placeholder="Langkah tindak lanjut..."></textarea>
                        </div>
                    </div>

                    <div x-data="fileUpload()" class="space-y-4 pt-4">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider">File Bukti Dukung</label>
                        
                        <div class="relative group border-2 border-dashed border-slate-200 rounded-2xl p-8 transition-all hover:bg-slate-50 hover:border-blue-400 text-center cursor-pointer"
                             @click="$refs.input.click()"
                             @dragover.prevent="drag = true"
                             @dragleave.prevent="drag = false"
                             @drop.prevent="handleDrop($event)"
                             :class="drag ? 'border-blue-500 bg-blue-50' : ''">
                            
                            <input type="file" name="file_dukung[]" multiple class="hidden" x-ref="input" @change="handleFileSelect">
                            
                            <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </div>
                            <p class="text-sm font-bold text-slate-700">Tarik file ke sini atau klik untuk mencari</p>
                            <p class="text-xs text-slate-400 mt-1">Dapat mengunggah lebih dari satu file</p>
                        </div>

                        <template x-if="files.length > 0">
                            <div class="grid grid-cols-1 gap-2 mt-4">
                                <template x-for="(file, index) in files" :key="index">
                                    <div class="flex items-center justify-between bg-slate-50 border border-slate-200 p-3 rounded-xl">
                                        <div class="flex items-center gap-3">
                                            <div class="p-2 bg-white rounded-lg text-blue-500 shadow-sm">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" stroke-width="2"/></svg>
                                            </div>
                                            <div>
                                                <p class="text-xs font-bold text-slate-700 truncate max-w-[200px]" x-text="file.name"></p>
                                                <p class="text-[10px] text-slate-400 uppercase font-medium" x-text="(file.size/1024).toFixed(1) + ' KB'"></p>
                                            </div>
                                        </div>
                                        <button type="button" @click="removeFile(index)" class="p-2 text-rose-500 hover:bg-rose-50 rounded-lg transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                        </button>
                                    </div>
                                </template>
                            </div>
                        </template>
                    </div>

                    <div class="pt-6 border-t border-slate-100 flex justify-end">
                        <button type="submit"
                                class="flex items-center gap-2 px-8 py-3 bg-blue-600 text-white rounded-xl font-bold shadow-lg shadow-blue-200 hover:bg-blue-700 hover:-translate-y-0.5 transition-all">
                            <span>Simpan Capaian</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="mt-16 pt-8 border-t border-slate-200 flex flex-col md:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 bg-slate-200 rounded-lg flex items-center justify-center font-bold text-slate-400 text-xs">KT</div>
            <p class="text-xs text-slate-400 font-medium tracking-wide uppercase">
                © <?= date('Y') ?> <span class="text-slate-600 font-bold">KINETRACK</span> — Politeknik Negeri Bandung
            </p>
        </div>
    </div>
</div>

<?= $this->endSection() ?>