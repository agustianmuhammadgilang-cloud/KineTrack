<?= $this->extend('layout/atasan_template') ?>
<?= $this->section('content') ?>

<h3 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-100">Detail Laporan</h3>

<div class="bg-white shadow rounded-lg p-6 space-y-4">

    <p><span class="font-medium">Nama Staff:</span> <?= esc($lap['nama']) ?></p>
    <p><span class="font-medium">Judul:</span> <?= esc($lap['judul']) ?></p>
    <p><span class="font-medium">Deskripsi:</span><br><?= nl2br(esc($lap['deskripsi'])) ?></p>
    <p><span class="font-medium">Tanggal:</span> <?= esc($lap['tanggal']) ?></p>

    <p><span class="font-medium">Bukti:</span><br>
        <?php if($lap['file_bukti']): ?>
        <a href="<?= base_url('uploads/bukti/'.$lap['file_bukti']) ?>" target="_blank"
           class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-semibold px-4 py-2 rounded shadow transition-all">
           Lihat Bukti
        </a>
        <?php else: ?>
            <span class="italic text-gray-500">Tidak ada bukti.</span>
        <?php endif ?>
    </p>

    <hr class="border-gray-300">

    <?php if($lap['status']=='pending'): ?>
    <div class="flex gap-3">
        <a href="<?= base_url('atasan/laporan/approve/'.$lap['id']) ?>" 
           class="bg-green-500 hover:bg-green-600 text-white font-semibold px-4 py-2 rounded shadow transition-all">
           Setujui
        </a>

        <button type="button" 
                class="bg-red-500 hover:bg-red-600 text-white font-semibold px-4 py-2 rounded shadow transition-all"
                onclick="document.getElementById('modalTolak').classList.remove('hidden')">
            Tolak Laporan
        </button>
    </div>
    <?php else: ?>
    <p><span class="font-medium">Status:</span> <?= ucfirst($lap['status']) ?></p>
    <p><span class="font-medium">Catatan Atasan:</span><br><?= esc($lap['catatan_atasan'] ?? '-') ?></p>
    <?php endif; ?>

</div>

<!-- MODAL TOLAK -->
<div id="modalTolak" class="fixed inset-0 bg-black/50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-lg p-6 w-96">
        <h5 class="text-lg font-semibold mb-4">Alasan Penolakan</h5>
        <form action="<?= base_url('atasan/laporan/reject/'.$lap['id']) ?>" method="POST" class="space-y-3">
            <textarea name="catatan" class="w-full border rounded p-2" rows="4" required></textarea>
            <div class="flex justify-end gap-2">
                <button type="button" class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400"
                        onclick="document.getElementById('modalTolak').classList.add('hidden')">Batal</button>
                <button type="submit" class="px-4 py-2 rounded bg-red-500 hover:bg-red-600 text-white font-semibold">Kirim</button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
