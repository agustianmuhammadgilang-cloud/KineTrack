<?= $this->extend('layout/staff_template') ?>
<?= $this->section('content') ?>

<div class="max-w-7xl mx-auto">

    <!-- HEADER -->
    <div class="mb-6">
        <h4 class="text-2xl font-semibold text-[var(--polban-blue)]">
            Dokumen Unit Kerja
        </h4>
        <p class="text-sm text-gray-600 mt-1">
            Daftar dokumen kinerja yang berlaku untuk unit kerja Anda
        </p>
    </div>

    <!-- INFO BOX -->
    <div class="bg-blue-50 border-l-4 border-[var(--polban-blue)] p-4 rounded mb-6">
        <p class="text-sm text-gray-700">
            Dokumen unit adalah dokumen yang dibuat untuk kepentingan bersama
            dalam satu unit kerja (Prodi/Jurusan) dan dapat dilihat oleh seluruh
            anggota unit.
        </p>
    </div>

    <!-- TABLE -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">
                        Judul Dokumen
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">
                        Kategori
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">
                        Pengirim
                    </th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase">
                        Status
                    </th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase">
                        Aksi
                    </th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">
                <?php if (empty($dokumen)): ?>
                    <tr>
                        <td colspan="5" class="px-6 py-6 text-center text-sm text-gray-500">
                            Belum ada dokumen unit
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($dokumen as $d): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm font-medium text-gray-800">
                                <?= esc($d['judul']) ?>
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-600">
                                <?= esc($d['nama_kategori'] ?? '-') ?>
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-600">
                                <?= esc($d['nama_pengirim'] ?? 'Staff') ?>
                            </td>

                            <!-- STATUS -->
                            <td class="px-6 py-4 text-center">
                                <?php
                                    $statusClass = match($d['status']) {
                                        'pending_kaprodi', 'pending_kajur' => 'bg-yellow-100 text-yellow-800',
                                        'rejected_kaprodi', 'rejected_kajur' => 'bg-red-100 text-red-700',
                                        'archived' => 'bg-green-100 text-green-700',
                                        default => 'bg-gray-100 text-gray-700'
                                    };

                                    $statusText = match($d['status']) {
                                        'pending_kaprodi', 'pending_kajur' => 'Pending',
                                        'rejected_kaprodi', 'rejected_kajur' => 'Ditolak',
                                        'archived' => 'Disetujui',
                                        default => ucfirst($d['status'])
                                    };
                                ?>
                                <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold <?= $statusClass ?>">
                                    <?= $statusText ?>
                                </span>
                            </td>

                            <!-- AKSI -->
                            <td class="px-6 py-4 text-center">
                                <a href="<?= base_url('uploads/dokumen/' . $d['file_path']) ?>"
                                   target="_blank"
                                   class="inline-flex items-center text-sm text-[var(--polban-orange)] hover:underline font-medium">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Lihat
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>

<?= $this->endSection() ?>
