<?= $this->extend('layout/staff_template') ?>
<?= $this->section('content') ?>

<div class="max-w-7xl mx-auto space-y-8">

    <!-- HEADER -->
    <div class="bg-white rounded-2xl border shadow-sm p-6">
        <h4 class="text-2xl font-semibold text-gray-800">
            Dokumen Unit Kerja
        </h4>
        <p class="text-sm text-gray-500 mt-1">
            Arsip dokumen bersama yang dapat diakses oleh seluruh anggota unit kerja
        </p>
    </div>

    <!-- EMPTY -->
    <?php if (empty($dokumen)): ?>
        <div class="bg-white border border-dashed rounded-2xl p-12 text-center">
            <p class="font-medium text-gray-700">
                Belum ada dokumen unit
            </p>
            <p class="text-sm text-gray-500 mt-1">
                Dokumen yang disetujui akan tampil di sini
            </p>
        </div>
    <?php else: ?>

    <!-- LIST -->
    <div class="space-y-4">
        <?php foreach ($dokumen as $d): ?>

        <?php
            $statusClass = match($d['status']) {
                'pending_kaprodi', 'pending_kajur' => 'bg-yellow-100 text-yellow-800',
                'rejected_kaprodi', 'rejected_kajur' => 'bg-red-100 text-red-700',
                'archived' => 'bg-green-100 text-green-700',
                default => 'bg-gray-100 text-gray-700'
            };

            $statusText = match($d['status']) {
                'pending_kaprodi', 'pending_kajur' => 'Dalam Proses',
                'rejected_kaprodi', 'rejected_kajur' => 'Ditolak',
                'archived' => 'Disetujui',
                default => ucfirst($d['status'])
            };
        ?>

        <!-- ITEM -->
        <div class="bg-white rounded-2xl border shadow-sm
                    hover:shadow-md transition p-6">

            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">

                <!-- LEFT -->
                <div class="space-y-2">
                    <h5 class="font-semibold text-gray-800 text-lg">
                        <?= esc($d['judul']) ?>
                    </h5>

                    <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500">

                        <!-- KATEGORI -->
                        <span>
                            <strong>Kategori:</strong>
                            <?= esc($d['nama_kategori'] ?? '-') ?>
                        </span>

                        <!-- PENGIRIM -->
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2"
                                 viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <strong>Pengirim:</strong>
                            <?= esc($d['nama_pengirim'] ?? 'Staff') ?>
                        </span>

                    </div>
                </div>

                <!-- RIGHT -->
                <div class="flex items-center gap-4">

                    <!-- STATUS -->
                    <span class="px-3 py-1 rounded-full text-xs font-medium <?= $statusClass ?>">
                        <?= $statusText ?>
                    </span>

                    <!-- VIEW -->
                    <a href="<?= base_url('uploads/dokumen/'.$d['file_path']) ?>"
                       target="_blank"
                       class="inline-flex items-center gap-2
                              bg-gray-100 hover:bg-gray-200
                              text-gray-700 px-4 py-2
                              rounded-xl text-sm transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Lihat Dokumen
                    </a>
                </div>

            </div>
        </div>

        <?php endforeach; ?>
    </div>

    <?php endif; ?>

</div>

<?= $this->endSection() ?>
