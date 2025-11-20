<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<h3 class="text-2xl font-bold text-[var(--polban-blue)] mb-6">
    Edit Tahun Anggaran
</h3>

<div class="bg-white shadow border border-gray-200 rounded-xl p-6 max-w-xl">

    <form action="<?= base_url('admin/tahun/update/'.$tahun['id']) ?>" method="post">

        <!-- Tahun -->
        <div class="mb-5">
            <label class="block font-semibold text-gray-700 mb-1">Tahun</label>
            <input 
                type="number" 
                name="tahun" 
                value="<?= $tahun['tahun'] ?>"
                required
                class="w-full px-4 py-2 border border-gray-300 rounded-lg 
                       focus:ring-2 focus:ring-[var(--polban-blue)] focus:outline-none">
        </div>

        <!-- Status -->
        <div class="mb-6">
            <label class="block font-semibold text-gray-700 mb-1">Status</label>
            <select 
    name="status"
    class="w-full px-4 py-2 border border-gray-300 rounded-lg 
           focus:ring-2 focus:ring-[var(--polban-blue)] focus:outline-none">

    <option value="active" 
        <?= $tahun['status']=='active'?'selected':'' ?>>
        Aktif
    </option>

    <option value="inactive" 
        <?= $tahun['status']=='inactive'?'selected':'' ?>>
        Tidak Aktif
    </option>

</select>
        </div>

        <!-- Buttons -->
        <div class="flex gap-3">
            <button 
                class="bg-[var(--polban-blue)] text-white px-5 py-2 rounded-lg 
                       hover:bg-blue-900 transition shadow">
                Update
            </button>

            <a href="<?= base_url('admin/tahun') ?>"
               class="bg-gray-300 text-gray-800 px-5 py-2 rounded-lg
                      hover:bg-gray-400 transition shadow">
                Kembali
            </a>
        </div>

    </form>

</div>

<?= $this->endSection() ?>
