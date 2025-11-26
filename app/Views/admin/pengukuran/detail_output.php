<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<h3 class="text-2xl font-bold text-[var(--polban-blue)] mb-6">
    Detail Pengukuran Indikator
</h3>

<div class="bg-white shadow-md rounded-xl p-6 border border-gray-200">

    <!-- HEADER INDIKATOR -->
    <h4 class="text-xl font-semibold mb-2">
        <?= esc($indikator['nama_indikator']) ?>
    </h4>
    <p class="text-gray-600 mb-4">
        <strong>Sasaran:</strong> 
        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-sm">
            <?= esc($indikator['nama_sasaran']) ?>
        </span>
    </p>

    <!-- ==================================== -->
    <!--          DAFTAR SELURUH PIC          -->
    <!-- ==================================== -->
    <?php 
        use App\Models\PicModel; 
        $pic = (new PicModel())->getPicByIndikator($indikator['id']); 
    ?>

    <h4 class="text-lg font-semibold mb-4">PIC Terkait</h4>
    <?php if (!empty($pic)): ?>
        <div class="flex flex-wrap gap-4 mb-6">
            <?php foreach ($pic as $p): ?>
                <div class="bg-gray-100 px-3 py-2 rounded-lg shadow-sm">
                    <strong><?= esc($p['nama']) ?></strong> 
                    <span class="text-sm text-gray-600">(<?= esc($p['email']) ?>)</span>
                    <div class="text-xs text-gray-500"><?= esc($p['nama_jabatan']) ?> / <?= esc($p['nama_bidang']) ?></div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="text-gray-600 italic mb-6">Belum ada PIC yang ditetapkan.</p>
    <?php endif; ?>

    <!-- ==================================== -->
    <!--        DATA PENGUKURAN PER PIC        -->
    <!-- ==================================== -->
    <?php if (!empty($pengukuran)): ?>
        <?php foreach ($pengukuran as $pk): ?>
            <div class="border border-gray-300 rounded-lg p-4 bg-gray-50 mb-4 hover:shadow-lg transition">
                <div class="mb-3 pb-2 border-b border-gray-300">
                    <h4 class="font-semibold text-lg text-gray-800">
                        <?= esc($pk['pic_nama'] ?? 'PIC Tidak Ditemukan') ?>
                    </h4>
                    <?php if (!empty($pk['pic_email'])): ?>
                        <p class="text-sm text-gray-600">
                            <?= esc($pk['pic_email']) ?> — 
                            <?= esc($pk['nama_jabatan'] ?? '-') ?> / 
                            <?= esc($pk['nama_bidang'] ?? '-') ?>
                        </p>
                    <?php endif; ?>
                </div>

                <table class="min-w-full table-auto border-collapse border border-gray-200">
                    <tr class="bg-gray-100">
                        <td class="font-semibold px-4 py-2 w-40 border-b border-gray-200">Target</td>
                        <td class="px-4 py-2 border-b border-gray-200"><?= esc($indikator['target_pk'] ?? '-') ?></td>
                    </tr>
                    <tr class="bg-white">
                        <td class="font-semibold px-4 py-2 border-b border-gray-200">Realisasi</td>
                        <td class="px-4 py-2 border-b border-gray-200"><?= esc($pk['realisasi'] ?? '-') ?></td>
                    </tr>
                    <tr class="bg-gray-100">
                        <td class="font-semibold px-4 py-2 border-b border-gray-200">Progress</td>
                        <td class="px-4 py-2 border-b border-gray-200"><?= isset($pk['progress']) ? esc($pk['progress']).'%' : '-' ?></td>
                    </tr>
                    <tr class="bg-white">
                        <td class="font-semibold px-4 py-2 border-b border-gray-200">Kendala</td>
                        <td class="px-4 py-2 border-b border-gray-200"><?= esc($pk['kendala'] ?? '-') ?></td>
                    </tr>
                    <tr class="bg-gray-100">
                        <td class="font-semibold px-4 py-2 border-b border-gray-200">Strategi</td>
                        <td class="px-4 py-2 border-b border-gray-200"><?= esc($pk['strategi'] ?? '-') ?></td>
                    </tr>
                    <tr class="bg-white">
                        <td class="font-semibold px-4 py-2 border-b border-gray-200">File Dukung</td>
                        <td class="px-4 py-2 border-b border-gray-200">
                            <?php if (!empty($pk['file_dukung'])): ?>
                                <a href="<?= base_url('uploads/pengukuran/'.$pk['file_dukung']) ?>"
                                   class="text-blue-600 hover:underline flex items-center gap-1" target="_blank">
                                    <i class="fas fa-file-alt"></i> Lihat File
                                </a>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                    </tr>
                </table>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="text-gray-600 italic mt-4">Belum ada data pengukuran dari PIC manapun.</p>
    <?php endif; ?>

</div>

<!-- BUTTON KEMBALI -->
<div class="mt-5">
    <a href="<?= base_url('admin/pengukuran/output?tahun_id='.$tahun_id.'&triwulan='.$tw) ?>"
       class="bg-gray-500 text-white px-4 py-2 rounded-lg shadow hover:bg-gray-600 flex items-center gap-2 transition">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<?= $this->endSection() ?>