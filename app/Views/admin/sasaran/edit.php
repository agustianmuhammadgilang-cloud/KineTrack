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

    /* Style khusus untuk data yang tidak boleh diubah saat edit */
    .input-locked {
        background-color: var(--slate-50);
        border-color: var(--slate-100);
        color: var(--slate-700);
        font-weight: 600;
        cursor: not-allowed;
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

    .btn-update {
        background-color: var(--polban-blue);
        color: white;
        padding: 0.75rem 2.5rem;
        border-radius: 12px;
        font-weight: 700;
        transition: var(--transition);
    }

    .btn-update:hover {
        background-color: var(--polban-blue-light);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 51, 102, 0.2);
    }
</style>

<div class="px-6 py-8 max-w-4xl mx-auto">
    <div class="flex items-center gap-4 mb-8">
        <div class="w-12 h-12 bg-amber-50 rounded-2xl flex items-center justify-center text-amber-600 shadow-sm border border-amber-100">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
        </div>
        <div>
            <h3 class="text-2xl font-black text-slate-800 tracking-tight">Edit Sasaran <span class="text-blue-900">Strategis</span></h3>
            <p class="text-[11px] text-slate-400 font-bold uppercase tracking-widest mt-1">Sesuaikan Parameter Tujuan Organisasi</p>
        </div>
    </div>

    <div class="form-container">
        <?php if (session()->getFlashdata('error')): ?>
            <div class="m-6 p-4 rounded-xl bg-red-50 border border-red-100 text-red-700 text-sm font-semibold flex items-center gap-3">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('admin/sasaran/update/'.$sasaran['id']) ?>" method="post" class="p-8 space-y-6">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-5 bg-slate-50 rounded-2xl border border-slate-100">
                <div>
                    <label class="label-custom opacity-60 flex items-center gap-2">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path></svg>
                        Tahun Anggaran
                    </label>
                    <select class="input-field input-locked" disabled>
                        <?php foreach ($tahun as $t): ?>
                        <option value="<?= $t['id'] ?>" <?= $sasaran['tahun_id'] == $t['id'] ? 'selected' : '' ?>>
                            <?= $t['tahun'] ?>
                        </option>
                        <?php endforeach ?>
                    </select>
                    <input type="hidden" name="tahun_id" value="<?= $sasaran['tahun_id'] ?>">
                </div>

                <div>
                    <label class="label-custom opacity-60 flex items-center gap-2">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path></svg>
                        Kode Sasaran
                    </label>
                    <input type="text" name="kode_sasaran" value="<?= $sasaran['kode_sasaran'] ?>" readonly class="input-field input-locked">
                </div>
            </div>

            <div>
                <label class="label-custom">Deskripsi Sasaran Strategis</label>
                <textarea name="nama_sasaran" required class="input-field h-32 resize-none focus:ring-4" 
                    placeholder="Masukkan uraian sasaran strategis..."><?= old('nama_sasaran', $sasaran['nama_sasaran']) ?></textarea>
            </div>

            <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-100">
                <a href="<?= base_url('admin/sasaran') ?>"
                    class="px-6 py-2.5 rounded-xl text-sm font-bold text-slate-500 hover:bg-slate-50 transition">
                    Batal
                </a>
                <button type="submit" class="btn-update shadow-lg shadow-blue-900/20">
                    Perbarui Data
                </button>
            </div>

        </form>
    </div>
</div>

<?= $this->endSection() ?>