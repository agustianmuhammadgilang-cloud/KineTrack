<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<!-- Header -->
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-[#1D2F83] flex items-center gap-3">
            <!-- Heroicon Inbox -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#F58025]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M20 13V5a2 2 0 00-2-2H6a2 2 0 00-2 2v8m16 0l-2 5H6l-2-5m16 0H4"/>
            </svg>
            Pengajuan Kategori Dokumen
        </h1>
        <p class="text-sm text-gray-500">
            Daftar pengajuan kategori dari staff untuk ditinjau admin
        </p>
    </div>
</div>

<!-- Card Table -->
<div class="bg-white rounded-3xl shadow overflow-hidden">
<table class="w-full text-sm">
<thead class="bg-gray-100 text-gray-700 uppercase text-xs">
<tr>
    <th class="p-4 text-left w-12">No</th>
    <th class="p-4 text-left">Nama Kategori</th>
    <th class="p-4 text-left">Deskripsi</th>
    <th class="p-4 text-center w-32">Status</th>
    <th class="p-4 text-center w-48">Aksi</th>
</tr>
</thead>

<tbody class="divide-y divide-gray-100">
<?php if (empty($pengajuan)): ?>
<tr>
    <td colspan="5" class="p-10 text-center text-gray-400 italic">
        <!-- Heroicon Inbox -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mx-auto mb-2 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M20 13V5a2 2 0 00-2-2H6a2 2 0 00-2 2v8m16 0l-2 5H6l-2-5m16 0H4"/>
        </svg>
        Tidak ada pengajuan kategori
    </td>
</tr>
<?php endif ?>

<?php foreach ($pengajuan as $i => $p): ?>
<tr class="hover:bg-gray-50 transition">
    <td class="p-4"><?= $i + 1 ?></td>

    <td class="p-4 font-semibold text-gray-800"><?= esc($p['nama_kategori']) ?></td>

    <td class="p-4 text-gray-600">
        <?= esc($p['deskripsi']) ?: '<span class="italic text-gray-400">Tidak ada deskripsi</span>' ?>
    </td>

    <td class="p-4 text-center">
        <?php
            $statusClasses = [
                'pending' => 'bg-yellow-100 text-yellow-700',
                'approved' => 'bg-green-100 text-green-700',
                'rejected' => 'bg-red-100 text-red-700'
            ];
            $statusIcons = [
                'pending' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3"/></svg>',
                'approved' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>',
                'rejected' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>'
            ];
        ?>
        <span class="inline-flex items-center gap-1 px-3 py-1 text-xs rounded-full <?= $statusClasses[$p['status']] ?>">
            <?= $statusIcons[$p['status']] ?> <?= ucfirst($p['status']) ?>
        </span>
    </td>

    <td class="p-4 text-center space-x-4">
    <?php if ($p['status']=='pending'): ?>

        <!-- Approve -->
        <a href="<?= base_url('admin/pengajuan-kategori/approve/'.$p['id']) ?>"
           onclick="return confirm('Setujui pengajuan kategori ini?')"
           class="inline-flex items-center gap-1 text-green-600 hover:text-green-800 transition">
            <!-- Heroicon Check -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            Approve
        </a>

        <!-- Reject -->
        <a href="<?= base_url('admin/pengajuan-kategori/reject/'.$p['id']) ?>"
           onclick="return confirm('Tolak pengajuan kategori ini?')"
           class="inline-flex items-center gap-1 text-red-600 hover:text-red-800 transition">
            <!-- Heroicon X -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
            Reject
        </a>

    <?php else: ?>
        <span class="text-gray-400 italic flex items-center justify-center gap-1">
            <!-- Heroicon Folder Check -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            Selesai
        </span>
    <?php endif ?>
    </td>
</tr>
<?php endforeach ?>
</tbody>
</table>
</div>

<?= $this->endSection() ?>
