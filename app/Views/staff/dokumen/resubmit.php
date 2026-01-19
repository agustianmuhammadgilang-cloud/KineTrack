<?= $this->extend('layout/staff_template') ?>
<?= $this->section('content') ?>

<div class="min-h-screen bg-slate-50 px-6 py-8 font-sans text-slate-800">

    <div class="max-w-2xl mx-auto space-y-6">
        
        <div class="flex items-center justify-between border-b pb-6 border-slate-200">
            <div>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight flex items-center gap-3">
                    <span class="w-1.5 h-6 bg-rose-500 rounded-full"></span>
                    Revisi Dokumen
                </h1>
                <p class="text-sm text-slate-500 mt-1 font-medium">Perbarui berkas Anda berdasarkan catatan penolakan.</p>
            </div>
            <div class="bg-rose-50 p-3 rounded-2xl text-rose-500 shadow-sm border border-rose-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
            </div>
        </div>

        <div class="bg-rose-50/50 border border-rose-100 rounded-2xl p-5 shadow-sm relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-2 opacity-10 group-hover:scale-110 transition-transform">
                <svg class="w-16 h-16 text-rose-600" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7z" />
                </svg>
            </div>
            <div class="relative flex gap-4">
                <div class="shrink-0">
                    <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center shadow-sm border border-rose-100 text-rose-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M5.07 19h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.34 16c-.77 1.33.19 3 1.73 3z"/>
                        </svg>
                    </div>
                </div>
                <div>
                    <span class="block text-[11px] font-black text-rose-800 uppercase tracking-[0.15em] mb-1">Instruksi Verifikator:</span>
                    <p class="text-sm text-rose-700 leading-relaxed italic font-medium">
                        "<?= esc($dokumen['catatan']) ?>"
                    </p>
                </div>
            </div>
        </div>

        <form action="<?= base_url('staff/dokumen/resubmit/'.$dokumen['id']) ?>" 
              method="post" 
              enctype="multipart/form-data" 
              class="bg-white rounded-[2rem] shadow-xl shadow-slate-200/60 border border-slate-200 p-8 space-y-6">

            <?= csrf_field() ?>

            <div class="space-y-2">
                <label class="block text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Judul Dokumen</label>
                <input type="text" name="judul" value="<?= esc($dokumen['judul']) ?>" required
                       class="w-full rounded-2xl border-slate-200 bg-slate-50/50 text-sm font-bold text-slate-700 focus:ring-4 focus:ring-blue-100 focus:border-blue-500 py-3.5 px-5 transition-all outline-none">
            </div>

            <div class="space-y-2">
                <label class="block text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Keterangan Perbaikan</label>
                <textarea name="deskripsi" rows="3" placeholder="Jelaskan apa saja yang telah diperbaiki..."
                          class="w-full rounded-2xl border-slate-200 bg-slate-50/50 text-sm font-medium text-slate-700 focus:ring-4 focus:ring-blue-100 focus:border-blue-500 py-3.5 px-5 transition-all outline-none resize-none"><?= esc($dokumen['deskripsi']) ?></textarea>
            </div>

            <div class="space-y-2" x-data="{ fileName: '' }">
                <label class="block text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Upload Berkas Baru (PDF)</label>
                <div class="relative group">
                    <input type="file" name="file" id="file_upload" required @change="fileName = $event.target.files[0].name"
                           class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                    <div class="border-2 border-dashed border-slate-200 rounded-2xl p-8 text-center bg-slate-50/30 group-hover:bg-blue-50/50 group-hover:border-blue-300 transition-all duration-300">
                        
                        <div x-show="!fileName" class="flex flex-col items-center gap-3">
                            <div class="w-12 h-12 bg-white rounded-xl shadow-sm border border-slate-100 flex items-center justify-center text-slate-400 group-hover:text-blue-500 transition-colors duration-300">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-slate-600">Pilih berkas atau tarik ke sini</p>
                                <p class="text-xs text-slate-400 mt-1 uppercase tracking-tighter font-medium">Format: PDF (Max. 2MB)</p>
                            </div>
                        </div>

                        <div x-show="fileName" class="flex items-center justify-center gap-3 animate-pulse">
                            <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center text-white shadow-lg">
                                <span class="text-[10px] font-black">PDF</span>
                            </div>
                            <div class="text-left">
                                <span class="block text-sm font-black text-blue-600 truncate max-w-[250px]" x-text="fileName"></span>
                                <span class="text-[10px] text-slate-400 uppercase font-bold tracking-widest">Siap diunggah</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between pt-6 border-t border-slate-100">
                <a href="<?= base_url('staff/dokumen') ?>"
                   class="group flex items-center gap-2 text-[11px] font-black text-slate-400 hover:text-slate-600 uppercase tracking-widest transition-all">
                    <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M10 19l-7-7m0 0l7-7m-7 7h18" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    Kembali
                </a>

                <button type="submit"
                        class="bg-blue-600 hover:bg-slate-900 text-white text-xs font-black px-8 py-4 rounded-2xl shadow-xl shadow-blue-200 hover:shadow-slate-200 transition-all transform active:scale-95 flex items-center gap-3 uppercase tracking-[0.1em]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                    Kirim Perbaikan
                </button>
            </div>
        </form>

        <div class="pt-6 flex justify-center opacity-40">
            <div class="flex items-center gap-2">
                <div class="w-6 h-6 bg-slate-200 rounded-md flex items-center justify-center font-black text-slate-400 text-[10px]">KT</div>
                <p class="text-[10px] text-slate-400 font-bold tracking-[0.2em] uppercase">
                    Revision System Hub &bull; Kinetrack
                </p>
            </div>
        </div>

    </div>
</div>

<?= $this->endSection() ?>