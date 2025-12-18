<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<h1 class="text-2xl font-bold text-[#1D2F83] mb-6">
    📥 Pengajuan Kategori Dokumen
</h1>

<div class="bg-white rounded-xl shadow overflow-hidden">
<table class="w-full text-sm">
<thead class="bg-gray-100">
<tr>
    <th class="p-4">No</th>
    <th class="p-4">Nama</th>
    <th class="p-4">Deskripsi</th>
    <th class="p-4 text-center">Status</th>
    <th class="p-4 text-center">Aksi</th>
</tr>
</thead>

<tbody class="divide-y">
<?php foreach ($pengajuan as $i => $p): ?>
<tr class="hover:bg-gray-50">
    <td class="p-4"><?= $i+1 ?></td>
    <td class="p-4 font-semibold"><?= esc($p['nama_kategori']) ?></td>
    <td class="p-4 text-gray-600"><?= esc($p['deskripsi']) ?></td>
    <td class="p-4 text-center">
        <span class="px-3 py-1 rounded-full text-xs
        <?= $p['status']=='pending'
            ? 'bg-yellow-100 text-yellow-700'
            : ($p['status']=='approved'
                ? 'bg-green-100 text-green-700'
                : 'bg-red-100 text-red-700') ?>">
            <?= ucfirst($p['status']) ?>
        </span>
    </td>
    <td class="p-4 text-center space-x-3">
    <?php if ($p['status']=='pending'): ?>
        <a href="<?= base_url('admin/pengajuan-kategori/approve/'.$p['id']) ?>"
           class="text-green-600 hover:underline">Approve</a>
        <a href="<?= base_url('admin/pengajuan-kategori/reject/'.$p['id']) ?>"
           class="text-red-600 hover:underline">Reject</a>
    <?php else: ?>
        <span class="text-gray-400 italic">Selesai</span>
    <?php endif ?>
    </td>
</tr>
<?php endforeach ?>
</tbody>
</table>
</div>

<?= $this->endSection() ?>
