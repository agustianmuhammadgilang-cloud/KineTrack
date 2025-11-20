<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<h3 class="text-2xl font-bold text-[var(--polban-blue)] mb-6">
    Pengukuran Kinerja (Output)
</h3>

<!-- FILTER CARD -->
<div class="bg-white shadow-md rounded-xl p-6 mb-6 border border-gray-200">
    <form method="get" action="<?= base_url('admin/pengukuran/output') ?>" class="grid grid-cols-1 md:grid-cols-3 gap-5">

        <!-- Tahun -->
        <div>
            <label class="font-semibold text-gray-700">Pilih Tahun</label>
            <select name="tahun_id" class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[var(--polban-blue)]">
                <option value="">-- Pilih Tahun --</option>
                <?php foreach($tahun as $t): ?>
                    <option value="<?= $t['id'] ?>" <?= ($selected_tahun == $t['id']) ? 'selected':'' ?>>
                        <?= $t['tahun'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Triwulan -->
        <div>
            <label class="font-semibold text-gray-700">Triwulan</label>
            <select name="triwulan" class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[var(--polban-blue)]">
                <option value="">-- Pilih Triwulan --</option>
                <?php for($i=1;$i<=4;$i++): ?>
                    <option value="<?= $i ?>" <?= ($selected_tw == $i) ? 'selected':'' ?>>TW <?= $i ?></option>
                <?php endfor; ?>
            </select>
        </div>

        <!-- Button -->
        <div class="flex items-end">
            <button class="w-full bg-[var(--polban-orange)] text-white py-3 rounded-lg font-semibold shadow hover:bg-orange-600 transition">
                Tampilkan
            </button>
        </div>

    </form>
</div>

<?php if(!empty($indikator)): ?>

<!-- TABLE -->
<div class="overflow-x-auto shadow-md rounded-xl border border-gray-200 bg-white">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-[var(--polban-blue)] text-white">
            <tr>
                <th class="px-4 py-3 text-left text-sm font-semibold">Sasaran</th>
                <th class="px-4 py-3 text-left text-sm font-semibold">Indikator</th>
                <th class="px-4 py-3 text-left text-sm font-semibold">Target</th>
                <th class="px-4 py-3 text-left text-sm font-semibold">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            <?php
            // Kelompokkan indikator berdasarkan sasaran
            $grouped = [];
            foreach($indikator as $ind) {
                $grouped[$ind['nama_sasaran']][] = $ind;
            }

            foreach($grouped as $sasaran => $inds):
                $rowspan = count($inds);
                foreach($inds as $idx => $ind):

                    $p = $pengukuran_map[$ind['id']] ?? null;
                    $tw = $selected_tw;

                    $target = (!empty($ind["target_tw$tw"])) 
                                ? $ind["target_tw$tw"] 
                                : $ind["target_pk"];
            ?>
            <tr class="hover:bg-gray-50">
                <?php if($idx == 0): ?>
                    <td class="px-4 py-3" rowspan="<?= $rowspan ?>"><?= esc($sasaran) ?></td>
                <?php endif; ?>

                <td class="px-4 py-3">
                    <?= $ind['kode_indikator'] ? '['.$ind['kode_indikator'].'] ' : '' ?>
                    <?= esc($ind['nama_indikator']) ?>
                </td>

                <td class="px-4 py-3"><?= esc($target) ?></td>

                <td class="px-4 py-3">
    <a href="<?= base_url('admin/pengukuran/output/detail/'.$ind['id'].'/'.$selected_tahun.'/'.$selected_tw) ?>"
   class="bg-blue-600 text-white px-3 py-1 rounded-lg text-sm hover:bg-blue-700 transition">
   Detail
</a>
                </td>
            </tr>
            <?php
                endforeach;
            endforeach;
            ?>
        </tbody>
    </table>
</div>

<!-- DETAIL MODAL -->
<div id="detailModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-lg w-11/12 md:w-1/2 p-6 relative">
        <button id="closeModal" class="absolute top-3 right-3 text-gray-500 hover:text-gray-800">&times;</button>
        <h3 class="text-xl font-semibold mb-4">Detail Pengukuran</h3>

        <table class="min-w-full divide-y divide-gray-200">
            <tr>
                <td class="font-semibold px-4 py-2">Realisasi</td>
                <td id="modalRealisasi" class="px-4 py-2"></td>
            </tr>
            <tr>
                <td class="font-semibold px-4 py-2">Progress</td>
                <td id="modalProgress" class="px-4 py-2"></td>
            </tr>
            <tr>
                <td class="font-semibold px-4 py-2">Kendala</td>
                <td id="modalKendala" class="px-4 py-2"></td>
            </tr>
            <tr>
                <td class="font-semibold px-4 py-2">Strategi</td>
                <td id="modalStrategi" class="px-4 py-2"></td>
            </tr>
            <tr>
                <td class="font-semibold px-4 py-2">Data Dukung</td>
                <td id="modalDataDukung" class="px-4 py-2"></td>
            </tr>
            <tr>
                <td class="font-semibold px-4 py-2">File</td>
                <td id="modalFile" class="px-4 py-2"></td>
            </tr>
        </table>
    </div>
</div>

<script>
document.querySelectorAll('.detail-btn').forEach(btn => {
    btn.addEventListener('click', function(){
        document.getElementById('modalRealisasi').textContent = this.dataset.realisasi;
        document.getElementById('modalProgress').textContent = this.dataset.progress;
        document.getElementById('modalKendala').textContent = this.dataset.kendala;
        document.getElementById('modalStrategi').textContent = this.dataset.strategi;
        document.getElementById('modalDataDukung').textContent = this.dataset.dataDukung;

        const fileLink = this.dataset.file;
        if(fileLink) {
            document.getElementById('modalFile').innerHTML =
                <a href="${fileLink}" target="_blank" class="text-blue-600 hover:underline">Lihat File</a>;
        } else {
            document.getElementById('modalFile').textContent = '-';
        }

        document.getElementById('detailModal').classList.remove('hidden');
        document.getElementById('detailModal').classList.add('flex');
    });
});

document.getElementById('closeModal').addEventListener('click', function(){
    document.getElementById('detailModal').classList.add('hidden');
    document.getElementById('detailModal').classList.remove('flex');
});
</script>

<?php endif; ?> <!-- ⭐ WAJIB ADA, TANPA INI ERROR -->

<?= $this->endSection() ?>