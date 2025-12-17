<?= $this->extend('layout/staff_template') ?>
<?= $this->section('content') ?>

<div class="mb-6">
    <h4 class="text-2xl font-semibold text-gray-800">Dokumen Disetujui</h4>
    <p class="text-sm text-gray-500">Dokumen yang telah diarsipkan</p>
</div>

<div class="bg-white rounded-lg shadow overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-600">
            <tr>
                <th class="p-4 border-b">Judul</th>
                <th class="p-4 border-b">Tanggal</th>
                <th class="p-4 border-b text-center">File</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            <?php foreach ($dokumen as $d): ?>
            <tr class="hover:bg-gray-50">
                <td class="p-4 font-medium"><?= esc($d['judul']) ?></td>
                <td class="p-4"><?= date('d M Y', strtotime($d['updated_at'])) ?></td>
                <td class="p-4 text-center">
                    <a href="<?= base_url('uploads/dokumen/'.$d['file_path']) ?>" target="_blank"
                       class="text-blue-600 hover:underline">
                        Download
                    </a>
                </td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
