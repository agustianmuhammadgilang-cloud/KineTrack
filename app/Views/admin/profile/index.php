<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">

<div class="max-w-4xl mx-auto py-8 px-4 font-sans text-slate-800">
    
    <div class="mb-8">
        <h3 class="text-3xl font-extrabold text-[var(--polban-blue)] tracking-tight">
            Pengaturan Profil Admin
        </h3>
        <p class="text-slate-500 mt-1">
            Kelola informasi kredensial dan tanda tangan digital Anda untuk otoritas administrasi.
        </p>
    </div>

    <?php if(session()->getFlashdata('success')): ?>
    <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r-xl flex items-center gap-3 animate-slide-in">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
        </svg>
        <span class="font-medium"><?= session()->getFlashdata('success') ?></span>
    </div>
    <?php endif; ?>

    <div class="bg-white border border-slate-200 shadow-xl rounded-2xl overflow-hidden">
        <form
            id="formProfile"
            action="<?= base_url('admin/profile/update') ?>"
            method="POST"
            enctype="multipart/form-data"
            class="divide-y divide-slate-100">

            <div class="p-6 md:p-8 space-y-6">
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-1 h-5 bg-[var(--polban-blue)] rounded-full"></div>
                    <h4 class="font-bold text-slate-700 uppercase tracking-wider text-sm">Informasi Dasar</h4>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="flex flex-col space-y-1.5">
                        <label class="text-sm font-semibold text-slate-600 ml-1">Nama Lengkap</label>
                        <input type="text" name="nama" value="<?= esc($admin['nama'] ?? '') ?>" required class="w-full rounded-xl border-slate-200 bg-slate-50/50 px-4 py-2.5 focus:border-[var(--polban-blue)] focus:ring-4 focus:ring-blue-500/10 transition-all outline-none border">
                    </div>
                    <div class="flex flex-col space-y-1.5">
                        <label class="text-sm font-semibold text-slate-600 ml-1">Alamat Email</label>
                        <input type="email" name="email" value="<?= esc($admin['email'] ?? '') ?>" required class="w-full rounded-xl border-slate-200 bg-slate-50/50 px-4 py-2.5 focus:border-[var(--polban-blue)] focus:ring-4 focus:ring-blue-500/10 transition-all outline-none border">
                    </div>
                </div>

                <div class="flex flex-col space-y-1.5 pt-2">
                    <label class="text-sm font-semibold text-slate-600 ml-1">Password Baru</label>
                    <input type="password" name="password" placeholder="••••••••" class="w-full rounded-xl border-slate-200 bg-slate-50/50 px-4 py-2.5 focus:border-[var(--polban-blue)] focus:ring-4 focus:ring-blue-500/10 transition-all outline-none border">
                    <p class="text-xs italic text-slate-400 ml-1 mt-1">Kosongkan jika tidak ingin mengganti password.</p>
                </div>
            </div>

            <div class="p-6 md:p-8 bg-slate-50/30 space-y-6">
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-1 h-5 bg-emerald-500 rounded-full"></div>
                    <h4 class="font-bold text-slate-700 uppercase tracking-wider text-sm">Foto Profil</h4>
                </div>

                <div class="flex items-center gap-8">
                    <div class="flex flex-col items-center gap-2">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Preview</span>
                        <div class="w-28 h-28 rounded-full overflow-hidden border-4 border-white shadow-lg bg-slate-100">
                            <img id="mainPreview" 
                                 src="<?= !empty($admin['foto']) ? base_url('uploads/profile/' . $admin['foto']) : 'https://ui-avatars.com/api/?name='.urlencode($admin['nama']).'&background=random' ?>" 
                                 class="w-full h-full object-cover">
                        </div>
                    </div>

                    <div class="flex-1">
                        <label class="text-sm font-semibold text-slate-600 mb-2 block">Pilih Foto Baru</label>
                        <input
                            type="file"
                            id="inputFoto"
                            accept="image/png, image/jpeg"
                            class="block w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 cursor-pointer border border-slate-200 rounded-xl bg-white p-1">
                        <p class="mt-2 text-xs text-slate-500">Format JPG/PNG • Rasio akan otomatis disesuaikan (1:1)</p>
                        
                        <input type="hidden" name="foto_cropped" id="foto_cropped">
                    </div>
                </div>
            </div>

            <div class="p-6 md:p-8 bg-slate-50/30 space-y-6">
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-1 h-5 bg-[var(--polban-orange)] rounded-full"></div>
                    <h4 class="font-bold text-slate-700 uppercase tracking-wider text-sm">Validasi Digital Admin</h4>
                </div>
                <div class="flex flex-col md:flex-row gap-8 items-start">
                    <?php if (!empty($admin['ttd_digital'])): ?>
                        <div class="flex flex-col items-center">
                            <span class="text-[10px] font-bold text-slate-400 uppercase mb-2 tracking-widest">TTD Aktif</span>
                            <div class="p-4 bg-white border border-dashed border-slate-300 rounded-xl shadow-inner">
                                <img src="<?= base_url('uploads/ttd/'.$admin['ttd_digital']) ?>" class="h-20 object-contain mix-blend-multiply">
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="flex-1 w-full">
                        <label class="text-sm font-semibold text-slate-600 mb-2 block ml-1">Perbarui Tanda Tangan (PNG/JPG)</label>
                        <input type="file" name="ttd_digital" accept="image/png, image/jpeg" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100 cursor-pointer border border-slate-200 rounded-xl bg-white p-1">
                    </div>
                </div>
            </div>

            <div class="p-6 md:px-8 py-6 bg-white flex flex-col md:flex-row-reverse gap-3">
                <button type="submit" class="group flex items-center justify-center gap-2 bg-[var(--polban-orange)] hover:bg-orange-600 text-white font-bold px-8 py-3 rounded-xl shadow-lg transition-all active:scale-95">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" /></svg>
                    Simpan Perubahan
                </button>
                <a href="<?= base_url('admin') ?>" class="flex items-center justify-center bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold px-8 py-3 rounded-xl transition-all border border-slate-200">Batal</a>
            </div>
        </form>
    </div>
