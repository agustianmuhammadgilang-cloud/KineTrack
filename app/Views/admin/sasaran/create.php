<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<h3 class="text-2xl font-bold text-[var(--polban-blue)] mb-6">
    Tambah Sasaran Strategis
</h3>

<div class="bg-white p-6 rounded-xl shadow border border-gray-200">

    <form action="<?= base_url('admin/sasaran/store') ?>" method="post" class="space-y-5">

        <!-- Tahun Anggaran -->
        <div>
            <label class="block font-semibold text-gray-700 mb-1">Tahun Anggaran</label>
            <select name="tahun_id" id="tahunSelect"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 
                       focus:ring-[var(--polban-blue)] focus:outline-none" required>
                <option value="">-- Pilih Tahun --</option>
                <?php foreach($tahun as $t): ?>
                    <option value="<?= $t['id'] ?>"><?= $t['tahun'] ?></option>
                <?php endforeach ?>
            </select>
        </div>

        <!-- Kode Sasaran -->
        <div>
            <label class="block font-semibold text-gray-700 mb-1">Kode Sasaran</label>
            <input type="text" name="kode_sasaran" id="kode_sasaran" readonly
                class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-lg 
                       focus:ring-2 focus:ring-[var(--polban-blue)] focus:outline-none">
        </div>

        <!-- Nama Sasaran -->
        <div>
            <label class="block font-semibold text-gray-700 mb-1">Nama Sasaran</label>
            <textarea name="nama_sasaran" required
                class="w-full h-28 px-3 py-2 border border-gray-300 rounded-lg 
                       focus:ring-2 focus:ring-[var(--polban-blue)] focus:outline-none"></textarea>
        </div>

        <!-- Buttons -->
        <div class="flex gap-3 pt-3">
            <button class="bg-[var(--polban-blue)] text-white px-5 py-2 rounded-lg 
                           font-semibold shadow hover:bg-blue-900 transition">
                Simpan
            </button>

            <a href="<?= base_url('admin/sasaran') ?>"
                class="bg-gray-300 text-gray-700 px-5 py-2 rounded-lg font-semibold 
                       shadow hover:bg-gray-400 transition">
                Kembali
            </a>
        </div>

    </form>

</div>


<!-- AUTO-GENERATE KODE SASARAN (HANYA BERDASARKAN TAHUN) -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    const tahunSelect = document.getElementById("tahunSelect");
    const kodeInput   = document.getElementById("kode_sasaran");

    tahunSelect.addEventListener("change", function () {
        const tahun = tahunSelect.value;

        if (!tahun) {
            kodeInput.value = "";
            return;
        }

        fetch(<?= base_url('admin/sasaran/getKode/') ?>${tahun})
            .then(res => res.json())
            .then(data => kodeInput.value = data.kode)
            .catch(() => kodeInput.value = "");
    });
});
</script>

<?= $this->endSection() ?>