<?= $this->extend('layout/staff_template') ?>
<?= $this->section('content') ?>

<div class="flex items-center justify-between mb-6">
    <div>
        <h4 class="text-2xl font-semibold text-gray-800">Dokumen Saya</h4>
        <p class="text-sm text-gray-500">Riwayat pengajuan dokumen</p>
    </div>

    <a href="<?= base_url('staff/dokumen/create') ?>"
       class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg shadow">
        + Upload Dokumen
    </a>
</div>

<div class="bg-white rounded-lg shadow overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-600">
            <tr>
                <th class="p-4 border-b">Judul</th>
                <th class="p-4 border-b">Status</th>
                <th class="p-4 border-b">Catatan</th>
                <th class="p-4 border-b">Tanggal</th>
                <th class="p-4 border-b text-center">Aksi</th>
            </tr>
        </thead>

        <tbody class="divide-y">
            <?php if (empty($dokumen)): ?>
                <tr>
                    <td colspan="5" class="p-6 text-center text-gray-500">
                        Belum ada dokumen
                    </td>
                </tr>
            <?php endif; ?>

            <?php foreach ($dokumen as $d): ?>
                <tr class="hover:bg-gray-50">
                    <td class="p-4 font-medium text-gray-800">
                        <?= esc($d['judul']) ?>
                    </td>

                    <td class="p-4">
                        <?php
                        $statusMap = [
                            'pending_kaprodi'  => ['Menunggu Kaprodi', 'bg-yellow-100 text-yellow-800'],
                            'pending_kajur'    => ['Menunggu Kajur', 'bg-blue-100 text-blue-800'],
                            'rejected_kaprodi' => ['Ditolak Kaprodi', 'bg-red-100 text-red-800'],
                            'rejected_kajur'   => ['Ditolak Kajur', 'bg-red-100 text-red-800'],
                            'archived'         => ['Disetujui', 'bg-green-100 text-green-800'],
                        ];
                        [$label, $class] = $statusMap[$d['status']];
                        ?>
                        <span class="px-3 py-1 rounded-full text-xs font-semibold <?= $class ?>">
                            <?= $label ?>
                        </span>
                    </td>

                    <td class="p-4 text-gray-600">
                        <?= esc($d['catatan'] ?? '-') ?>
                    </td>

                    <td class="p-4">
                        <?= date('d M Y', strtotime($d['created_at'])) ?>
                    </td>

                    <td class="p-4 text-center">
                        <?php if (in_array($d['status'], ['rejected_kaprodi', 'rejected_kajur'])): ?>
                            <a href="<?= base_url('staff/dokumen/resubmit/'.$d['id']) ?>"
                               class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-xs">
                                Revisi
                            </a>
                        <?php endif ?>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
