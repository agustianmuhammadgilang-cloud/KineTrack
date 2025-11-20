<?= $this->extend('layout/atasan_template') ?>
<?= $this->section('content') ?>

<h3 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-100">
    Detail Laporan
</h3>

<div class="bg-white shadow rounded-lg p-6 space-y-4">

    <div class="space-y-2">
        <p><span class="font-medium">Nama Staff:</span> <?= esc($lap['nama']) ?></p>
        <p><span class="font-medium">Judul:</span> <?= esc($lap['judul']) ?></p>

        <p>
            <span class="font-medium">Deskripsi:</span><br>
            <span class="block mt-1"><?= nl2br(esc($lap['deskripsi'])) ?></span>
        </p>

        <p><span class="font-medium">Tanggal:</span> <?= esc($lap['tanggal']) ?></p>

        <p class="mt-2">
            <span class="font-medium">Bukti:</span><br>

            <?php if($lap['file_bukti']): ?>
                <a href="<?= base_url('uploads/bukti/'.$lap['file_bukti']) ?>" 
                   target="_blank"
                   class="inline-block mt-1 bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-lg shadow transition">
                    Lihat Bukti
                </a>
            <?php else: ?>
                <span class="italic text-gray-500">Tidak ada bukti.</span>
            <?php endif; ?>
        </p>
    </div>

    <hr class="border-gray-300">

    <?php if($lap['status']=='pending'): ?>

    <!-- ACTION BUTTONS -->
    <div class="flex flex-col sm:flex-row gap-3">
        <a href="<?= base_url('atasan/laporan/approve/'.$lap['id']) ?>" 
           class="flex-1 text-center bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-2 rounded-lg shadow transition">
           Setujui
        </a>

        <button type="button"
                onclick="document.getElementById('modalTolak').classList.remove('hidden')"
                class="flex-1 text-center bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-2 rounded-lg shadow transition">
            Tolak Laporan
        </button>
    </div>

    <?php else: ?>

    <div class="space-y-2">
        <p><span class="font-medium">Status:</span> <?= ucfirst($lap['status']) ?></p>
        <p><span class="font-medium">Catatan Atasan:</span><br>
            <span class="block mt-1"><?= esc($lap['catatan_atasan'] ?? '-') ?></span>
        </p>
    </div>

    <?php endif; ?>

</div>


<!-- MODAL TOLAK -->
<div id="modalTolak" 
     class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center p-4 hidden z-50">

    <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6 animate-fadeIn">

        <h5 class="text-xl font-semibold mb-4 text-gray-800">Alasan Penolakan</h5>

        <form action="<?= base_url('atasan/laporan/reject/'.$lap['id']) ?>" 
              method="POST" 
              class="space-y-4">

            <textarea name="catatan" 
                      class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-red-400"
                      rows="4" required></textarea>

            <div class="flex justify-end gap-3 pt-2">
                <button type="button"
                        onclick="document.getElementById('modalTolak').classList.add('hidden')"
                        class="px-4 py-2 rounded-lg bg-gray-300 hover:bg-gray-400">
                        Batal
                </button>

                <button type="submit"
                        class="px-4 py-2 rounded-lg bg-red-600 hover:bg-red-700 text-white font-semibold">
                        Kirim
                </button>
            </div>

        </form>

    </div>
</div>

<style>
@keyframes fadeIn {
    from { opacity: 0; transform: scale(0.95); }
    to { opacity: 1; transform: scale(1); }
}
.animate-fadeIn { animation: fadeIn 0.2s ease-out; }
</style>

<?= $this->endSection() ?>
