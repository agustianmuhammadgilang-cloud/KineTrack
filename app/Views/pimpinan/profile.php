<?= $this->extend('layout/pimpinan_template') ?>
<?= $this->section('content') ?>

<div class="max-w-4xl mx-auto py-8 px-4 font-sans text-slate-800">
    <div class="mb-8">
        <h3 class="text-3xl font-extrabold text-[var(--polban-blue)] tracking-tight">
            Pengaturan Profil Atasan
        </h3>
        <p class="text-slate-500 mt-1">
            Kelola informasi kredensial dan tanda tangan digital Anda untuk otoritas Staff.
        </p>
    </div>

    <?php if(session()->getFlashdata('success')): ?>
        <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r-xl flex items-center gap-3">
            <span class="font-medium"><?= session()->getFlashdata('success') ?></span>
        </div>
    <?php endif; ?>

    <div class="bg-white border border-slate-200 shadow-xl rounded-2xl overflow-hidden">
        <form id="formProfile" action="<?= base_url('pimpinan/profile/update') ?>" method="POST" enctype="multipart/form-data" class="divide-y divide-slate-100">
            
            <div class="p-6 md:p-8 space-y-6">
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-1 h-5 bg-[var(--polban-blue)] rounded-full"></div>
                    <h4 class="font-bold text-slate-700 uppercase tracking-wider text-sm">Informasi Dasar</h4>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="flex flex-col space-y-1.5">
                        <label class="text-sm font-semibold text-slate-600">Nama Lengkap</label>
                        <input type="text" name="nama" value="<?= esc($user['nama'] ?? '') ?>" required class="w-full rounded-xl border-slate-200 bg-slate-50/50 px-4 py-2.5 border focus:border-[var(--polban-blue)] outline-none">
                    </div>
                    <div class="flex flex-col space-y-1.5">
                        <label class="text-sm font-semibold text-slate-600">Alamat Email</label>
                        <input type="email" name="email" value="<?= esc($user['email'] ?? '') ?>" required class="w-full rounded-xl border-slate-200 bg-slate-50/50 px-4 py-2.5 border focus:border-[var(--polban-blue)] outline-none">
                    </div>
                </div>
                <div class="flex flex-col space-y-1.5 pt-2">
                    <label class="text-sm font-semibold text-slate-600">Password Baru</label>
                    <input type="password" name="password" placeholder="••••••••" class="w-full rounded-xl border-slate-200 bg-slate-50/50 px-4 py-2.5 border focus:border-[var(--polban-blue)] outline-none">
                    <p class="text-xs italic text-slate-400">Kosongkan jika tidak ingin mengganti password.</p>
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
                                 src="<?= !empty($user['foto']) ? base_url('uploads/profile/' . $user['foto']) : 'https://ui-avatars.com/api/?name='.urlencode($user['nama']).'&background=random' ?>" 
                                 class="w-full h-full object-cover">
                        </div>
                    </div>
                    <div class="flex-1">
                        <label class="text-sm font-semibold text-slate-600 mb-2 block">Pilih Foto Baru</label>
                        <input type="file" id="inputFoto" accept="image/png, image/jpeg" class="block w-full text-sm text-slate-500 border border-slate-200 rounded-xl bg-white p-1 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-emerald-50 file:text-emerald-700 cursor-pointer">
                        <input type="hidden" name="foto_cropped" id="foto_cropped">
                        <p class="mt-2 text-xs text-slate-500">Format JPG/PNG • Rasio 1:1 akan diterapkan</p>
                    </div>
                </div>
            </div>

            <div class="p-6 md:p-8 bg-slate-50/30">
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-1 h-5 bg-[var(--polban-orange)] rounded-full"></div>
                    <h4 class="font-bold text-slate-700 uppercase tracking-wider text-sm">Validasi Digital Atasan</h4>
                </div>
                <div class="flex flex-col md:flex-row gap-8 items-start">
                    <?php if (!empty($user['ttd_digital'])): ?>
                        <div class="flex flex-col items-center">
                            <span class="text-[10px] font-bold text-slate-400 uppercase mb-2 tracking-widest">TTD Aktif</span>
                            <div class="p-4 bg-white border border-dashed border-slate-300 rounded-xl shadow-inner">
                                <img src="<?= base_url('uploads/ttd/'.$user['ttd_digital']) ?>" class="h-20 object-contain mix-blend-multiply">
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="flex-1 w-full">
                        <label class="text-sm font-semibold text-slate-600 mb-2 block">Unggah TTD Baru (PNG Transparan disarankan)</label>
                        <input type="file" name="ttd_digital" accept="image/png, image/jpeg" class="block w-full text-sm text-slate-500 border border-slate-200 rounded-xl bg-white p-1 file:bg-orange-50 file:text-orange-700 file:rounded-lg file:border-0 file:py-2 file:px-4 cursor-pointer">
                    </div>
                </div>
            </div>

            <div class="p-6 md:px-8 py-6 bg-white flex flex-col md:flex-row-reverse gap-3">
                <button type="submit" class="bg-[var(--polban-orange)] hover:bg-orange-600 text-white font-bold px-8 py-3 rounded-xl shadow-lg transition-all active:scale-95">
                    Simpan Perubahan
                </button>
                <a href="<?= base_url('pimpinan') ?>" class="bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold px-8 py-3 rounded-xl text-center border border-slate-200">Batal</a>
            </div>
        </form>
    </div>
