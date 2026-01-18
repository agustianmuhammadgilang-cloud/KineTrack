<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<style>
    :root {
        --polban-blue: #003366;
        --polban-blue-light: #004a94;
        --polban-gold: #D4AF37;
        --slate-soft: #f8fafc;
        --transition-smooth: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .form-card {
        background: white;
        border-radius: 32px;
        border: 1px solid #eef2f6;
        box-shadow: 0 20px 50px -12px rgba(0, 51, 102, 0.08);
    }

    .input-field {
        transition: var(--transition-smooth);
        border: 1.5px solid #e2e8f0;
    }

    .input-field:focus {
        border-color: var(--polban-blue);
        box-shadow: 0 0 0 4px rgba(0, 51, 102, 0.05);
        outline: none;
    }

    .input-field:disabled {
        background-color: #f1f5f9;
        cursor: not-allowed;
        opacity: 0.7;
    }

    .btn-polban {
        transition: var(--transition-smooth);
        background: var(--polban-blue);
    }

    .btn-polban:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px -5px rgba(0, 51, 102, 0.3);
        filter: brightness(1.1);
    }

    .info-badge {
        background: linear-gradient(135deg, rgba(0, 51, 102, 0.03) 0%, rgba(212, 175, 55, 0.05) 100%);
        border-left: 4px solid var(--polban-gold);
    }
</style>

