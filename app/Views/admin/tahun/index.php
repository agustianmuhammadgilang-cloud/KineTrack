<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<h3 class="text-2xl font-bold text-[var(--polban-blue)] mb-6">Tahun Anggaran</h3>

<!-- Tombol Navigasi -->
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4 gap-3">

    <!-- Kembali ke Pengukuran -->
    <a href="<?= base_url('admin/pengukuran') ?>"
       class="inline-block bg-gray-500 text-white px-4 py-2 rounded-lg shadow hover:bg-gray-600 transition">
        ← Kembali ke Input Pengukuran
    </a>

    <!-- Tambah Tahun -->
    <a href="<?= base_url('admin/tahun/create') ?>"
       class="inline-block bg-[var(--polban-blue)] text-white px-4 py-2 rounded-lg shadow hover:bg-blue-900 transition">
       + Tambah Tahun
    </a>
</div>

<!-- Card Wrapper -->
<div class="bg-white shadow border border-gray-200 rounded-xl overflow-hidden">

    <!-- Table Wrapper -->
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-[var(--polban-blue)] text-white">
                <tr>
                    <th class="px-4 py-3 text-left w-16">ID</th>
                    <th class="px-4 py-3 text-left">Tahun</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3 text-center w-40">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200">
                <?php foreach($tahun as $t): ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3"><?= $t['id'] ?></td>
                    <td class="px-4 py-3"><?= $t['tahun'] ?></td>

                    <td class="px-4 py-3">
                        <?php if($t['status'] == 'active'): ?>
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
                                Aktif
                            </span>
                        <?php else: ?>
                            <span class="bg-gray-200 text-gray-700 px-3 py-1 rounded-full text-xs font-semibold">
                                Tidak Aktif
                            </span>
                        <?php endif; ?>
                    </td>

                    <td class="px-4 py-3 text-center flex gap-2 justify-center">

                        <a href="<?= base_url('admin/tahun/edit/'.$t['id']) ?>"
                           class="px-3 py-1 bg-yellow-500 text-white rounded-lg text-xs hover:bg-yellow-600 transition">
                           Edit
                        </a>

                        <a href="<?= base_url('admin/tahun/delete/'.$t['id']) ?>"
                           onclick="return confirm('Hapus tahun?')"
                           class="px-3 py-1 bg-red-600 text-white rounded-lg text-xs hover:bg-red-700 transition">
                           Hapus
                        </a>

                    </td>
                </tr>
                <?php endforeach ?>
            </tbody>

        </table>
    </div>
</div>

<?= $this->endSection() ?>