</div>

<div id="modalCropLocal" class="fixed inset-0 z-[999] hidden flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
    <div class="bg-white rounded-3xl shadow-2xl max-w-lg w-full overflow-hidden">
        <div class="p-5 border-b flex justify-between items-center bg-slate-50">
            <h3 class="font-bold text-slate-800">Sesuaikan Foto Profil</h3>
            <button type="button" onclick="closeCropModal()" class="text-slate-400 hover:text-slate-600 text-2xl">&times;</button>
        </div>
        <div class="p-6">
            <div class="max-h-[400px] overflow-hidden rounded-xl bg-slate-200">
                <img id="imageCropTargetLocal" src="" class="block max-w-full">
            </div>
            <div class="mt-6 flex justify-center gap-4">
                <button type="button" onclick="cropper.rotate(-90)" class="p-2 bg-slate-100 rounded-lg hover:bg-slate-200">↺</button>
                <button type="button" onclick="cropper.zoom(0.1)" class="p-2 bg-slate-100 rounded-lg hover:bg-slate-200">+</button>
                <button type="button" onclick="cropper.zoom(-0.1)" class="p-2 bg-slate-100 rounded-lg hover:bg-slate-200">-</button>
                <button type="button" onclick="cropper.rotate(90)" class="p-2 bg-slate-100 rounded-lg hover:bg-slate-200">↻</button>
            </div>
        </div>
        <div class="p-5 bg-slate-50 flex justify-end gap-3">
            <button type="button" onclick="closeCropModal()" class="px-5 py-2 text-slate-500 font-bold">Batal</button>
            <button type="button" id="btnApplyCrop" class="px-6 py-2 bg-emerald-500 text-white font-bold rounded-xl">Terapkan</button>
        </div>
    </div>
</div>

<script>
    let cropper;
    const inputFoto = document.getElementById('inputFoto');
    const imageTarget = document.getElementById('imageCropTargetLocal');
    const modalCrop = document.getElementById('modalCropLocal');
    const fotoCroppedInput = document.getElementById('foto_cropped');
    const mainPreview = document.getElementById('mainPreview');

    inputFoto.addEventListener('change', function(e) {
        const files = e.target.files;
        if (files && files.length > 0) {
            const reader = new FileReader();
            reader.onload = (event) => {
                imageTarget.src = event.target.result;
                modalCrop.classList.remove('hidden');
                if (cropper) cropper.destroy();
                cropper = new Cropper(imageTarget, {
                    aspectRatio: 1,
                    viewMode: 2,
                    autoCropArea: 1
                });
            };
            reader.readAsDataURL(files[0]);
        }
    });

    function closeCropModal() {
        modalCrop.classList.add('hidden');
        inputFoto.value = '';
    }

    document.getElementById('btnApplyCrop').addEventListener('click', function() {
        if (!cropper) return;
        const canvas = cropper.getCroppedCanvas({ width: 500, height: 500 });
        const base64Image = canvas.toDataURL('image/jpeg', 0.9);
        fotoCroppedInput.value = base64Image;
        mainPreview.src = base64Image;
        modalCrop.classList.add('hidden');
    });
</script>

<?= $this->endSection() ?>