<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<h3 class="text-2xl font-bold text-[var(--polban-blue)] mb-6">
    Indikator Kinerja
</h3>


<!-- BUTTON WRAPPER -->
<div class="flex flex-wrap gap-3 mb-4">

   <!-- Button Back to Input Pengukuran -->
<a href="<?= base_url('admin/pengukuran') ?>"
   class="inline-block mb-4 bg-gray-200 text-gray-700 px-4 py-2 rounded-lg shadow 
          hover:bg-gray-300 transition">
    ← Kembali ke Input Pengukuran
</a>

<!-- Button Tambah -->
<a href="<?= base_url('admin/indikator/create') ?>"
   class="inline-block mb-4 ml-2 bg-[var(--polban-orange)] text-white px-4 py-2 rounded-lg shadow hover:bg-orange-600 transition">
    + Tambah Indikator
</a>
</div>

<!-- TABLE WRAPPER -->
<div class="overflow-x-auto bg-white shadow-md rounded-xl border border-gray-200">
    <table class="min-w-full divide-y divide-gray-200 text-sm">
        <thead class="bg-[var(--polban-blue)] text-white">
            <tr>
                <th class="px-4 py-3 text-left font-semibold">Kode</th>
                <th class="px-4 py-3 text-left font-semibold">Indikator</th>
                <th class="px-4 py-3 text-left font-semibold">Satuan</th>
                <th class="px-4 py-3 text-left font-semibold">Sasaran</th>
                <th class="px-4 py-3 text-left font-semibold">Tahun</th>
                <th class="px-4 py-3 text-center font-semibold">Aksi</th>
            </tr>
        </thead>

        <tbody class="divide-y divide-gray-200">
            <?php foreach($indikator as $i): ?>
            <tr class="hover:bg-gray-50 transition">
                <td class="px-4 py-3 text-gray-700"><?= $i['kode_indikator'] ?></td>
                <td class="px-4 py-3 text-gray-700"><?= $i['nama_indikator'] ?></td>
                <td class="px-4 py-3 text-gray-700"><?= $i['satuan'] ?></td>
                <td class="px-4 py-3 text-gray-700"><?= $i['nama_sasaran'] ?></td>
                <td class="px-4 py-3 text-gray-700"><?= $i['tahun'] ?></td>

                <td class="px-4 py-3 text-center flex gap-2 justify-center">

                    <a href="<?= base_url('admin/indikator/edit/'.$i['id']) ?>"
                        class="px-3 py-1 bg-yellow-500 text-white rounded-lg text-xs font-medium shadow hover:bg-yellow-600 transition">
                        Edit
                    </a>

                    <a href="<?= base_url('admin/indikator/delete/'.$i['id']) ?>"
                        onclick="return confirm('Yakin hapus indikator?')"
                        class="px-3 py-1 bg-red-600 text-white rounded-lg text-xs font-medium shadow hover:bg-red-700 transition">
                        Hapus
                    </a>

                </td>
            </tr>
            <?php endforeach ?>
        </tbody>

    </table>
</div>

<?= $this->endSection() ?>