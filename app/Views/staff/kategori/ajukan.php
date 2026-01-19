<?= $this->extend('layout/staff_template') ?>
<?= $this->section('content') ?>

<div class="min-h-screen bg-slate-50 px-6 py-8 font-sans text-slate-800">

    <div class="max-w-2xl mx-auto space-y-6">

        <div class="flex items-center justify-between border-b pb-6 border-slate-200">
            <div>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight flex items-center gap-3">
                    <span class="w-1.5 h-6 bg-blue-600 rounded-full"></span>
                    Ajukan Kategori
                </h1>
                <p class="text-sm text-slate-500 mt-1 font-medium">Usulkan kategori baru untuk klasifikasi dokumen kinerja.</p>
            </div>
            <div class="bg-blue-50 p-3 rounded-2xl text-blue-600 shadow-sm border border-blue-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
            </div>
        </div>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="bg-rose-50 border border-rose-100 rounded-2xl p-4 flex items-center gap-3 text-rose-700 shadow-sm">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-xs font-bold uppercase tracking-tight"><?= session()->getFlashdata('error') ?></p>
            </div>
        <?php endif; ?>

        <div class="bg-white rounded-[2rem] shadow-xl shadow-slate-200/60 border border-slate-200 p-8 relative overflow-hidden group">
            
            <div class="absolute top-0 right-0 w-32 h-32 -mr-16 -mt-16 bg-blue-50 rounded-full opacity-40 group-hover:scale-110 transition-transform duration-700"></div>

            <form action="<?= base_url('staff/kategori/ajukan/store') ?>" 
                  method="post" 
                  class="relative space-y-6">
                
                <?= csrf_field() ?>

                <div class="space-y-2">
                    <label class="block text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">
                        Nama Kategori <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="nama_kategori" required
                           placeholder="Contoh: Kerja Sama, Sarana Prasarana"
                           class="w-full rounded-2xl border-slate-200 bg-slate-50/50 text-sm font-bold text-slate-700 focus:ring-4 focus:ring-blue-100 focus:border-blue-500 py-3.5 px-5 transition-all outline-none">
                    <p class="text-[10px] text-slate-400 font-medium ml-1">Gunakan penamaan yang ringkas untuk memudahkan filter dokumen.</p>
                </div>

                <div class="space-y-2">
                    <label class="block text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">
                        Deskripsi (Opsional)
                    </label>
                    <textarea name="deskripsi" rows="4" 
                              placeholder="Jelaskan tujuan atau cakupan dari kategori dokumen ini..."
                              class="w-full rounded-2xl border-slate-200 bg-slate-50/50 text-sm font-medium text-slate-700 focus:ring-4 focus:ring-blue-100 focus:border-blue-500 py-3.5 px-5 transition-all outline-none resize-none"></textarea>
                </div>

                <div class="bg-amber-50 border border-amber-100 rounded-2xl p-4 flex gap-3">
                    <div class="shrink-0 w-8 h-8 bg-white rounded-lg flex items-center justify-center text-amber-500 shadow-sm border border-amber-100">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <p class="text-[11px] text-amber-700 leading-relaxed font-medium mt-0.5">
                        <span class="font-black uppercase block mb-0.5">Catatan Verifikasi:</span>
                        Kategori yang Anda ajukan akan diverifikasi oleh Admin terlebih dahulu sebelum muncul pada daftar kategori upload.
                    </p>
                </div>

                <div class="flex items-center justify-between pt-6 border-t border-slate-100">
                    <a href="<?= base_url('staff/dokumen/create') ?>"
                       class="group flex items-center gap-2 text-[11px] font-black text-slate-400 hover:text-slate-600 uppercase tracking-widest transition-all">
                        <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M10 19l-7-7m0 0l7-7m-7 7h18" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Batal
                    </a>

                    <button type="submit"
                            class="bg-blue-600 hover:bg-slate-900 text-white text-xs font-black px-8 py-4 rounded-2xl shadow-xl shadow-blue-200 hover:shadow-slate-200 transition-all transform active:scale-95 flex items-center gap-3 uppercase tracking-[0.1em]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                        Ajukan Kategori
                    </button>
                </div>
            </form>
        </div>

        <div class="pt-6 flex justify-center opacity-40">
            <div class="flex items-center gap-2">
                <div class="w-6 h-6 bg-slate-200 rounded-md flex items-center justify-center font-black text-slate-400 text-[10px]">KT</div>
                <p class="text-[10px] text-slate-400 font-bold tracking-[0.2em] uppercase">
                    Category Management System &bull; Kinetrack
                </p>
            </div>
        </div>

    </div>
</div>

<?= $this->endSection() ?>