</div>

<div id="modalCrop" class="fixed inset-0 z-[999] hidden flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
    <div class="bg-white rounded-3xl shadow-2xl max-w-lg w-full overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
            <h3 class="font-bold text-slate-800">Sesuaikan Foto Profil</h3>
            <button type="button" onclick="closeCropModal()" class="text-slate-400 hover:text-slate-600 text-2xl">&times;</button>
        </div>
        <div class="p-6">
            <div class="max-h-[400px] overflow-hidden rounded-xl bg-slate-200">
                <img id="imageCropTarget" src="" class="block max-w-full">
            </div>
            <div class="mt-6 flex justify-center gap-4">
                <button type="button" onclick="cropper.rotate(-90)" class="p-2 bg-slate-100 rounded-lg hover:bg-slate-200" title="Putar Kiri">↺</button>
                <button type="button" onclick="cropper.zoom(0.1)" class="p-2 bg-slate-100 rounded-lg hover:bg-slate-200" title="Zoom In">+</button>
                <button type="button" onclick="cropper.zoom(-0.1)" class="p-2 bg-slate-100 rounded-lg hover:bg-slate-200" title="Zoom Out">-</button>
                <button type="button" onclick="cropper.rotate(90)" class="p-2 bg-slate-100 rounded-lg hover:bg-slate-200" title="Putar Kanan">↻</button>
            </div>
        </div>
        <div class="p-5 bg-slate-50 flex justify-end gap-3">
            <button type="button" onclick="closeCropModal()" class="px-5 py-2.5 text-sm font-bold text-slate-500 hover:text-slate-700">Batal</button>
            <button type="button" id="btnApplyCrop" class="px-6 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-bold rounded-xl shadow-lg shadow-emerald-200 transition-all">Terapkan Potongan</button>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<script>
    let cropper;
    const inputFoto = document.getElementById('inputFoto');
    const imageTarget = document.getElementById('imageCropTarget');
    const modalCrop = document.getElementById('modalCrop');
    const fotoCroppedInput = document.getElementById('foto_cropped');
    const mainPreview = document.getElementById('mainPreview');

    // 1. Deteksi Perubahan File
    inputFoto.addEventListener('change', function(e) {
        const files = e.target.files;
        if (files && files.length > 0) {
            const file = files[0];
            const reader = new FileReader();
            reader.onload = function(event) {
                imageTarget.src = event.target.result;
                openCropModal();
            };
            reader.readAsDataURL(file);
        }
    });

    function openCropModal() {
        modalCrop.classList.remove('hidden');
        if (cropper) cropper.destroy();
        
        // Inisialisasi Cropper
        cropper = new Cropper(imageTarget, {
            aspectRatio: 1, // Memaksa kotak 1:1
            viewMode: 2,
            dragMode: 'move',
            background: false,
            autoCropArea: 1,
        });
    }

    function closeCropModal() {
        modalCrop.classList.add('hidden');
        inputFoto.value = ''; // Reset input agar bisa pilih file yang sama lagi
    }

    // 2. Proses Hasil Crop
    document.getElementById('btnApplyCrop').addEventListener('click', function() {
        if (!cropper) return;

        // Ambil canvas hasil crop
        const canvas = cropper.getCroppedCanvas({
            width: 500, // Standarisasi ukuran file di server
            height: 500
        });

        // Convert ke Base64 string
        const base64Image = canvas.toDataURL('image/jpeg', 0.9);
        
        // Masukkan ke input hidden
        fotoCroppedInput.value = base64Image;
        
        // Ubah preview di halaman utama
        mainPreview.src = base64Image;

        modalCrop.classList.add('hidden');
    });
</script>

<?= $this->endSection() ?>