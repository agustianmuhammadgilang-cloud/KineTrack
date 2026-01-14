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

    /* Gaya khusus untuk input yang dikunci */
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
        padding: 0.75rem 2rem;
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
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
            </svg>
        </div>
        <div>
            <h3 class="text-2xl font-black text-slate-800 tracking-tight">Edit Indikator <span class="text-blue-900">Kinerja</span></h3>
            <p class="text-[11px] text-slate-400 font-bold uppercase tracking-widest mt-1">Perbarui Target & Parameter Strategis</p>
        </div>
    </div>

    <div class="form-container">
        <?php if (session()->getFlashdata('error')): ?>
            <div class="m-6 p-4 rounded-xl bg-red-50 border border-red-100 text-red-700 text-sm font-semibold flex items-center gap-3">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('admin/indikator/update/'.$indikator['id']) ?>" method="post" class="p-8 space-y-6">

            <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                <label class="label-custom opacity-60">Sasaran Strategis (Terkunci)</label>
                <div class="flex items-center gap-3">
                    <svg class="w-4 h-4 text-slate-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path></svg>
                    <span class="text-sm font-semibold text-slate-600">
                        <?php foreach($sasaran as $s): ?>
                            <?php if ($s['id'] == $indikator['sasaran_id']): ?>
                                <?= $s['kode_sasaran'] ?> — <?= $s['nama_sasaran'] ?> (<?= $s['tahun'] ?>)
                            <?php endif ?>
                        <?php endforeach ?>
                    </span>
                </div>
                <input type="hidden" name="sasaran_id" value="<?= $indikator['sasaran_id'] ?>">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="label-custom opacity-60">Kode Indikator</label>
                    <input type="text" value="<?= $indikator['kode_indikator'] ?>" disabled class="input-field input-locked">
                    <input type="hidden" name="kode_indikator" value="<?= $indikator['kode_indikator'] ?>">
                </div>

                <div class="md:col-span-1">
                    <label class="label-custom">Satuan</label>
                    <input type="text" name="satuan" value="<?= $indikator['satuan'] ?>" class="input-field" placeholder="Contoh: %, Unit, Dokumen">
                </div>

                <div>
                    <label class="label-custom">Target PK</label>
                    <input type="number" step="0.01" name="target_pk" value="<?= $indikator['target_pk'] ?>" class="input-field font-bold text-blue-900">
                </div>
            </div>

            <div>
                <label class="label-custom">Nama Indikator</label>
                <textarea name="nama_indikator" class="input-field h-28 resize-none" placeholder="Tuliskan deskripsi indikator..."><?= $indikator['nama_indikator'] ?></textarea>
            </div>

            <hr class="border-slate-100">

            <div>
                <label class="label-custom mb-4 text-center block">Target Capaian Per Triwulan</label>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <?php for ($i=1; $i<=4; $i++): ?>
                    <div class="bg-slate-50 p-3 rounded-2xl border border-slate-100">
                        <label class="block text-[10px] font-black text-slate-400 text-center uppercase mb-2">TW <?= $i ?></label>
                        <input type="number" step="0.01" name="target_tw<?= $i ?>" 
                               value="<?= $indikator['target_tw'.$i] ?>" 
                               class="w-full bg-white border border-slate-200 rounded-xl px-2 py-2 text-center font-bold text-slate-700 focus:ring-2 focus:ring-blue-100 outline-none">
                    </div>
                    <?php endfor ?>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-100">
                <a href="<?= base_url('admin/indikator') ?>" 
                   class="px-6 py-2.5 rounded-xl text-sm font-bold text-slate-500 hover:bg-slate-50 transition">
                    Batal
                </a>
                <button type="submit" class="btn-update shadow-lg shadow-blue-900/20">
                    Simpan Perubahan
                </button>
            </div>

        </form>
    </div>
</div>

<?= $this->endSection() ?>