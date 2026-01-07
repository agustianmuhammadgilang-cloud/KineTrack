<?= $this->extend('layout/staff_template') ?>
<?= $this->section('content') ?>

<div class="max-w-md mx-auto my-2 space-y-4">

    <div class="flex items-center justify-between border-b pb-3 border-gray-100">
        <div>
            <h4 class="text-lg font-bold text-gray-800 tracking-tight">Revisi Dokumen</h4>
            <p class="text-[11px] text-gray-500">Perbaiki berkas sesuai instruksi atasan</p>
        </div>
        <div class="bg-orange-50 p-2 rounded-lg text-orange-500">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
        </div>
    </div>

    <div class="bg-red-50 border border-red-100 rounded-lg p-3">
        <div class="flex gap-2">
            <svg class="w-4 h-4 text-red-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M5.07 19h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.34 16c-.77 1.33.19 3 1.73 3z"/></svg>
            <div>
                <span class="block text-[10px] font-bold text-red-800 uppercase">Instruksi Atasan:</span>
                <p class="text-xs text-red-700 leading-snug italic">"<?= esc($dokumen['catatan']) ?>"</p>
            </div>
        </div>
    </div>

    <form action="<?= base_url('staff/dokumen/resubmit/'.$dokumen['id']) ?>"
          method="post"
          enctype="multipart/form-data"
          class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 space-y-3">

        <?= csrf_field() ?>

        <div>
            <label class="block text-[10px] font-bold text-gray-500 mb-1 uppercase tracking-wider">Judul Dokumen</label>
            <input type="text" name="judul" value="<?= esc($dokumen['judul']) ?>" required
                   class="w-full rounded-md border-gray-300 text-xs focus:ring-orange-500 py-2 px-3 transition-all">
        </div>

        <div>
            <label class="block text-[10px] font-bold text-gray-500 mb-1 uppercase tracking-wider">Deskripsi Perubahan</label>
            <textarea name="deskripsi" rows="2" placeholder="Catatan singkat perbaikan..."
                      class="w-full rounded-md border-gray-300 text-xs focus:ring-orange-500 py-2 px-3 transition-all"><?= esc($dokumen['deskripsi']) ?></textarea>
        </div>

        <div x-data="{ fileName: '' }">
            <label class="block text-[10px] font-bold text-gray-500 mb-1 uppercase tracking-wider">Upload File Baru</label>
            <div class="relative">
                <input type="file" name="file" required @change="fileName = $event.target.files[0].name"
                       class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                <div class="border border-dashed border-gray-300 rounded-md p-3 text-center bg-gray-50 transition-all hover:bg-orange-50 hover:border-orange-300">
                    <div x-show="!fileName" class="flex flex-col items-center gap-1">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                        <p class="text-[10px] text-gray-500">Klik untuk ganti file</p>
                    </div>
                    <div x-show="fileName" class="flex items-center justify-center gap-2">
                        <span class="text-[11px] font-bold text-orange-600 truncate max-w-[200px]" x-text="fileName"></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-between pt-3 border-t border-gray-50">
            <a href="<?= base_url('staff/dokumen') ?>"
               class="text-[10px] font-bold text-gray-400 hover:text-gray-600 uppercase transition-all">
                ← Batal
            </a>

            <button type="submit"
                    class="bg-orange-500 hover:bg-orange-600 text-white text-[11px] font-bold px-4 py-2 rounded shadow-sm hover:shadow transition-all transform active:scale-95 flex items-center gap-1.5 uppercase tracking-tighter">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                Kirim Revisi
            </button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>