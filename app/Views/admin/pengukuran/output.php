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
            <select name="tahun_id"
                class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[var(--polban-blue)]">
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
            <select name="triwulan"
                class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[var(--polban-blue)]">
                <option value="">-- Pilih Triwulan --</option>
                <?php for($i=1;$i<=4;$i++): ?>
                <option value="<?= $i ?>" <?= ($selected_tw == $i) ? 'selected':'' ?>>
                    TW <?= $i ?>
                </option>
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
                <th class="px-4 py-3 text-left text-sm font-semibold">Satuan</th>
                <th class="px-4 py-3 text-left text-sm font-semibold">Target</th>
                <th class="px-4 py-3 text-left text-sm font-semibold">Realisasi</th>
                <th class="px-4 py-3 text-left text-sm font-semibold">Progress</th>
                <th class="px-4 py-3 text-left text-sm font-semibold">Kendala</th>
                <th class="px-4 py-3 text-left text-sm font-semibold">Strategi</th>
                <th class="px-4 py-3 text-left text-sm font-semibold">Data Dukung</th>
                <th class="px-4 py-3 text-left text-sm font-semibold">File</th>
            </tr>
        </thead>

        <tbody class="divide-y divide-gray-200">
            <?php foreach($indikator as $ind): ?>

            <?php
                $p = $pengukuran_map[$ind['id']] ?? null;
                $tw = $selected_tw;

                $target = ($ind["target_tw$tw"] !== null && $ind["target_tw$tw"] !== '')
                    ? $ind["target_tw$tw"]
                    : $ind["target_pk"];
            ?>

            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3"><?= esc($ind['nama_sasaran']) ?></td>

                <td class="px-4 py-3">
                    <?= $ind['kode_indikator'] ? '['.$ind['kode_indikator'].'] ' : '' ?>
                    <?= esc($ind['nama_indikator']) ?>
                </td>

                <td class="px-4 py-3"><?= esc($ind['satuan'] ?? '-') ?></td>

                <td class="px-4 py-3"><?= esc($target) ?></td>

                <td class="px-4 py-3"><?= esc($p['realisasi'] ?? '-') ?></td>

                <td class="px-4 py-3">
                    <?= isset($p['progress']) ? esc($p['progress']).'%' : '-' ?>
                </td>

                <td class="px-4 py-3"><?= esc($p['kendala'] ?? '-') ?></td>

                <td class="px-4 py-3"><?= esc($p['strategi'] ?? '-') ?></td>

                <td class="px-4 py-3"><?= esc($p['data_dukung'] ?? '-') ?></td>

                <td class="px-4 py-3">
                    <?php if (!empty($p['file_dukung'])): ?>
                    <a href="<?= base_url('uploads/pengukuran/'.$p['file_dukung']) ?>"
                       target="_blank"
                       class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded-lg text-sm shadow transition">
                       Lihat File
                    </a>
                    <?php else: ?>
                    <span class="text-gray-500">-</span>
                    <?php endif; ?>
                </td>
            </tr>

            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- EXPORT -->
<div class="mt-5">
    <a href="<?= base_url('admin/pengukuran/export/'.$selected_tahun.'/'.$selected_tw) ?>"
       class="px-5 py-2 border border-gray-400 rounded-lg hover:bg-gray-100 transition">
       Export
    </a>
</div>

<?php else: ?>

<!-- EMPTY STATE -->
<div class="bg-white border border-gray-300 rounded-xl p-6 text-center text-gray-600 shadow">
    Pilih Tahun & Triwulan terlebih dahulu untuk menampilkan data.
</div>

<?php endif; ?>

<?= $this->endSection() ?>
