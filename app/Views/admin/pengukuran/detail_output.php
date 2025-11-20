<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<h3 class="text-2xl font-bold text-[var(--polban-blue)] mb-6">
    Detail Pengukuran Indikator
</h3>

<!-- CARD -->
<div class="bg-white shadow-md rounded-xl p-6 border border-gray-200">
    
    <h4 class="text-xl font-semibold mb-2">
        <?= esc($indikator['nama_indikator']) ?>
    </h4>
    <p class="text-gray-600 mb-4">
        <strong>Sasaran:</strong> <?= esc($indikator['nama_sasaran']) ?>
    </p>

    <table class="min-w-full divide-y divide-gray-200">
        <tr>
            <td class="font-semibold px-4 py-2 w-40">Target</td>
            <td class="px-4 py-2">
                <?= esc($indikator['target_pk']) ?>
            </td>
        </tr>

        <tr>
            <td class="font-semibold px-4 py-2">Realisasi</td>
            <td class="px-4 py-2">
                <?= esc($pengukuran['realisasi'] ?? '-') ?>
            </td>
        </tr>

        <tr>
            <td class="font-semibold px-4 py-2">Progress</td>
            <td class="px-4 py-2">
                <?= isset($pengukuran['progress']) ? $pengukuran['progress'].'%' : '-' ?>
            </td>
        </tr>

        <tr>
            <td class="font-semibold px-4 py-2">Kendala</td>
            <td class="px-4 py-2">
                <?= esc($pengukuran['kendala'] ?? '-') ?>
            </td>
        </tr>

        <tr>
            <td class="font-semibold px-4 py-2">Strategi</td>
            <td class="px-4 py-2">
                <?= esc($pengukuran['strategi'] ?? '-') ?>
            </td>
        </tr>

        <tr>
            <td class="font-semibold px-4 py-2">Data Dukung</td>
            <td class="px-4 py-2">
                <?= esc($pengukuran['data_dukung'] ?? '-') ?>
            </td>
        </tr>

        <tr>
            <td class="font-semibold px-4 py-2">File Dukung</td>
            <td class="px-4 py-2">
                <?php if (!empty($pengukuran['file_dukung'])): ?>
                    <a href="<?= base_url('uploads/pengukuran/'.$pengukuran['file_dukung']) ?>"
                       class="text-blue-600 hover:underline" target="_blank">
                       Lihat File
                    </a>
                <?php else: ?>
                    -
                <?php endif; ?>
            </td>
        </tr>
    </table>

</div>

<!-- BUTTON -->
<div class="mt-5">
    <a href="<?= base_url('admin/pengukuran/output?tahun_id='.$tahun_id.'&triwulan='.$tw) ?>"
        class="bg-gray-500 text-white px-4 py-2 rounded-lg shadow hover:bg-gray-600 transition">
        Kembali
    </a>
</div>

<?= $this->endSection() ?>