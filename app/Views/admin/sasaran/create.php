<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<style>
    :root {
        --polban-blue: #003366;
        --polban-blue-light: #004a94;
        --polban-gold: #D4AF37;
        --slate-50: #f8fafc;
        --slate-100: #f1f5f9;
        --slate-200: #e2e8f0;
        --slate-700: #334155;
        --transition: all 0.3s ease;
    }

    .form-container {
        background: white;
        border-radius: 20px;
        border: 1px solid var(--slate-200);
        box-shadow: 0 10px 25px -5px rgba(0, 51, 102, 0.04);
        overflow: hidden;
    }

    .input-field {
        width: 100%;
        padding: 0.625rem 1rem;
        border: 1.5px solid var(--slate-200);
        border-radius: 12px;
        font-size: 0.875rem;
        transition: var(--transition);
        background-color: white;
    }

    .input-field:focus {
        outline: none;
        border-color: var(--polban-blue);
        box-shadow: 0 0 0 4px rgba(0, 51, 102, 0.05);
    }

    .input-readonly {
        background-color: var(--slate-50);
        color: var(--slate-700);
        font-weight: 600;
        cursor: not-allowed;
        border-style: dashed;
    }

    .label-custom {
        display: block;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: var(--slate-700);
        margin-bottom: 0.5rem;
    }

    .btn-save {
        background-color: var(--polban-blue);
        color: white;
        padding: 0.75rem 2rem;
        border-radius: 12px;
        font-weight: 700;
        transition: var(--transition);
    }

    .btn-save:hover {
        background-color: var(--polban-blue-light);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 51, 102, 0.2);
    }
</style>

<div class="px-6 py-8 max-w-4xl mx-auto">
    <div class="flex items-center gap-4 mb-8">
        <div class="w-12 h-12 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-900 shadow-sm border border-indigo-100">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
            </svg>
        </div>
        <div>
            <h3 class="text-2xl font-black text-slate-800 tracking-tight">Tambah Sasaran <span class="text-blue-900">Strategis</span></h3>
            <p class="text-[11px] text-slate-400 font-bold uppercase tracking-widest mt-1">Definisikan Tujuan Utama Instansi</p>
        </div>
    </div>

    <div class="form-container">
        <?php if (session()->getFlashdata('error')): ?>
            <div class="m-6 p-4 rounded-xl bg-red-50 border border-red-100 text-red-700 text-sm font-semibold flex items-center gap-3">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('admin/sasaran/store') ?>" method="post" class="p-8 space-y-6">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="label-custom">Tahun Anggaran</label>
                    <select name="tahun_id" id="tahunSelect" class="input-field" required>
                        <option value="">-- Pilih Tahun --</option>
                        <?php foreach ($tahun as $t): ?>
                            <option value="<?= $t['id'] ?>">
                                <?= $t['tahun'] ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                </div>

                <div>
                    <label class="label-custom">Kode Sasaran (Otomatis)</label>
                    <input type="text" name="kode_sasaran" id="kode_sasaran" readonly
                        class="input-field input-readonly" placeholder="Pilih tahun dahulu...">
                </div>
            </div>

            <div>
                <label class="label-custom">Deskripsi Sasaran Strategis</label>
                <textarea name="nama_sasaran" required class="input-field h-32 resize-none" 
                    placeholder="Masukkan uraian sasaran strategis secara mendetail..."><?= old('nama_sasaran') ?></textarea>
                <p class="mt-2 text-[10px] text-slate-400 italic font-medium">* Pastikan nama sasaran sesuai dengan dokumen Renstra.</p>
            </div>

            <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-100">
                <a href="<?= base_url('admin/sasaran') ?>"
                    class="px-6 py-2.5 rounded-xl text-sm font-bold text-slate-500 hover:bg-slate-50 transition text-center">
                    Batal
                </a>
                <button type="submit" class="btn-save shadow-lg shadow-blue-900/20">
                    Simpan Sasaran
                </button>
            </div>

        </form>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const tahunSelect = document.getElementById("tahunSelect");
    const kodeInput   = document.getElementById("kode_sasaran");

    tahunSelect.addEventListener("change", function () {
        const tahun = tahunSelect.value;

        if (!tahun) {
            kodeInput.value = "";
            return;
        }

        fetch(`<?= base_url('admin/sasaran/getKode/') ?>${tahun}`)
            .then(res => res.json())
            .then(data => kodeInput.value = data.kode)
            .catch(() => kodeInput.value = "");
    });
});
</script>

<?= $this->endSection() ?>