<?= $this->extend('layout/atasan_template') ?>
<?= $this->section('content') ?>

<div class="max-w-4xl mx-auto py-8 px-4 font-sans text-slate-800">
    
    <div class="mb-8">
        <h3 class="text-3xl font-extrabold text-slate-900 tracking-tight">
            Pengaturan Profil
        </h3>
        <p class="text-slate-500 mt-1">
            Kelola informasi pribadi dan tanda tangan digital Anda untuk keperluan dokumen resmi.
        </p>
    </div>

    <div class="bg-white border border-slate-200 shadow-xl rounded-2xl overflow-hidden">
        <form
            action="<?= base_url('atasan/profile/update') ?>"
            method="POST"
            enctype="multipart/form-data"
            class="divide-y divide-slate-100">

            <div class="p-6 md:p-8 space-y-6">
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-1 h-5 bg-blue-600 rounded-full"></div>
                    <h4 class="font-bold text-slate-700 uppercase tracking-wider text-sm">Informasi Dasar</h4>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="flex flex-col space-y-1.5">
                        <label class="text-sm font-semibold text-slate-600 ml-1">Nama Lengkap</label>
                        <input 
                            type="text" 
                            name="nama"
                            value="<?= esc($user['nama']) ?>"
                            required
                            placeholder="Masukkan nama lengkap"
                            class="w-full rounded-xl border-slate-200 bg-slate-50/50 px-4 py-2.5 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none border">
                    </div>

                    <div class="flex flex-col space-y-1.5">
                        <label class="text-sm font-semibold text-slate-600 ml-1">Alamat Email</label>
                        <input 
                            type="email" 
                            name="email"
                            value="<?= esc($user['email']) ?>"
                            required
                            placeholder="nama@polban.ac.id"
                            class="w-full rounded-xl border-slate-200 bg-slate-50/50 px-4 py-2.5 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none border">
                    </div>
                </div>

                <div class="flex flex-col space-y-1.5 pt-2">
                    <label class="text-sm font-semibold text-slate-600 ml-1">Password Baru</label>
                    <input 
                        type="password" 
                        name="password"
                        placeholder="••••••••"
                        class="w-full rounded-xl border-slate-200 bg-slate-50/50 px-4 py-2.5 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none border">
                    <div class="flex items-center gap-1.5 mt-1 ml-1 text-slate-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-xs italic">Kosongkan jika tidak ingin mengganti password saat ini.</p>
                    </div>
                </div>
            </div>

            <div class="p-6 md:p-8 bg-slate-50/30 space-y-6">
    <div class="flex items-center gap-2 mb-4">
        <div class="w-1 h-5 bg-emerald-500 rounded-full"></div>
        <h4 class="font-bold text-slate-700 uppercase tracking-wider text-sm">
            Foto Profil
        </h4>
    </div>

    <div class="flex items-center gap-8">
        <!-- PREVIEW FOTO -->
        <div class="flex flex-col items-center gap-2">
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                Foto Saat Ini
            </span>

            <div class="w-28 h-28 rounded-full overflow-hidden border-4 border-white shadow-lg bg-slate-100">
                <?php if (!empty($user['foto'])): ?>
                    <img
                        src="<?= base_url('uploads/profile/' . $user['foto']) ?>"
                        class="w-full h-full object-cover"
                        alt="Foto Profil">
                <?php else: ?>
                    <div class="w-full h-full flex items-center justify-center text-slate-400 text-sm">
                        Belum ada
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- INPUT -->
        <div class="flex-1">
            <label class="text-sm font-semibold text-slate-600 mb-2 block">
                Unggah Foto Baru
            </label>

            <input
                type="file"
                name="foto"
                accept="image/png, image/jpeg"
                class="block w-full text-sm text-slate-500
                    file:mr-4 file:py-2.5 file:px-4
                    file:rounded-xl file:border-0
                    file:text-sm file:font-semibold
                    file:bg-emerald-50 file:text-emerald-700
                    hover:file:bg-emerald-100
                    cursor-pointer border border-slate-200 rounded-xl bg-white p-1">

            <p class="mt-2 text-xs text-slate-500">
                Format JPG/PNG • Maks 2MB • Disarankan foto persegi
            </p>
        </div>
    </div>
</div>


            <div class="p-6 md:p-8 bg-slate-50/30 space-y-6">
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-1 h-5 bg-amber-500 rounded-full"></div>
                    <h4 class="font-bold text-slate-700 uppercase tracking-wider text-sm">Validasi Digital</h4>
                </div>

                <div class="flex flex-col md:flex-row gap-8 items-start">
                    <?php if (!empty($user['ttd_digital'])): ?>
                        <div class="flex flex-col items-center">
                            <span class="text-[10px] font-bold text-slate-400 uppercase mb-2 tracking-widest">TTD Aktif</span>
                            <div class="p-4 bg-white border border-dashed border-slate-300 rounded-xl shadow-inner">
                                <img
                                    src="<?= base_url('uploads/ttd/'.$user['ttd_digital']) ?>"
                                    alt="Tanda Tangan"
                                    class="h-20 object-contain mix-blend-multiply">
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="flex-1 w-full">
                        <label class="text-sm font-semibold text-slate-600 mb-2 block ml-1">Perbarui Tanda Tangan (PNG/JPG)</label>
                        <div class="relative group">
                            <input
                                type="file"
                                name="ttd_digital"
                                accept="image/png, image/jpeg"
                                class="block w-full text-sm text-slate-500
                                    file:mr-4 file:py-2.5 file:px-4
                                    file:rounded-xl file:border-0
                                    file:text-sm file:font-semibold
                                    file:bg-blue-50 file:text-blue-700
                                    hover:file:bg-blue-100
                                    cursor-pointer border border-slate-200 rounded-xl bg-white p-1">
                        </div>
                        <p class="mt-3 text-xs text-slate-500 leading-relaxed">
                            <span class="font-bold text-amber-600">Catatan:</span> Gunakan gambar dengan latar belakang putih polos atau transparan untuk hasil terbaik pada laporan PDF.
                        </p>
                    </div>
                </div>
            </div>

            <div class="p-6 md:px-8 py-6 bg-white flex flex-col md:flex-row-reverse gap-3">
                <button 
                    type="submit"
                    class="group flex items-center justify-center gap-2 bg-orange-500 hover:bg-orange-600 text-white font-bold px-8 py-3 rounded-xl shadow-lg shadow-orange-200 transition-all active:scale-95">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:animate-bounce" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                    </svg>
                    Simpan Perubahan
                </button>

                <a 
                    href="<?= base_url('atasan') ?>"
                    class="flex items-center justify-center bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold px-8 py-3 rounded-xl transition-all border border-slate-200">
                    Batal
                </a>
            </div>

        </form>
    </div>

    <div class="mt-8 flex items-center justify-center gap-2 text-slate-400">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
        </svg>
        <span class="text-[11px] uppercase tracking-widest font-medium text-center">Data anda tersinkronisasi dengan aman di server KINETRACK</span>
    </div>
</div>

<?= $this->endSection() ?>