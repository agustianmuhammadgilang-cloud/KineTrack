<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<style>
    :root {
        --polban-blue: #003366;
        --polban-gold: #D4AF37;
        --transition-smooth: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .form-card {
        background: white;
        border-radius: 32px;
        border: 1px solid #eef2f6;
        box-shadow: 0 20px 50px -12px rgba(0, 51, 102, 0.08);
    }

    .input-readonly {
        background-color: #f8fafc;
        border: 1.5px dashed #e2e8f0;
        cursor: not-allowed;
    }

    .btn-update {
        transition: var(--transition-smooth);
        background: #f59e0b; /* Amber 500 */
    }

    .btn-update:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px -5px rgba(245, 158, 11, 0.3);
        filter: brightness(1.05);
    }

    /* Modern Toggle Premium Styling */
    .toggle-bg {
        transition: var(--transition-smooth);
        width: 3.5rem;
        height: 1.75rem;
    }
    
    .toggle-dot {
        transition: var(--transition-smooth);
        width: 1.25rem;
        height: 1.25rem;
    }

    .toast-premium {
        backdrop-filter: blur(8px);
        border-radius: 20px;
        box-shadow: 0 15px 30px -5px rgba(0,0,0,0.1);
    }
</style>

<div id="toast-container" class="fixed top-8 right-8 z-[100] space-y-4 w-80"></div>

<div class="px-4 py-8 max-w-2xl mx-auto">
    <div class="flex items-center gap-5 mb-10">
        <div class="w-14 h-14 bg-amber-50 border border-amber-100 rounded-2xl flex items-center justify-center shadow-sm text-amber-600">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
        </div>
        <div>
            <h4 class="text-2xl font-black text-blue-900 tracking-tight">
                Modifikasi <span class="text-slate-400 font-light">|</span> <span class="text-blue-600">Periode Anggaran</span>
            </h4>
            <p class="text-[11px] text-slate-400 font-semibold uppercase tracking-[0.2em] mt-1">
                Penyesuaian status aktifitas pelaporan
            </p>
        </div>
    </div>

    <div class="form-card overflow-hidden">
        <div class="p-8 md:p-10">
            
            <form action="<?= base_url('admin/tahun/update/'.$tahun['id']) ?>" method="post" class="space-y-8">
                <?= csrf_field() ?>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-end">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Tahun Terdaftar</label>
                        <input type="number" value="<?= $tahun['tahun'] ?>" readonly
                               class="input-readonly w-full px-5 py-4 rounded-2xl text-slate-500 font-black tracking-widest">
                        <input type="hidden" name="tahun" value="<?= $tahun['tahun'] ?>">
                    </div>

                    <div class="space-y-3 pb-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Status Operasional</label>
                        
                        <div class="flex items-center gap-4 bg-slate-50 p-3 rounded-2xl border border-slate-100 w-fit">
                            <input type="hidden" id="status_value" name="status" value="<?= $tahun['status'] ?>">

                            <div onclick="toggleStatus()" id="status_toggle"
                                 class="toggle-bg flex items-center rounded-full cursor-pointer px-1 
                                 <?= $tahun['status'] == 'active' ? 'bg-emerald-500' : 'bg-slate-300' ?>">
                                
                                <div id="status_circle"
                                     class="toggle-dot bg-white rounded-full shadow-sm transform 
                                     <?= $tahun['status'] == 'active' ? 'translate-x-7' : 'translate-x-0' ?>">
                                </div>
                            </div>

                            <span id="status_label" class="text-xs font-black uppercase tracking-wider 
                                  <?= $tahun['status']=='active' ? 'text-emerald-600' : 'text-slate-500' ?>">
                                <?= $tahun['status']=='active' ? 'Aktif' : 'Non-Aktif' ?>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="bg-blue-50 border-l-4 border-blue-400 p-5 rounded-r-2xl">
                    <div class="flex gap-4">
                        <div class="shrink-0 text-blue-500">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <p class="text-[11px] text-blue-800 font-medium leading-relaxed">
                            <span class="font-bold">Informasi:</span> Tahun yang sudah terdaftar tidak dapat diubah angkanya untuk menjaga integritas data riwayat. Anda hanya dapat mengubah status aktifitasnya.
                        </p>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-slate-50">
                    <button type="submit" class="btn-update flex-[2] text-white font-black py-4 rounded-2xl uppercase tracking-widest text-xs">
                        Simpan Perubahan
                    </button>
                    <a href="<?= base_url('admin/tahun') ?>" class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-500 font-black py-4 rounded-2xl uppercase tracking-widest text-xs text-center transition-colors">
                        Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Toggle Script with Smooth Transition
function toggleStatus() {
    const toggle = document.getElementById("status_toggle");
    const circle = document.getElementById("status_circle");
    const label = document.getElementById("status_label");
    const input = document.getElementById("status_value");

    if (input.value === "active") {
        input.value = "inactive";
        toggle.classList.replace("bg-emerald-500", "bg-slate-300");
        circle.classList.replace("translate-x-7", "translate-x-0");
        label.innerText = "Non-Aktif";
        label.classList.replace("text-emerald-600", "text-slate-500");
    } else {
        input.value = "active";
        toggle.classList.replace("bg-slate-300", "bg-emerald-500");
        circle.classList.replace("translate-x-0", "translate-x-7");
        label.innerText = "Aktif";
        label.classList.replace("text-slate-500", "text-emerald-600");
    }
}

// Toast Engine
function showToast(message, type = "success") {
    const container = document.getElementById("toast-container");
    const styles = {
        success: "bg-emerald-600/95 border-emerald-500 text-white toast-premium",
        error: "bg-rose-600/95 border-rose-500 text-white toast-premium",
    };
    const icons = {
        success: `<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>`,
        error: `<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>`,
    };

    const toast = document.createElement("div");
    toast.className = `flex items-center gap-4 p-5 border transform transition-all duration-500 opacity-0 translate-x-full ${styles[type]}`;
    toast.innerHTML = `
        <div class="flex-shrink-0 w-8 h-8 bg-white/20 rounded-full flex items-center justify-center">${icons[type]}</div>
        <div class="flex-1"><p class="text-[13px] font-bold tracking-tight">${message}</p></div>
        <button onclick="this.parentElement.remove()" class="text-white/60 hover:text-white transition-colors uppercase text-[10px] font-black">Close</button>
    `;

    container.appendChild(toast);
    setTimeout(() => toast.classList.remove("opacity-0", "translate-x-full"), 100);
    setTimeout(() => {
        toast.classList.add("opacity-0", "translate-x-full");
        setTimeout(() => toast.remove(), 500);
    }, 4000);
}

// Flashdata Trigger
<?php if(session()->getFlashdata('error')): ?>
    document.addEventListener('DOMContentLoaded', () => showToast("<?= session()->getFlashdata('error') ?>", "error"));
<?php endif; ?>
<?php if(session()->getFlashdata('success')): ?>
    document.addEventListener('DOMContentLoaded', () => showToast("<?= session()->getFlashdata('success') ?>", "success"));
<?php endif; ?>
</script>

<?= $this->endSection() ?>