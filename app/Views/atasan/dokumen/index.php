<?= $this->extend('layout/atasan_template') ?>
<?= $this->section('content') ?>

<div class="flex items-center justify-between mb-6">
    <div>
        <h4 class="text-2xl font-semibold text-gray-800">Dokumen Masuk</h4>
        <p class="text-sm text-gray-500">Dokumen yang menunggu persetujuan Anda</p>
    </div>
</div>

<div class="bg-white rounded-lg shadow overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-600">
            <tr>
                <th class="p-4 border-b">Judul</th>
                <th class="p-4 border-b">Unit Pengirim</th>
                <th class="p-4 border-b">Tanggal</th>
                <th class="p-4 border-b text-center">Aksi</th>
            </tr>
        </thead>

        <tbody class="divide-y">
            <?php if (empty($dokumen)): ?>
                <tr>
                    <td colspan="4" class="p-6 text-center text-gray-500">
                        Tidak ada dokumen masuk
                    </td>
                </tr>
            <?php endif; ?>

            <?php foreach ($dokumen as $d): ?>
                <tr class="hover:bg-gray-50">
                    <td class="p-4 font-medium text-gray-800">
                        <?= esc($d['judul']) ?>
                    </td>

                    <td class="p-4 text-gray-600">
                        <?= esc($d['unit_asal_id']) ?>
                    </td>

                    <td class="p-4">
                        <?= date('d M Y', strtotime($d['created_at'])) ?>
                    </td>

                    <td class="p-4 text-center">
                        <a href="<?= base_url('atasan/dokumen/review/'.$d['id']) ?>"
                           class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-1.5 rounded-lg text-xs shadow">
                            Review
                        </a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
