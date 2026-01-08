<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<div class="min-h-screen bg-[#F8FAFC] pb-12">
    <div class="h-2 w-full flex">
        <div class="h-full w-1/2 bg-[#1D2F83]"></div>
        <div class="h-full w-1/2 bg-[#F58025]"></div>
    </div>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="py-6 flex items-center justify-between animate-fade-in-down">
            <a href="<?= base_url('admin/dokumen-tervalidasi') ?>"
               class="group inline-flex items-center gap-3 text-sm font-bold text-[#1D2F83] hover:text-[#F58025] transition-all">
                <div class="p-2 rounded-xl bg-white shadow-sm border border-gray-100 group-hover:border-[#F58025] group-hover:bg-orange-50 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"/></svg>
                </div>
                Kembali ke Daftar Kategori
            </a>
            <div class="hidden md:block text-[10px] font-black uppercase tracking-[0.2em] text-gray-300 italic">
                Sistem Informasi Dokumen Kinerja
            </div>
        </div>

        <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <div class="flex items-center gap-4 mb-2">
                    <div class="h-14 w-14 rounded-2xl bg-blue-50 flex items-center justify-center text-[#1D2F83]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                    </div>
                    <div>
                        <h1 class="text-4xl font-black text-[#1D2F83] tracking-tight italic"><?= esc($kategori['nama_kategori']) ?></h1>
                        <p class="text-gray-500 font-medium">Daftar berkas yang telah melalui verifikasi final.</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white px-6 py-3 rounded-2xl shadow-sm border border-gray-50 flex items-center gap-4">
                <div class="text-right">
                    <p class="text-[10px] font-black text-gray-300 uppercase leading-none mb-1">Populasi Data</p>
                    <p class="text-2xl font-black text-[#F58025] leading-none"><?= count($dokumen) ?> Berkas</p>
                </div>
            </div>
        </div>

        <div class="bg-white/80 backdrop-blur-md sticky top-4 z-20 rounded-[2rem] shadow-xl shadow-blue-900/5 p-4 mb-10 border border-white">
            <form method="get" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-center">
                <div class="md:col-span-1">
                    <select name="bidang" class="w-full bg-gray-50 border-none rounded-xl px-4 py-3 text-sm font-bold text-gray-600 focus:ring-2 focus:ring-[#1D2F83] transition-all">
                        <option value="">Semua Unit Kerja</option>
                        <?php foreach ($bidang as $b): ?>
                            <option value="<?= $b['id'] ?>" <?= request()->getGet('bidang') == $b['id'] ? 'selected' : '' ?>>
                                <?= esc($b['nama_bidang']) ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="md:col-span-2 relative group">
                    <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-300 group-focus-within:text-[#F58025] transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    </div>
                    <input type="text" name="q" value="<?= esc(request()->getGet('q')) ?>" placeholder="Cari judul dokumen atau ID..."
                           class="w-full bg-gray-50 border-none rounded-xl pl-12 pr-4 py-3 text-sm font-medium focus:ring-2 focus:ring-[#1D2F83] transition-all">
                </div>
                <button class="bg-[#1D2F83] hover:bg-[#F58025] text-white font-black py-3 rounded-xl transition-all shadow-lg shadow-blue-100 flex items-center justify-center gap-2 uppercase text-xs tracking-widest active:scale-95">
                    Terapkan Filter
                </button>
            </form>
        </div>

        <div class="space-y-4">
            <?php if (empty($dokumen)): ?>
                <div class="bg-white rounded-[2.5rem] p-20 text-center border-2 border-dashed border-gray-100">
                    <div class="text-gray-200 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                    </div>
                    <p class="text-gray-400 font-bold italic text-xl uppercase tracking-tighter">Hasil pencarian nihil</p>
                </div>
            <?php endif ?>

            <?php foreach ($dokumen as $d): ?>
            <div class="group bg-white rounded-3xl p-6 border border-gray-100 shadow-sm hover:shadow-xl hover:shadow-blue-900/5 transition-all duration-300">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                    
                    <div class="flex items-start gap-5 flex-1">
                        <div class="h-14 w-14 bg-gray-50 group-hover:bg-blue-50 rounded-2xl flex items-center justify-center text-gray-300 group-hover:text-[#1D2F83] transition-colors shrink-0 shadow-inner">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                        </div>
                        <div>
                            <span class="text-[10px] font-black text-[#F58025] uppercase tracking-widest bg-orange-50 px-2 py-0.5 rounded-md mb-2 inline-block shadow-sm">ID: #<?= $d['id'] ?></span>
                            <h3 class="text-lg font-black text-gray-800 group-hover:text-[#1D2F83] transition-colors leading-tight italic"><?= esc($d['judul']) ?></h3>
                            <div class="flex flex-wrap items-center gap-x-4 gap-y-1 mt-2">
                                <span class="text-xs font-bold text-gray-400 flex items-center gap-1.5 uppercase tracking-tighter">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1" /></svg>
                                    <?= esc($d['nama_bidang'] ?? '-') ?>
                                </span>
                                <span class="text-xs font-bold text-gray-400 flex items-center gap-1.5 uppercase tracking-tighter">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                    Validasi: <?= date('d M Y', strtotime($d['updated_at'])) ?>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 shrink-0">
                        <a href="<?= base_url('uploads/dokumen/' . $d['file_path']) ?>" target="_blank"
                           class="h-12 w-12 flex items-center justify-center rounded-xl bg-gray-50 text-gray-400 hover:bg-[#1D2F83] hover:text-white transition-all shadow-sm group/view relative">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <span class="absolute -top-10 scale-0 group-hover/view:scale-100 transition-transform bg-gray-800 text-white text-[10px] px-2 py-1 rounded">Lihat Dokumen</span>
                        </a>

                        <button onclick="document.getElementById('edit<?= $d['id'] ?>').showModal()"
                                class="flex items-center gap-2 bg-orange-50 text-[#F58025] hover:bg-[#F58025] hover:text-white font-black px-6 py-3 rounded-xl text-xs uppercase transition-all shadow-sm active:scale-95">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" /></svg>
                            Relokasi
                        </button>
                    </div>
                </div>
            </div>

            <dialog id="edit<?= $d['id'] ?>" class="rounded-[2.5rem] w-full max-w-xl shadow-2xl backdrop:bg-[#1D2F83]/40 p-0 overflow-hidden">
                <div class="bg-white">
                    <div class="bg-[#1D2F83] p-8 text-white relative">
                        <div class="absolute top-0 right-0 p-8 text-blue-300 pointer-events-none opacity-20">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24" fill="currentColor" viewBox="0 0 24 24"><path d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" /></svg>
                        </div>
                        <h3 class="text-2xl font-black italic">Relokasi Wadah</h3>
                        <p class="text-blue-200 text-sm mt-1">Pindahkan berkas ke kategori dokumen lain.</p>
                    </div>
                    
                    <form method="post" action="<?= base_url('admin/dokumen-tervalidasi/update-kategori/' . $d['id']) ?>" class="p-8">
                        <?= csrf_field() ?>
                        <div class="mb-8">
                            <p class="text-[10px] font-black text-gray-300 uppercase tracking-widest mb-1">Dokumen Terpilih</p>
                            <p class="text-gray-700 font-bold italic border-l-4 border-[#F58025] pl-4 py-1"><?= esc($d['judul']) ?></p>
                        </div>

                        <div class="space-y-2">
                            <label class="text-xs font-black uppercase text-gray-500 tracking-widest ml-1">Kategori Destinasi</label>
                            <select name="kategori_id" class="w-full bg-gray-50 border-none rounded-2xl px-5 py-4 focus:ring-2 focus:ring-[#F58025] transition-all font-bold text-gray-700">
                                <?php foreach ($kategoriList as $kl): ?>
                                    <option value="<?= $kl['id'] ?>" <?= $kl['id'] == $kategori['id'] ? 'selected' : '' ?>>
                                        📂 <?= esc($kl['nama_kategori']) ?>
                                    </option>
                                <?php endforeach ?>
                            </select>
                        </div>

                        <div class="flex gap-4 mt-10">
                            <button type="button" onclick="this.closest('dialog').close()" class="flex-1 py-4 font-bold text-gray-400 hover:text-gray-600">Batalkan</button>
                            <button type="submit" class="flex-[2] bg-[#F58025] text-white py-4 rounded-2xl font-black shadow-lg shadow-orange-100 hover:bg-orange-600 transition-all hover:-translate-y-1">Konfirmasi Pindah</button>
                        </div>
                    </form>
                </div>
            </dialog>
            <?php endforeach ?>
        </div>
    </div>
</div>

<style>
    @keyframes fade-in-down {
        0% { opacity: 0; transform: translateY(-10px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-down { animation: fade-in-down 0.6s ease-out; }
    
    dialog::backdrop { backdrop-filter: blur(8px); }
</style>

<?= $this->endSection() ?>