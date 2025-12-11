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



<div class="max-w-3xl mx-auto bg-white p-8 rounded-xl shadow-md border border-gray-200">
    
    <h3 class="text-2xl font-bold text-[#1D2F83] mb-6">Tambah Tahun Anggaran</h3>

    <form action="<?= base_url('admin/tahun/store') ?>" method="post" class="space-y-6">
        <?= csrf_field() ?>

        <div>
            <label class="block font-semibold mb-1 text-gray-700">Tahun</label>
            <input 
                type="number" 
                name="tahun" 
                required
                value="<?= old('tahun') ?>"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg 
                       focus:ring-2 focus:ring-[#1D2F83] focus:border-[#1D2F83]"
            >
        </div>

        <div>
            <label class="block font-semibold mb-1 text-gray-700">Status</label>
            <select 
                name="status" 
                class="w-full px-4 py-2 border border-gray-300 rounded-lg 
                       focus:ring-2 focus:ring-[#1D2F83] focus:border-[#1D2F83]"
            >
                <option value="active" <?= old('status') == 'active' ? 'selected' : '' ?>>Aktif</option>
                <option value="inactive" <?= old('status') == 'inactive' ? 'selected' : '' ?>>Tidak Aktif</option>
            </select>
        </div>

        <div class="flex items-center gap-3 pt-4">
            <button class="bg-[#1D2F83] text-white px-6 py-2 rounded-lg hover:bg-[#16256A] transition">
                Simpan
            </button>

            <a href="<?= base_url('admin/tahun') ?>" 
               class="px-6 py-2 rounded-lg border border-gray-400 text-gray-700 hover:bg-gray-100 transition">
                Kembali
            </a>
        </div>

    </form>
</div>
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
