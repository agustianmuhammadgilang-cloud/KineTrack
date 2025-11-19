<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<h3 class="text-2xl font-bold text-[var(--polban-blue)] mb-6">
    Sasaran Strategis
</h3>

<!-- Button Back to Input Pengukuran -->
<a href="<?= base_url('admin/pengukuran') ?>"
   class="inline-block mb-4 bg-gray-200 text-gray-700 px-4 py-2 rounded-lg shadow 
          hover:bg-gray-300 transition">
    ← Kembali ke Input Pengukuran
</a>

<!-- Button Tambah -->
<a href="<?= base_url('admin/sasaran/create') ?>"
   class="inline-block mb-4 ml-2 bg-[var(--polban-orange)] text-white px-4 py-2 rounded-lg shadow hover:bg-orange-600 transition">
    + Tambah Sasaran
</a>

<!-- Card Table -->
<div class="overflow-x-auto bg-white shadow-md rounded-xl border border-gray-200">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-[var(--polban-blue)] text-white">
            <tr>
                <th class="px-4 py-3 text-left text-sm font-semibold">Kode</th>
                <th class="px-4 py-3 text-left text-sm font-semibold">Nama Sasaran</th>
                <th class="px-4 py-3 text-left text-sm font-semibold">Tahun</th>
                <th class="px-4 py-3 text-center text-sm font-semibold w-40">Aksi</th>
            </tr>
        </thead>

        <tbody class="divide-y divide-gray-200">
            <?php foreach($sasaran as $s): ?>
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3 text-gray-700"><?= $s['kode_sasaran'] ?></td>
                <td class="px-4 py-3 text-gray-700"><?= $s['nama_sasaran'] ?></td>
                <td class="px-4 py-3 text-gray-700"><?= $s['tahun'] ?></td>

                <td class="px-4 py-3 flex justify-center gap-2">

                    <a href="<?= base_url('admin/sasaran/edit/'.$s['id']) ?>"
                       class="px-3 py-1 bg-yellow-500 text-white rounded-lg text-xs hover:bg-yellow-600 transition">
                        Edit
                    </a>

                    <a href="<?= base_url('admin/sasaran/delete/'.$s['id']) ?>"
                       onclick="return confirm('Hapus sasaran?')"
                       class="px-3 py-1 bg-red-600 text-white rounded-lg text-xs hover:bg-red-700 transition">
                        Hapus
                    </a>

                </td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>