<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<h3 class="text-2xl font-bold text-[var(--polban-blue)] mb-6">
    Pengukuran Kinerja (Output)
</h3>

<?php if (!empty($selected_tahun) && !empty($selected_tw)) : ?>
<div class="flex justify-end mb-4 gap-3">

    <!-- Export Excel -->
    <a href="<?= base_url('admin/pengukuran/export/'.$selected_tahun.'/'.$selected_tw) ?>"
       class="flex items-center gap-2 px-4 py-2 bg-green-600 text-white rounded-lg shadow 
              hover:bg-green-700 transition font-semibold">
        <!-- Excel Icon -->
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
            <path d="M19 2H8c-1.1 0-2 .9-2 2v3H5c-1.1 0-2 .9-2 2v8c0 
            1.1.9 2 2 2h1v3c0 1.1.9 2 2 2h11c1.1 0 2-.9 
            2-2V4c0-1.1-.9-2-2-2zm0 19H8v-3h8c1.1 0 2-.9 
            2-2V5h1v16zM7 9v8H5V9h2zm10 8H8V5h9v12z"/>
        </svg>
        Export Excel
    </a>

    <!-- VIEW PDF -->
    <a href="<?= base_url('admin/pengukuran/output/report/'.$selected_tahun.'/'.$selected_tw.'/view') ?>"
    target="_blank"
    class="flex items-center gap-2 px-4 py-2 bg-red-500 text-white rounded-lg shadow 
            hover:bg-red-600 transition font-semibold">
        Export PDF
    </a>


</div>
<?php endif; ?>




<!-- FILTER CARD -->
<div class="bg-white shadow-md rounded-xl p-6 mb-6 border border-gray-200">
    <form method="get" action="<?= base_url('admin/pengukuran/output') ?>" 
          class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <!-- Tahun -->
        <div>
            <label class="font-semibold text-gray-700">Pilih Tahun</label>
            <select name="tahun_id"
                class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[var(--polban-blue)]">
                <?php foreach($tahun as $t): ?>
                    <option value="<?= $t['id'] ?>" <?= ($selected_tahun == $t['id']) ? 'selected':'' ?>>
                        <?= $t['tahun'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Triwulan Buttons -->
        <div>

            <div class="flex gap-2 mt-2 justify-end">

                <?php for ($i = 1; $i <= 4; $i++): ?>
                    <button type="submit" name="triwulan" value="<?= $i ?>"
                        class="px-4 py-2 text-sm font-semibold rounded-xl border transition shadow-sm
                        <?= ($selected_tw == $i)
                            ? 'bg-[var(--polban-blue)] text-white border-[var(--polban-blue)] shadow-md'
                            : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-100' ?>">
                        TW <?= $i ?>
                    </button>
                <?php endfor; ?>

            </div>
        </div>

    </form>
</div>


<?php if (!empty($indikator)): ?>
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
            // Group by sasaran (Gunakan kode + nama)
            $grouped = [];
            foreach ($indikator as $ind) {
                $key = '[' . $ind['kode_sasaran'] . '] ' . $ind['nama_sasaran'];
                $grouped[$key][] = $ind;
            }

            foreach ($grouped as $sasaran => $inds):
                foreach ($inds as $idx => $ind):

                    $tw = $selected_tw;
                    $target = (!empty($ind["target_tw$tw"])) ? $ind["target_tw$tw"] : $ind["target_pk"];
            ?>

            <tr class="hover:bg-gray-50">

                <?php if ($idx == 0): ?>
                <td rowspan="<?= count($inds) ?>" class="px-4 py-3 align-top font-medium text-gray-800">
                    <?= esc($sasaran) ?>
                </td>
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

            <?php endforeach; endforeach; ?>

        </tbody>
    </table>
</div>
<?php endif; ?>


<?= $this->endSection() ?>
