<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<h4 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-6">
    Tambah User
</h4>

<div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 max-w-xl mx-auto">

    <!-- FLASH ERROR -->
    <?php if (session()->getFlashdata('error')): ?>
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-lg font-medium animate-fade">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <form id="userForm" action="<?= base_url('admin/users/store') ?>" method="POST" class="space-y-5">

        <!-- NAMA -->
        <div>
            <label class="block text-sm font-medium mb-1">Nama Lengkap</label>
            <input type="text" name="nama" required value="<?= old('nama') ?>"
                   class="w-full px-3 py-2 rounded-md border dark:bg-gray-700 dark:text-white">
        </div>

        <!-- EMAIL -->
        <div>
            <label class="block text-sm font-medium mb-1">Email</label>
            <input type="email" name="email" required value="<?= old('email') ?>"
                   class="w-full px-3 py-2 rounded-md border dark:bg-gray-700 dark:text-white">
        </div>

        <!-- UNIT KERJA -->
        <div>
            <label class="block text-sm font-medium mb-1">Unit Kerja</label>
            <select name="bidang_id" id="bidang" required
                    class="w-full px-3 py-2 rounded-md border dark:bg-gray-700 dark:text-white">
                <option value="">- Pilih Unit Kerja -</option>

                <?php
                $grouped = [];
                foreach ($bidang as $b) {
                    $grouped[$b['parent_id'] ?? 0][] = $b;
                }
                ?>

                <?php foreach ($grouped[0] ?? [] as $jurusan): ?>
                    <!-- JURUSAN BISA DIPILIH -->
                    <option value="<?= $jurusan['id'] ?>"
                        data-type="jurusan"
                        <?= old('bidang_id') == $jurusan['id'] ? 'selected' : '' ?>>
                        <?= esc($jurusan['nama_bidang']) ?>
                    </option>

                    <!-- PRODI -->
                    <?php foreach ($grouped[$jurusan['id']] ?? [] as $prodi): ?>
                        <option value="<?= $prodi['id'] ?>"
                            data-type="prodi"
                            <?= old('bidang_id') == $prodi['id'] ? 'selected' : '' ?>>
                            ↳ <?= esc($prodi['nama_bidang']) ?>
                        </option>
                    <?php endforeach ?>
                <?php endforeach ?>
            </select>
        </div>

        <!-- JABATAN -->
        <div>
            <label class="block text-sm font-medium mb-1">Jabatan</label>
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

        <!-- ROLE AUTO (READ ONLY) -->
        <div>
            <label class="block text-sm font-medium mb-1">Role (Otomatis)</label>
            <input type="text" id="roleInfo" readonly
                   class="w-full px-3 py-2 rounded-md border bg-gray-100 dark:bg-gray-700 dark:text-gray-300"
                   placeholder="Ditentukan oleh sistem">
        </div>

        <!-- INFO -->
        <div class="bg-blue-50 dark:bg-blue-900/30 p-3 rounded text-sm">
            🔒 Role ditentukan otomatis berdasarkan <b>Unit Kerja</b> & <b>Jabatan</b>
        </div>

        <p class="text-sm text-gray-500">Password default: <b>123456</b></p>

        <!-- ACTION -->
        <div class="flex gap-3 mt-4">
            <button type="submit" id="submitBtn"
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
    const bidang   = document.getElementById('bidang');
    const jabatan  = document.getElementById('jabatan');
    const roleInfo = document.getElementById('roleInfo');

    function updateRole() {
        const jabatanText = jabatan.options[jabatan.selectedIndex]?.dataset.nama || '';

        if (jabatanText.includes('ketua')) {
            roleInfo.value = 'atasan';
        } else if (jabatanText.includes('staff')) {
            roleInfo.value = 'staff';
        } else {
            roleInfo.value = '';
        }
    }

    bidang.addEventListener('change', updateRole);
    jabatan.addEventListener('change', updateRole);
});
</script>

<?= $this->endSection() ?>
