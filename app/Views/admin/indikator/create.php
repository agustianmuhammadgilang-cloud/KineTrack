<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<h3 class="text-2xl font-bold text-[var(--polban-blue)] mb-6">
    Tambah Indikator Kinerja
</h3>

<div class="bg-white p-6 rounded-xl shadow-md border border-gray-200 max-w-3xl">
    <form action="<?= base_url('admin/indikator/store') ?>" method="post" class="space-y-5">

        <!-- ===================== TAHUN ===================== -->
        <div>
            <label class="block font-semibold text-gray-700 mb-1">Tahun</label>
            <select id="tahunSelect" required
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[var(--polban-blue)]">
                <option value="">-- Pilih Tahun --</option>

                <?php 
                $listTahun = array_unique(array_column($sasaran, 'tahun')); 
                sort($listTahun);
                foreach ($listTahun as $t): ?>
                    <option value="<?= $t ?>"><?= $t ?></option>
                <?php endforeach ?>
            </select>
        </div>

        <!-- ===================== SASARAN ===================== -->
        <div>
            <label class="block font-semibold text-gray-700 mb-1">Sasaran</label>
            <select id="sasaranSelect" name="sasaran_id" required
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[var(--polban-blue)]">
                <option value="">-- Pilih Tahun Terlebih Dahulu --</option>
            </select>
        </div>

        <!-- ===================== KODE INDIKATOR ===================== -->
        <div>
            <label class="block font-semibold text-gray-700 mb-1">Kode Indikator</label>
            <input type="text" id="kode_indikator" name="kode_indikator" 
                readonly class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-lg">
        </div>


        <!-- ===================== NAMA INDIKATOR ===================== -->
        <div>
            <label class="block font-semibold text-gray-700 mb-1">Nama Indikator</label>
            <textarea name="nama_indikator" required
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[var(--polban-blue)] h-28"></textarea>
        </div>

        <!-- ===================== SATUAN ===================== -->
        <div>
            <label class="block font-semibold text-gray-700 mb-1">Satuan</label>
            <input type="text" name="satuan" placeholder="% / Unit / Dokumen / dll"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[var(--polban-blue)]">
        </div>

        <!-- ===================== TARGET PK ===================== -->
        <div>
            <label class="block font-semibold text-gray-700 mb-1">Target PK</label>
            <input type="number" name="target_pk"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[var(--polban-blue)]">
        </div>

        <hr class="my-4">

        <!-- ===================== TARGET TW ===================== -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block font-semibold text-gray-700 mb-1">TW1</label>
                <input type="number" name="target_tw1"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[var(--polban-blue)]">
            </div>

            <div>
                <label class="block font-semibold text-gray-700 mb-1">TW2</label>
                <input type="number" name="target_tw2"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[var(--polban-blue)]">
            </div>

            <div>
                <label class="block font-semibold text-gray-700 mb-1">TW3</label>
                <input type="number" name="target_tw3"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[var(--polban-blue)]">
            </div>

            <div>
                <label class="block font-semibold text-gray-700 mb-1">TW4</label>
                <input type="number" name="target_tw4"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[var(--polban-blue)]">
            </div>
        </div>

        <!-- ===================== BUTTON ===================== -->
        <div class="flex gap-3 pt-3">
            <button
                class="bg-[var(--polban-blue)] text-white px-6 py-2 rounded-lg font-semibold hover:bg-blue-900 shadow">
                Simpan
            </button>

            <a href="<?= base_url('admin/indikator') ?>"
                class="px-6 py-2 rounded-lg font-semibold border border-gray-400 text-gray-700 hover:bg-gray-100">
                Kembali
            </a>
        </div>

    </form>
</div>

<!-- ===================== JS ===================== -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    const tahunSelect = document.getElementById("tahunSelect");
    const sasaranSelect = document.getElementById("sasaranSelect"); // FIXED
    const kodeInput = document.getElementById("kode_indikator");


    const sasaranData = [
        <?php foreach($sasaran as $s): ?>
        { id: "<?= $s['id'] ?>", tahun: "<?= $s['tahun'] ?>", label: "<?= $s['kode_sasaran'] ?> — <?= $s['nama_sasaran'] ?>" },
        <?php endforeach ?>
    ];

    tahunSelect.addEventListener("change", function () {
        const selectedYear = this.value;
        sasaranSelect.innerHTML = '';

        if (!selectedYear) {
            sasaranSelect.append(new Option("-- Pilih Tahun Terlebih Dahulu --", ""));
            kodeInput.value = "";
            return;
        }

        sasaranSelect.append(new Option("-- Pilih Sasaran --", ""));

        sasaranData.forEach(s => {
            if (s.tahun === selectedYear) {
                sasaranSelect.append(new Option(s.label, s.id));
            }
        });
    });

    sasaranSelect.addEventListener("change", function () {
        const id = this.value;

        if (!id) {
            kodeInput.value = "";
            return;
        }

        fetch("<?= base_url('admin/indikator/getKode/') ?>" + id)
            .then(res => res.json())
            .then(data => {
                kodeInput.value = data.kode;
            });
    });
});
</script>


<?= $this->endSection() ?>
