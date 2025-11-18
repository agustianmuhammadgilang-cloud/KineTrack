<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<h4 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-6">Edit User</h4>

<div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 max-w-lg">
    <form action="<?= base_url('admin/users/update/'.$user['id']); ?>" method="POST" class="space-y-4">

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Nama</label>
            <input type="text" name="nama" value="<?= esc($user['nama']) ?>" required
                   class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 focus:ring-orange-400 focus:outline-none dark:bg-gray-700 dark:text-white">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Email</label>
            <input type="email" name="email" value="<?= esc($user['email']) ?>" required
                   class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 focus:ring-orange-400 focus:outline-none dark:bg-gray-700 dark:text-white">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Jabatan</label>
            <select name="jabatan_id" required
                    class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 focus:ring-orange-400 focus:outline-none dark:bg-gray-700 dark:text-white">
                <?php foreach($jabatan as $j): ?>
                <option value="<?= $j['id'] ?>" <?= $j['id']==$user['jabatan_id']?'selected':'' ?>>
                    <?= esc($j['nama_jabatan']) ?>
                </option>
                <?php endforeach ?>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Bidang</label>
            <select name="bidang_id" required
                    class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 focus:ring-orange-400 focus:outline-none dark:bg-gray-700 dark:text-white">
                <?php foreach($bidang as $b): ?>
                <option value="<?= $b['id'] ?>" <?= $b['id']==$user['bidang_id']?'selected':'' ?>>
                    <?= esc($b['nama_bidang']) ?>
                </option>
                <?php endforeach ?>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Role</label>
            <select name="role" required
                    class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 focus:ring-orange-400 focus:outline-none dark:bg-gray-700 dark:text-white">
                <option value="staff" <?= $user['role']=='staff'?'selected':'' ?>>Staff</option>
                <option value="atasan" <?= $user['role']=='atasan'?'selected':'' ?>>Atasan</option>
                <option value="admin" <?= $user['role']=='admin'?'selected':'' ?>>Admin</option>
            </select>
        </div>

        <div class="flex gap-3 mt-4">
            <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-md font-medium shadow-md transition">
                Update
            </button>
            <a href="<?= base_url('admin/users'); ?>" 
               class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded-md font-medium transition">
               Kembali
            </a>
        </div>

    </form>
</div>

<?= $this->endSection() ?>
