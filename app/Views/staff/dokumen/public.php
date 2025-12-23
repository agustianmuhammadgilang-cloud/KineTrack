<?= $this->extend('layout/staff_template') ?>
<?= $this->section('content') ?>

<h4 class="text-xl font-semibold text-gray-800 mb-6">
    Dokumen Publik
</h4>

<div class="bg-white rounded-xl shadow p-6">

    <!-- Filter -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <select class="border rounded px-3 py-2">
            <option>Tahun</option>
        </select>
        <select class="border rounded px-3 py-2">
            <option>Unit</option>
        </select>
        <select class="border rounded px-3 py-2">
            <option>Kategori</option>
        </select>
    </div>

    <!-- Table -->
    <table class="w-full text-sm">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-3 text-left">Judul</th>
                <th class="p-3">Unit</th>
                <th class="p-3">Tahun</th>
                <th class="p-3">Publish</th>
                <th class="p-3">File</th>
            </tr>
        </thead>
        <tbody>
<?php if (empty($dokumen)): ?>
    <tr>
        <td colspan="5" class="p-4 text-center text-gray-500">
            Belum ada dokumen publik
        </td>
    </tr>
<?php else: ?>
    <?php foreach ($dokumen as $d): ?>
        <tr class="border-b">
            <td class="p-3"><?= esc($d['judul']) ?></td>
            <td class="p-3 text-center"><?= esc($d['nama_unit'] ?? '-') ?></td>
            <td class="p-3 text-center">
                <?= date('Y', strtotime($d['created_at'])) ?>
            </td>
            <td class="p-3 text-center">
                <?= $d['published_at']
                ? date('d/m/Y', strtotime($d['published_at']))
                : '-' ?>
            </td>
            <td class="p-3 text-center">
                <a href="<?= base_url('uploads/dokumen/' . $d['file_path']) ?>"
                   class="text-blue-600"
                   target="_blank">
                    Download
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
<?php endif; ?>
</tbody>

    </table>

</div>

<?= $this->endSection() ?>
