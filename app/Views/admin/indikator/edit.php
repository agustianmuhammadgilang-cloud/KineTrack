<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<h3 class="text-2xl font-bold text-[var(--polban-blue)] mb-6">
    Edit Indikator Kinerja
</h3>

<div class="bg-white p-6 rounded-xl shadow border border-gray-200">

<form action="<?= base_url('admin/indikator/update/'.$indikator['id']) ?>" method="post" class="space-y-5">

    <!-- SASARAN -->
    <div>
        <label class="block font-semibold text-gray-700 mb-1">Sasaran Strategis</label>
        <select name="sasaran_id"
            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-[var(--polban-blue)]">
            <?php foreach($sasaran as $s): ?>
            <option value="<?= $s['id'] ?>"
                <?= $indikator['sasaran_id']==$s['id']?'selected':'' ?>>
                <?= $s['kode_sasaran'] ?> — <?= $s['nama_sasaran'] ?> (<?= $s['tahun'] ?>)
            </option>
            <?php endforeach ?>
        </select>
    </div>

    <!-- KODE -->
    <div>
        <label class="block font-semibold text-gray-700 mb-1">Kode Indikator</label>
        <input type="text" name="kode_indikator"
            value="<?= $indikator['kode_indikator'] ?>"
            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-[var(--polban-blue)]">
    </div>

    <!-- NAMA INDIKATOR -->
    <div>
        <label class="block font-semibold text-gray-700 mb-1">Nama Indikator</label>
        <textarea name="nama_indikator"
            class="w-full border border-gray-300 rounded-lg px-3 py-2 h-24 focus:ring-2 focus:ring-[var(--polban-blue)]"><?= $indikator['nama_indikator'] ?></textarea>
    </div>

    <!-- SATUAN -->
    <div>
        <label class="block font-semibold text-gray-700 mb-1">Satuan</label>
        <input type="text" name="satuan"
            value="<?= $indikator['satuan'] ?>"
            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-[var(--polban-blue)]">
    </div>

    <!-- TARGET PK -->
    <div>
        <label class="block font-semibold text-gray-700 mb-1">Target PK</label>
        <input type="number" name="target_pk"
            value="<?= $indikator['target_pk'] ?>"
            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-[var(--polban-blue)]">
    </div>

    <hr class="my-4 border-gray-300">

    <!-- TARGET PER TW -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

        <div>
            <label class="block font-semibold text-gray-700 mb-1">TW1</label>
            <input type="number" name="target_tw1"
                value="<?= $indikator['target_tw1'] ?>"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-[var(--polban-blue)]">
        </div>

        <div>
            <label class="block font-semibold text-gray-700 mb-1">TW2</label>
            <input type="number" name="target_tw2"
                value="<?= $indikator['target_tw2'] ?>"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-[var(--polban-blue)]">
        </div>

        <div>
            <label class="block font-semibold text-gray-700 mb-1">TW3</label>
            <input type="number" name="target_tw3"
                value="<?= $indikator['target_tw3'] ?>"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-[var(--polban-blue)]">
        </div>

        <div>
            <label class="block font-semibold text-gray-700 mb-1">TW4</label>
            <input type="number" name="target_tw4"
                value="<?= $indikator['target_tw4'] ?>"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-[var(--polban-blue)]">
        </div>

    </div>

    <!-- BUTTONS -->
    <div class="flex gap-3 pt-4">
        <button class="bg-[var(--polban-blue)] text-white px-6 py-2 rounded-lg shadow hover:bg-blue-900 transition">
            Update
        </button>

        <a href="<?= base_url('admin/indikator') ?>"
            class="px-6 py-2 rounded-lg bg-gray-300 text-gray-800 shadow hover:bg-gray-400 transition">
            Kembali
        </a>
    </div>

</form>

</div>

<?= $this->endSection() ?>