<div class="px-4 py-8 max-w-4xl mx-auto">
    <div class="flex items-center gap-5 mb-10">
        <div class="w-14 h-14 bg-blue-50 border border-blue-100 rounded-2xl flex items-center justify-center shadow-sm text-blue-900">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
            </svg>
        </div>
        <div>
            <h4 class="text-2xl font-black text-blue-900 tracking-tight">
                Registrasi <span class="text-slate-400 font-light">|</span> <span class="text-blue-600">User Baru</span>
            </h4>
            <p class="text-[11px] text-slate-400 font-semibold uppercase tracking-[0.2em] mt-1">
                Penambahan entitas pengguna ke dalam sistem
            </p>
        </div>
    </div>

    <div class="form-card overflow-hidden">
        <div class="p-8 md:p-12">
            
            <?php if (session()->getFlashdata('error')): ?>
                <div class="mb-8 p-4 rounded-2xl bg-rose-50 border border-rose-100 text-rose-700 text-sm font-bold flex items-center gap-3">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('admin/users/store') ?>" method="POST" class="space-y-8">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Nama Lengkap</label>
                        <input type="text" name="nama" required value="<?= old('nama') ?>"
                               placeholder="Masukkan nama sesuai SK"
                               class="input-field w-full px-4 py-3.5 rounded-2xl text-blue-900 font-medium">
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Alamat Email</label>
                        <input type="email" name="email" required value="<?= old('email') ?>"
                               placeholder="contoh@polban.ac.id"
                               class="input-field w-full px-4 py-3.5 rounded-2xl text-blue-900 font-medium">
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Struktur Jabatan <span class="text-rose-500">*</span></label>
                        <select name="jabatan_id" id="jabatan" required
                                class="input-field w-full px-4 py-3.5 rounded-2xl text-blue-900 font-bold bg-slate-50">
                            <option value="">- Pilih Jabatan -</option>
                            <?php foreach ($jabatan as $j): ?>
                                <option value="<?= $j['id'] ?>" data-nama="<?= strtolower($j['nama_jabatan']) ?>">
                                    <?= esc($j['nama_jabatan']) ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Unit Kerja / Bidang <span class="text-rose-500">*</span></label>
                        <select name="bidang_id" id="bidang" required disabled
                                class="input-field w-full px-4 py-3.5 rounded-2xl text-blue-900 font-bold">
                            <option value="">- Pilih Unit Kerja -</option>

                            <?php
                            $grouped = [];
                            foreach ($bidang as $b) {
                                $grouped[$b['parent_id'] ?? 0][] = $b;
                            }
                            ?>

                            <?php foreach ($grouped[0] ?? [] as $jurusan): ?>
                                <option value="<?= $jurusan['id'] ?>" data-type="jurusan" class="unit-option text-slate-300 font-normal" disabled>
                                    <?= esc($jurusan['nama_bidang']) ?>
                                </option>
                                <?php foreach ($grouped[$jurusan['id']] ?? [] as $prodi): ?>
                                    <option value="<?= $prodi['id'] ?>" data-type="prodi" class="unit-option text-slate-300 font-normal" disabled>
                                        &nbsp;&nbsp;&nbsp;↳ <?= esc($prodi['nama_bidang']) ?>
                                    </option>
                                <?php endforeach ?>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Privilese Sistem (Role)</label>
                    <div class="relative">
                        <input type="text" id="roleInfo" readonly
                               class="w-full px-4 py-3.5 rounded-2xl border border-slate-100 bg-slate-50 text-blue-900 font-black uppercase tracking-wider text-xs"
                               placeholder="Otomatis Terdeteksi...">
                        <div class="absolute right-4 top-1/2 -translate-y-1/2">
                            <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </div>
                    </div>
                </div>

                <div class="info-badge p-6 rounded-3xl">
                    <div class="flex gap-4">
                        <div class="shrink-0 w-10 h-10 bg-white rounded-xl shadow-sm flex items-center justify-center">
                            <svg class="w-5 h-5 text-polban-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <div>
                            <p class="text-xs font-black text-blue-900 uppercase tracking-tight mb-2">Konfigurasi Keamanan</p>
                            <ul class="text-[11px] text-slate-500 space-y-1 font-medium leading-relaxed">
                                <li class="flex items-center gap-2"><span class="w-1 h-1 rounded-full bg-slate-300"></span> Jabatan tingkat Jurusan hanya diizinkan memilih Unit Jurusan.</li>
                                <li class="flex items-center gap-2"><span class="w-1 h-1 rounded-full bg-slate-300"></span> Jabatan tingkat Prodi hanya diizinkan memilih Unit Prodi.</li>
                                <li class="flex items-center gap-2"><span class="w-1 h-1 rounded-full bg-slate-300"></span> Password standar diatur ke: <b class="text-blue-900 underline">123456</b></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-slate-50">
                    <button type="submit" class="btn-polban flex-1 text-white font-black py-4 rounded-2xl uppercase tracking-widest text-xs">
                        Simpan Data User
                    </button>
                    <a href="<?= base_url('admin/users') ?>" class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-500 font-black py-4 rounded-2xl uppercase tracking-widest text-xs text-center transition-colors">
                        Batal & Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const jabatan  = document.getElementById('jabatan');
    const bidang   = document.getElementById('bidang');
    const roleInfo = document.getElementById('roleInfo');
    const options  = document.querySelectorAll('.unit-option');

    function resetBidang() {
        bidang.value = '';
        bidang.disabled = true;
        bidang.classList.add('bg-slate-100');
        roleInfo.value = '';

        options.forEach(opt => {
            opt.disabled = true;
            opt.classList.add('text-slate-300');
            opt.classList.remove('text-blue-900', 'font-bold');
        });
    }

    jabatan.addEventListener('change', () => {
        resetBidang();

        const jabatanText = jabatan.options[jabatan.selectedIndex]?.dataset.nama || '';
        if (!jabatanText) return;

        bidang.disabled = false;
        bidang.classList.remove('bg-slate-100');

        let allowedType = '';

        if (jabatanText.includes('jurusan')) {
            allowedType = 'jurusan';
            roleInfo.value = (jabatanText.includes('ketua') || jabatanText.includes('sekretaris')) ? 'atasan' : 'staff';
        } else if (jabatanText.includes('prodi')) {
            allowedType = 'prodi';
            roleInfo.value = (jabatanText.includes('ketua') || jabatanText.includes('koordinator')) ? 'atasan' : 'staff';
        } else {
            roleInfo.value = 'staff'; // Default
        }

        options.forEach(opt => {
            if (opt.dataset.type === allowedType) {
                opt.disabled = false;
                opt.classList.remove('text-slate-300');
                opt.classList.add('text-blue-900', 'font-bold');
            }
        });
    });
});
</script>

<?= $this->endSection() ?>