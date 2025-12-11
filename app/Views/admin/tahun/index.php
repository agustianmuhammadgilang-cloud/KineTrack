<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>
<!-- Toast Container -->
<div id="toast-container" class="fixed top-5 right-5 z-50 space-y-3 w-80"></div>

<!-- Trigger flashdata error -->
<?php if(session()->getFlashdata('error')): ?>
<script>
document.addEventListener('DOMContentLoaded', () => {
    showToast("<?= session()->getFlashdata('error') ?>", "error");
});
</script>
<?php endif; ?>

<!-- Trigger flashdata success -->
<?php if(session()->getFlashdata('success')): ?>
<script>
document.addEventListener('DOMContentLoaded', () => {
    showToast("<?= session()->getFlashdata('success') ?>", "success");
});
</script>
<?php endif; ?>


<h3 class="text-2xl font-bold text-[var(--polban-blue)] mb-6">Tahun Anggaran</h3>

<!-- Tombol Navigasi -->
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4 gap-3">

    <a href="<?= base_url('admin/pengukuran') ?>"
       class="inline-block bg-gray-500 text-white px-4 py-2 rounded-lg shadow hover:bg-gray-600 transition">
        ← Kembali ke Input Pengukuran
    </a>

    <a href="<?= base_url('admin/tahun/create') ?>"
       class="inline-block bg-[var(--polban-blue)] text-white px-4 py-2 rounded-lg shadow hover:bg-blue-900 transition">
       + Tambah Tahun
    </a>
</div>


<div class="bg-white shadow border border-gray-200 rounded-xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-[var(--polban-blue)] text-white">
                <tr>
                    <th class="px-4 py-3 text-left">Tahun</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3 text-center w-40">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200">
                <?php foreach($tahun as $t): ?>
                <tr class="hover:bg-gray-50">
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


<!-- Toast Script -->
<script>
function showToast(message, type = "success") {
    const container = document.getElementById("toast-container");

    const styles = {
        success: "bg-green-600 border-green-700 text-white",
        error: "bg-red-600 border-red-700 text-white",
    };

    const icons = {
        success: `
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" 
                stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" 
                      d="M5 13l4 4L19 7"/>
            </svg>
        `,
        error: `
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" 
                stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" 
                      d="M6 18L18 6M6 6l12 12"/>
            </svg>
        `,
    };

    const titles = {
        success: "Berhasil",
        error: "Gagal",
    };

    const toast = document.createElement("div");
    toast.className = `
        flex items-start gap-3 p-4 rounded-xl shadow-lg border
        transform transition-all duration-300 opacity-0 translate-x-10
        ${styles[type]}
    `;

    toast.innerHTML = `
        <div class="mt-1">${icons[type]}</div>

        <div class="flex-1">
            <p class="font-semibold text-white">${titles[type]}</p>
            <p class="text-white/90 text-sm">${message}</p>
        </div>

        <button onclick="this.parentElement.remove()" 
            class="text-white hover:text-gray-200 font-bold ml-2">×</button>
    `;

    container.appendChild(toast);

    // masuk animasi
    setTimeout(() => {
        toast.classList.remove("opacity-0", "translate-x-10");
    }, 50);

    // auto hide setelah 3 detik
    setTimeout(() => {
        toast.classList.add("opacity-0", "translate-x-10");
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}
</script>

<?= $this->endSection() ?>
