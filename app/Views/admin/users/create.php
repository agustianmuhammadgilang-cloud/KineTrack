<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<h4 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-6">
    Tambah User
</h4>

<div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 max-w-xl mx-auto">

    <!-- NOTIFIKASI (TAMBAHAN, TANPA UBAH LOGIKA FORM) -->
<?php if (session()->getFlashdata('error')): ?>
    <div class="mb-4 p-3 rounded-lg bg-red-100 text-red-700 font-semibold">
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

    <form action="<?= base_url('admin/users/store') ?>" method="POST" class="space-y-5">

        <!-- NAMA -->
        <div>
            <label class="block text-sm font-medium mb-1">Nama Lengkap</label>
            <input type="text" name="nama" required
                   value="<?= old('nama') ?>"
                   class="w-full px-3 py-2 rounded-md border dark:bg-gray-700 dark:text-white">
        </div>

        <!-- EMAIL -->
        <div>
            <label class="block text-sm font-medium mb-1">Email</label>
            <input type="email" name="email" required
                   value="<?= old('email') ?>"
                   class="w-full px-3 py-2 rounded-md border dark:bg-gray-700 dark:text-white">
        </div>

        <!-- JABATAN -->
        <div>
            <label class="block text-sm font-medium mb-1">
                Jabatan <span class="text-red-500">*</span>
            </label>
            <select name="jabatan_id" id="jabatan" required
                    class="w-full px-3 py-2 rounded-md border dark:bg-gray-700 dark:text-white">
                <option value="">- Pilih Jabatan -</option>
                <?php foreach ($jabatan as $j): ?>
                    <option value="<?= $j['id'] ?>"
                        data-nama="<?= strtolower($j['nama_jabatan']) ?>">
                        <?= esc($j['nama_jabatan']) ?>
                    </option>
                <?php endforeach ?>
            </select>
        </div>

        <!-- UNIT KERJA -->
        <div>
            <label class="block text-sm font-medium mb-1">
                Unit Kerja <span class="text-red-500">*</span>
            </label>
            <select name="bidang_id" id="bidang" required disabled
                    class="w-full px-3 py-2 rounded-md border bg-gray-100 dark:bg-gray-700 dark:text-white">
                <option value="">- Pilih Unit Kerja -</option>

                <?php
                $grouped = [];
                foreach ($bidang as $b) {
                    $grouped[$b['parent_id'] ?? 0][] = $b;
                }
                ?>

                <?php foreach ($grouped[0] ?? [] as $jurusan): ?>
                    <option value="<?= $jurusan['id'] ?>"
                            data-type="jurusan"
                            class="unit-option text-gray-400"
                            disabled>
                        <?= esc($jurusan['nama_bidang']) ?>
                    </option>

                    <?php foreach ($grouped[$jurusan['id']] ?? [] as $prodi): ?>
                        <option value="<?= $prodi['id'] ?>"
                                data-type="prodi"
                                class="unit-option text-gray-400"
                                disabled>
                            ↳ <?= esc($prodi['nama_bidang']) ?>
                        </option>
                    <?php endforeach ?>
                <?php endforeach ?>
            </select>
        </div>

        <!-- ROLE -->
        <div>
            <label class="block text-sm font-medium mb-1">Role Sistem</label>
            <input type="text" id="roleInfo" readonly
                   class="w-full px-3 py-2 rounded-md border bg-gray-100 dark:bg-gray-700 dark:text-gray-300"
                   placeholder="Ditentukan otomatis oleh sistem">
        </div>

        <!-- INFO UX -->
        <div class="bg-blue-50 dark:bg-blue-900/30 p-3 rounded text-sm">
            <b>Aturan Sistem:</b><br>
            • Jabatan Jurusan → hanya bisa memilih <b>Jurusan</b><br>
            • Jabatan Prodi → hanya bisa memilih <b>Prodi</b><br>
            • Role ditentukan otomatis
        </div>

        <p class="text-sm text-gray-500">
            Password default: <b>123456</b>
        </p>

        <!-- ACTION -->
        <div class="flex gap-3 mt-4">
            <button type="submit"
                    class="bg-orange-500 hover:bg-orange-600 text-white px-5 py-2 rounded-md">
                Simpan
            </button>
            <a href="<?= base_url('admin/users') ?>"
               class="bg-gray-400 hover:bg-gray-500 text-white px-5 py-2 rounded-md text-center">
                Kembali
            </a>
        </div>

    </form>
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
        bidang.classList.add('bg-gray-100');

        options.forEach(opt => {
            opt.disabled = true;
            opt.classList.add('text-gray-400');
        });
    }

    jabatan.addEventListener('change', () => {
        resetBidang();

        const jabatanText = jabatan.options[jabatan.selectedIndex]?.dataset.nama || '';
        if (!jabatanText) return;

        bidang.disabled = false;
        bidang.classList.remove('bg-gray-100');

        let allowedType = '';

        if (jabatanText.includes('jurusan')) {
            allowedType = 'jurusan';
            roleInfo.value = jabatanText.includes('ketua') ? 'atasan' : 'staff';
        }

        if (jabatanText.includes('prodi')) {
            allowedType = 'prodi';
            roleInfo.value = jabatanText.includes('ketua') ? 'atasan' : 'staff';
        }

        options.forEach(opt => {
            if (opt.dataset.type === allowedType) {
                opt.disabled = false;
                opt.classList.remove('text-gray-400');
            }
        });
    });
});
</script>

<?= $this->endSection() ?>
