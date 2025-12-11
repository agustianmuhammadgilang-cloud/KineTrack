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


<h3 class="text-2xl font-bold text-[var(--polban-blue)] mb-6">
    Edit Tahun Anggaran
</h3>

<div class="bg-white shadow border border-gray-200 rounded-xl p-6 max-w-xl">

    <form action="<?= base_url('admin/tahun/update/'.$tahun['id']) ?>" method="post">

        <!-- Tahun (readonly dan aman) -->
        <div class="mb-5">
            <label class="block font-semibold text-gray-700 mb-1">Tahun</label>

            <input 
                type="number" 
                value="<?= $tahun['tahun'] ?>"
                readonly
                class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100 text-gray-700">
            
            <!-- hidden supaya tetap terkirim ke controller -->
            <input type="hidden" name="tahun" value="<?= $tahun['tahun'] ?>">
        </div>

        <!-- STATUS: UI Toggle Modern -->
        <div class="mb-6">
            <label class="block font-semibold text-gray-700 mb-2">Status</label>

            <div class="flex items-center gap-4">
                <!-- Hidden input untuk mengontrol value -->
                <input type="hidden" id="status_value" name="status" value="<?= $tahun['status'] ?>">

                <!-- Toggle -->
                <div 
                    onclick="toggleStatus()"
                    id="status_toggle"
                    class="w-14 h-7 flex items-center rounded-full cursor-pointer transition
                        <?= $tahun['status'] == 'active' ? 'bg-green-500' : 'bg-gray-400' ?>">
                    
                    <div 
                        id="status_circle"
                        class="w-6 h-6 bg-white rounded-full shadow transform transition
                            <?= $tahun['status'] == 'active' ? 'translate-x-7' : 'translate-x-1' ?>">
                    </div>
                </div>

                <span id="status_label" class="font-medium 
                    <?= $tahun['status']=='active' ? 'text-green-600' : 'text-gray-600' ?>">
                    <?= $tahun['status']=='active' ? 'Aktif' : 'Tidak Aktif' ?>
                </span>
            </div>
        </div>

        <!-- Buttons -->
        <div class="flex gap-3">
            <button 
                class="bg-[var(--polban-blue)] text-white px-5 py-2 rounded-lg 
                       hover:bg-blue-900 transition shadow">
                Update
            </button>

            <a href="<?= base_url('admin/tahun') ?>"
               class="bg-gray-300 text-gray-800 px-5 py-2 rounded-lg
                      hover:bg-gray-400 transition shadow">
                Kembali
            </a>
        </div>

    </form>

</div>


<!-- Toggle Script -->
<script>
function toggleStatus() {
    const toggle = document.getElementById("status_toggle");
    const circle = document.getElementById("status_circle");
    const label = document.getElementById("status_label");
    const input = document.getElementById("status_value");

    const isActive = input.value === "active";

    if (isActive) {
        // ubah ke inactive
        input.value = "inactive";
        toggle.classList.remove("bg-green-500");
        toggle.classList.add("bg-gray-400");
        circle.classList.remove("translate-x-7");
        circle.classList.add("translate-x-1");
        label.innerText = "Tidak Aktif";
        label.className = "font-medium text-gray-600";
    } else {
        // ubah ke active
        input.value = "active";
        toggle.classList.remove("bg-gray-400");
        toggle.classList.add("bg-green-500");
        circle.classList.remove("translate-x-1");
        circle.classList.add("translate-x-7");
        label.innerText = "Aktif";
        label.className = "font-medium text-green-600";
    }
}
</script>



<!-- Toast Script (tidak saya ulang, tetap sama dari versi sebelumnya) -->
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

    setTimeout(() => {
        toast.classList.remove("opacity-0", "translate-x-10");
    }, 50);

    setTimeout(() => {
        toast.classList.add("opacity-0", "translate-x-10");
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}
</script>

<?= $this->endSection() ?>
