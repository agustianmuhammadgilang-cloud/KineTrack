<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<h3 class="text-2xl font-bold text-[var(--polban-blue)] mb-6">
    Edit Sasaran Strategis
</h3>

<div class="bg-white shadow-md rounded-xl border border-gray-200 p-6 max-w-3xl">

    <!-- NOTIFIKASI (TAMBAHAN, TANPA UBAH LOGIKA FORM) -->
    <?php if (session()->getFlashdata('error')): ?>
        <div class="mb-4 p-4 rounded-lg bg-red-100 text-red-700 font-semibold">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('admin/sasaran/update/'.$sasaran['id']) ?>" method="post">

        <!-- Tahun -->
        <div class="mb-4">
            <label class="block font-semibold text-gray-700 mb-1">Tahun Anggaran</label>

            <select 
                class="w-full px-3 py-2 border rounded-lg bg-gray-100 cursor-not-allowed"
                disabled
            >
                <?php foreach ($tahun as $t): ?>
                <option value="<?= $t['id'] ?>"
                    <?= $sasaran['tahun_id'] == $t['id'] ? 'selected' : '' ?>>
                    <?= $t['tahun'] ?>
                </option>
                <?php endforeach ?>
            </select>

            <input type="hidden" name="tahun_id" value="<?= $sasaran['tahun_id'] ?>">
        </div>

        <!-- Kode Sasaran -->
        <div class="mb-4">
            <label class="block font-semibold text-gray-700 mb-1">Kode Sasaran</label>
            <input 
                type="text"
                name="kode_sasaran"
                value="<?= $sasaran['kode_sasaran'] ?>"
                readonly
                class="w-full px-3 py-2 border rounded-lg bg-gray-100"
            >
        </div>

        <!-- Nama Sasaran -->
        <div class="mb-4">
            <label class="block font-semibold text-gray-700 mb-1">Nama Sasaran</label>
            <textarea 
                name="nama_sasaran"
                required
                class="w-full px-3 py-2 border rounded-lg h-28 focus:ring-2 focus:ring-[var(--polban-blue)]"
            ><?= old('nama_sasaran', $sasaran['nama_sasaran']) ?></textarea>
        </div>

        <!-- Buttons -->
        <div class="flex gap-3 mt-6">
            <button 
                class="bg-[var(--polban-blue)] text-white px-6 py-2 rounded-lg shadow hover:bg-blue-900 transition">
                Update
            </button>

            <a href="<?= base_url('admin/sasaran') ?>"
                class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg shadow hover:bg-gray-400 transition">
                Kembali
            </a>
        </div>

    </form>
</div>

<?= $this->endSection() ?>
