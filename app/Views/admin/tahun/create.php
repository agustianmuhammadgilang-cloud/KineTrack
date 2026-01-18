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

    .input-field {
        transition: var(--transition-smooth);
        border: 1.5px solid #e2e8f0;
    }

    .input-field:focus {
        border-color: var(--polban-blue);
        box-shadow: 0 0 0 4px rgba(0, 51, 102, 0.05);
        outline: none;
    }

    .btn-polban {
        transition: var(--transition-smooth);
        background: var(--polban-blue);
    }

    .btn-polban:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px -5px rgba(0, 51, 102, 0.3);
        filter: brightness(1.1);
    }

    /* Custom Styling for Toast agar senada */
    .toast-premium {
        backdrop-filter: blur(8px);
        border-radius: 20px;
        box-shadow: 0 15px 30px -5px rgba(0,0,0,0.1);
    }
</style>

<div id="toast-container" class="fixed top-8 right-8 z-[100] space-y-4 w-80"></div>

<div class="px-4 py-8 max-w-2xl mx-auto">
    <div class="flex items-center gap-5 mb-10">
        <div class="w-14 h-14 bg-blue-50 border border-blue-100 rounded-2xl flex items-center justify-center shadow-sm text-blue-900">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
        </div>
        <div>
            <h4 class="text-2xl font-black text-blue-900 tracking-tight">
                Periode Baru <span class="text-slate-400 font-light">|</span> <span class="text-blue-600">Tahun Anggaran</span>
            </h4>
            <p class="text-[11px] text-slate-400 font-semibold uppercase tracking-[0.2em] mt-1">
                Manajemen kalender pelaporan institusi
            </p>
        </div>
    </div>

    <div class="form-card overflow-hidden">
        <div class="p-8 md:p-10">
            
            <form action="<?= base_url('admin/tahun/store') ?>" method="post" class="space-y-8">
                <?= csrf_field() ?>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Tahun Anggaran</label>
                        <input type="number" name="tahun" required value="<?= old('tahun') ?>"
                               placeholder="Contoh: 2025"
                               class="input-field w-full px-5 py-4 rounded-2xl text-blue-900 font-bold">
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Status Awal</label>
                        <select name="status" class="input-field w-full px-5 py-4 rounded-2xl text-blue-900 font-bold bg-slate-50/50">
                            <option value="active" <?= old('status') == 'active' ? 'selected' : '' ?>>Aktif</option>
                            <option value="inactive" <?= old('status') == 'inactive' ? 'selected' : '' ?>>Tidak Aktif</option>
                        </select>
                    </div>
                </div>

                <div class="bg-amber-50 border-l-4 border-amber-400 p-5 rounded-r-2xl">
                    <div class="flex gap-4">
                        <div class="shrink-0 text-amber-500">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <p class="text-[11px] text-amber-800 font-medium leading-relaxed">
                            Menetapkan status <span class="font-bold uppercase text-amber-900">Aktif</span> akan menjadikan tahun ini sebagai periode utama dalam pengisian indikator dan capaian kinerja.
                        </p>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-slate-50">
                    <button type="submit" class="btn-polban flex-[2] text-white font-black py-4 rounded-2xl uppercase tracking-widest text-xs">
                        Simpan Tahun Anggaran
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
// Logic Toast Anda yang sudah bagus, kita pertahankan dengan sedikit penyesuaian visual
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
        <div class="flex-1">
            <p class="text-[13px] font-bold tracking-tight">${message}</p>
        </div>
        <button onclick="this.parentElement.remove()" class="text-white/60 hover:text-white transition-colors uppercase text-[10px] font-black">Close</button>
    `;

    container.appendChild(toast);
    setTimeout(() => toast.classList.remove("opacity-0", "translate-x-full"), 100);
    setTimeout(() => {
        toast.classList.add("opacity-0", "translate-x-full");
        setTimeout(() => toast.remove(), 500);
    }, 4000);
}

// Trigger Flashdata
<?php if(session()->getFlashdata('error')): ?>
    document.addEventListener('DOMContentLoaded', () => showToast("<?= session()->getFlashdata('error') ?>", "error"));
<?php endif; ?>

<?php if(session()->getFlashdata('success')): ?>
    document.addEventListener('DOMContentLoaded', () => showToast("<?= session()->getFlashdata('success') ?>", "success"));
<?php endif; ?>
</script>

<?= $this->endSection() ?>