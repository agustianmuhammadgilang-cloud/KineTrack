<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<h4 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-6">Tambah User</h4>

<div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 max-w-full md:max-w-lg mx-auto">

    <!-- Flashdata server-side -->
    <?php if(session()->getFlashdata('error')): ?>
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-lg font-medium animate-fade">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <form id="userForm" action="<?= base_url('admin/users/store'); ?>" method="POST" class="space-y-4">

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Nama</label>
            <input type="text" name="nama" id="nama" required
                   value="<?= old('nama') ?>"
                   class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 focus:ring-orange-400 focus:outline-none dark:bg-gray-700 dark:text-white">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Email</label>
            <input type="email" name="email" id="email" required
                   value="<?= old('email') ?>"
                   class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 focus:ring-orange-400 focus:outline-none dark:bg-gray-700 dark:text-white">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Jabatan</label>
            <select name="jabatan_id" required
                    class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 focus:ring-orange-400 focus:outline-none dark:bg-gray-700 dark:text-white">
                <option value="">- Pilih Jabatan -</option>
                <?php foreach($jabatan as $j): ?>
                    <option value="<?= $j['id'] ?>" <?= old('jabatan_id') == $j['id'] ? 'selected' : '' ?>>
                        <?= esc($j['nama_jabatan']) ?>
                    </option>
                <?php endforeach ?>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Bidang</label>
            <select name="bidang_id" required
                    class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 focus:ring-orange-400 focus:outline-none dark:bg-gray-700 dark:text-white">
                <option value="">- Pilih Bidang -</option>
                <?php foreach($bidang as $b): ?>
                    <option value="<?= $b['id'] ?>" <?= old('bidang_id') == $b['id'] ? 'selected' : '' ?>>
                        <?= esc($b['nama_bidang']) ?>
                    </option>
                <?php endforeach ?>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Role</label>
            <select name="role" required
                    class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 focus:ring-orange-400 focus:outline-none dark:bg-gray-700 dark:text-white">
                <option value="staff" <?= old('role') == 'staff' ? 'selected' : '' ?>>Staff</option>
                <option value="atasan" <?= old('role') == 'atasan' ? 'selected' : '' ?>>Atasan</option>
                <option value="admin" <?= old('role') == 'admin' ? 'selected' : '' ?>>Admin</option>
            </select>
        </div>

        <p class="text-sm text-gray-500 dark:text-gray-400">Password default: <b>123456</b></p>

        <!-- Realtime Duplicate Alert -->
        <div id="duplicateAlert" class="hidden text-red-500 text-sm font-medium p-2 rounded bg-red-50 dark:bg-red-700 dark:text-red-100 transition-all duration-300 opacity-0">
            Akun ini sudah terdaftar!
        </div>

        <div class="flex flex-col md:flex-row gap-3 mt-4">
            <button type="submit" id="submitBtn" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-md font-medium shadow-md w-full md:w-auto text-center">
                Simpan
            </button>
            <a href="<?= base_url('admin/users'); ?>" 
               class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded-md font-medium w-full md:w-auto text-center">
               Kembali
            </a>
        </div>

    </form>
</div>

<style>
/* Animasi fade untuk alert */
@keyframes fadeInOut {
    0% { opacity: 0; transform: translateY(-5px); }
    10% { opacity: 1; transform: translateY(0); }
    90% { opacity: 1; transform: translateY(0); }
    100% { opacity: 0; transform: translateY(-5px); }
}
.animate-fade {
    animation: fadeInOut 3s ease forwards;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('userForm');
    const submitBtn = document.getElementById('submitBtn');
    const alertBox = document.getElementById('duplicateAlert');
    const namaInput = document.getElementById('nama');
    const emailInput = document.getElementById('email');

    async function checkDuplicate() {
        const nama = namaInput.value.trim();
        const email = emailInput.value.trim();
        if (!nama || !email) return false;

        try {
            const response = await fetch("<?= base_url('admin/users/check-duplicate') ?>", {
                method: "POST",
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ nama, email })
            });
            const result = await response.json();
            return result.exists;
        } catch (err) {
            console.error(err);
            return false;
        }
    }

    form.addEventListener('submit', async (e) => {
        alertBox.classList.add('hidden', 'opacity-0');

        const isDuplicate = await checkDuplicate();
        if (isDuplicate) {
            e.preventDefault();
            alertBox.classList.remove('hidden');
            setTimeout(() => alertBox.classList.add('opacity-100'), 10); // trigger fade
            submitBtn.disabled = true;
            return false;
        }
    });

    // Realtime check while typing
    [namaInput, emailInput].forEach(input => {
        input.addEventListener('input', async () => {
            const isDuplicate = await checkDuplicate();
            if (isDuplicate) {
                alertBox.classList.remove('hidden');
                alertBox.classList.add('opacity-100');
                submitBtn.disabled = true;
            } else {
                alertBox.classList.add('hidden');
                alertBox.classList.remove('opacity-100');
                submitBtn.disabled = false;
            }
        });
    });
});
</script>

<?= $this->endSection() ?>
