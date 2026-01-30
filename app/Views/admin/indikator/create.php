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

    .form-header {
        background-color: var(--polban-blue);
        padding: 1.5rem 2rem;
        border-bottom: 4px solid var(--polban-gold);
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

    /* Akumulatif Toggle Style */
    .mode-button {
        padding: 0.5rem 1.25rem;
        border-radius: 10px;
        font-size: 0.75rem;
        font-weight: 700;
        transition: var(--transition);
        text-transform: uppercase;
    }
</style>

<div class="px-6 py-8 max-w-4xl mx-auto">
    <div class="flex items-center gap-4 mb-8">
        <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-900 shadow-sm border border-blue-100">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
        </div>
        <div>
            <h3 class="text-2xl font-black text-slate-800 tracking-tight">Tambah Indikator <span class="text-blue-900">Kinerja</span></h3>
            <p class="text-[11px] text-slate-400 font-bold uppercase tracking-widest mt-1">Manajemen Target Strategis Polban</p>
        </div>
    </div>

    <div class="form-container">
        <?php if (session()->getFlashdata('error')): ?>
            <div class="m-6 p-4 rounded-xl bg-red-50 border border-red-100 text-red-700 text-sm font-semibold flex items-center gap-3">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <form id="indikatorForm" action="<?= base_url('admin/indikator/store') ?>" method="post" class="p-8 space-y-6">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="label-custom">Tahun Anggaran</label>
                    <select id="tahunSelect" required class="input-field">
                        <option value="">-- Pilih Tahun --</option>
                        <?php 
                        $listTahun = array_unique(array_column($sasaran, 'tahun')); 
                        sort($listTahun);
                        foreach ($listTahun as $t): ?>
                            <option value="<?= $t ?>"><?= $t ?></option>
                        <?php endforeach ?>
                    </select>
                </div>

                <div>
                    <label class="label-custom">Kode Indikator (Auto)</label>
                    <input type="text" id="kode_indikator" name="kode_indikator" readonly class="input-field input-readonly" placeholder="Pilih sasaran dulu...">
                </div>
            </div>

            <div>
                <label class="label-custom">Sasaran Strategis</label>
                <select id="sasaranSelect" name="sasaran_id" required class="input-field">
                    <option value="">-- Pilih Tahun Terlebih Dahulu --</option>
                </select>
            </div>

            <div>
                <label class="label-custom">Nama Indikator Kinerja</label>
                <textarea name="nama_indikator" required class="input-field h-24 resize-none" placeholder="Masukkan detail indikator..."></textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="label-custom">Satuan Pengukuran</label>
                    <select id="satuanSelect" name="satuan" required class="input-field">
                        <option value="">-- Pilih Satuan --</option>
                        <option value="%">% (Persentase)</option>
                        <option value="unit">Unit</option>
                        <option value="dokumentasi">Dokumen</option>
                    </select>
                </div>

                <div>
                    <label class="label-custom">Target Perjanjian Kinerja (PK)</label>
                    <input type="number" id="target_pk" name="target_pk" min="0" step="0.01" class="input-field font-bold text-blue-900" placeholder="0.00">
                    <div id="hintPK" class="text-[10px] text-slate-400 font-medium mt-1 italic"></div>
                </div>
            </div>

            <div class="bg-slate-50 rounded-2xl p-5 border border-slate-100">
                <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                    <div class="flex items-center gap-2">
                        <input type="hidden" name="mode" id="modeInput" value="non">
                        <button type="button" id="btnNonAkm" class="mode-button">Non-Akumulatif</button>
                        <button type="button" id="btnAkm" class="mode-button">Akumulatif</button>
                        
                        <div id="iconErrorWrap" class="relative inline-block">
                            <button id="iconError" type="button" class="hidden ml-2 p-1.5 rounded-full bg-red-100 text-red-600 hover:bg-red-200 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M12 5a7 7 0 100 14 7 7 0 000-14z" />
                                </svg>
                            </button>
                            <div id="errorDropdown" class="hidden absolute left-0 bottom-full mb-3 z-50 w-72 bg-white border border-slate-200 rounded-xl shadow-xl overflow-hidden">
                                <div class="px-4 py-2 bg-red-50 text-[10px] font-bold text-red-800 border-b border-red-100 uppercase tracking-widest">Detail Validasi</div>
                                <div id="errorCategories" class="divide-y divide-slate-50"></div>
                            </div>
                        </div>
                    </div>
                    <div id="notifMode" class="text-[10px] font-black uppercase tracking-widest text-blue-900"></div>
                </div>
                <div id="errorDetailPanel" class="mt-4 hidden bg-white border border-red-200 text-red-700 p-4 rounded-xl text-xs leading-relaxed shadow-inner"></div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <?php for ($i=1; $i<=4; $i++): ?>
                <div>
                    <label class="label-custom text-center mb-2">TW <?= $i ?></label>
                    <input type="number" name="target_tw<?= $i ?>" class="twInput input-field text-center font-semibold" placeholder="0" min="0" step="0.01">
                </div>
                <?php endfor ?>
            </div>

            <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-100">
                <a href="<?= base_url('admin/indikator') ?>" class="px-6 py-2.5 rounded-xl text-sm font-bold text-slate-500 hover:bg-slate-50 transition">Batal</a>
                <button id="btnSubmit" class="btn-save">Simpan Indikator</button>
            </div>

        </form>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const btnNon = document.getElementById("btnNonAkm");
    const btnAkm = document.getElementById("btnAkm");
    const notifMode = document.getElementById("notifMode");
    const twInputs = Array.from(document.querySelectorAll(".twInput"));
    const iconError = document.getElementById("iconError");
    const iconErrorWrap = document.getElementById("iconErrorWrap");
    const errorDropdown = document.getElementById("errorDropdown");
    const errorCategories = document.getElementById("errorCategories");
    const errorDetailPanel = document.getElementById("errorDetailPanel");
    const form = document.getElementById("indikatorForm");
    const satuanSelect = document.getElementById("satuanSelect");
    const targetPkInput = document.getElementById("target_pk");
    const hintPK = document.getElementById("hintPK");
    let mode = "non";

    function setMode(m) {
        mode = m;
        document.getElementById("modeInput").value = mode;
        if (mode === "non") {
            btnNon.className = "mode-button bg-blue-900 text-white shadow-md shadow-blue-900/20";
            btnAkm.className = "mode-button bg-slate-200 text-slate-500 hover:bg-slate-300";
            notifMode.innerText = "MODE: NON-AKUMULATIF";
        } else {
            btnAkm.className = "mode-button bg-blue-900 text-white shadow-md shadow-blue-900/20";
            btnNon.className = "mode-button bg-slate-200 text-slate-500 hover:bg-slate-300";
            notifMode.innerText = "MODE: AKUMULATIF";
        }
        revalidateAndRender();
    }

    btnAkm.addEventListener("click", () => setMode("akumulatif"));
    btnNon.addEventListener("click", () => setMode("non"));
    setMode("non");

    function applySatuanBehavior() {
        const s = satuanSelect.value;
        if (s === "%" || s === "unit" || s === "dokumentasi") {
            targetPkInput.readOnly = false;
            targetPkInput.classList.remove("input-readonly");
            hintPK.innerText = "Info: Total TW harus sinkron dengan PK.";
            twInputs.forEach(i => { i.removeAttribute("max"); i.step = "0.01"; });
        } else {
            targetPkInput.readOnly = false;
            hintPK.innerText = "";
        }
        revalidateAndRender();
    }
    satuanSelect.addEventListener("change", applySatuanBehavior);

    // --- REVALIDATION & RENDER LOGIC (Fungsi internal Anda dipertahankan) ---
    function gatherValidation() {
        const vals = twInputs.map(i => {
            const raw = i.value;
            if (raw === "" || raw === null) return null;
            const n = Number(raw);
            return isFinite(n) ? n : null;
        });
        const pkRaw = targetPkInput.value;
        const pk = (pkRaw === "" || pkRaw === null) ? null : Number(pkRaw);
        const result = { overLimit: [], decreasing: [], sumMismatch: null, finalMismatch: null };

        if (mode === "non") {
            if (pk !== null && !isNaN(pk)) {
                const sum = vals.reduce((acc, v) => acc + (v ?? 0), 0);
                if (Math.abs(sum - pk) > 1e-9) {
                    const indices = vals.map((v, idx) => v !== null ? idx : -1).filter(i => i >= 0);
                    result.sumMismatch = { sum, pk, indices };
                }
            }
        } else {
            for (let i = 1; i < vals.length; i++) {
                const prev = vals[i-1], cur = vals[i];
                if (prev !== null && cur !== null && cur < prev) result.decreasing.push({from: i-1, to: i});
            }
            const tw4 = vals[3];
            if (pk !== null && !isNaN(pk)) {
                if (tw4 === null || Math.abs(tw4 - pk) > 1e-9) result.finalMismatch = { tw4: tw4 === null ? null : tw4, pk };
            }
        }
        return { vals, result, pk };
    }

    function revalidateAndRender() {
        const { vals, result, pk } = gatherValidation();
        twInputs.forEach(i => i.classList.remove("border-red-500", "ring-red-100", "ring-4"));

        if (!result.sumMismatch && !result.finalMismatch && result.decreasing.length === 0) {
            iconError.classList.add("hidden");
            errorDropdown.classList.add("hidden");
            errorDetailPanel.classList.add("hidden");
            return;
        }

        iconError.classList.remove("hidden");
        const categories = [];
        if (result.sumMismatch) categories.push({ id: 'cat-total', title: 'Jumlah Total Tidak Sesuai', summary: `Total: ${result.sumMismatch.sum} (Harus ${result.sumMismatch.pk})`, payload: result.sumMismatch });
        if (result.finalMismatch) categories.push({ id: 'cat-final', title: 'Target TW4 ≠ PK', summary: `TW4: ${result.finalMismatch.tw4 ?? '-'} (Harus ${result.finalMismatch.pk})`, payload: result.finalMismatch });
        if (result.decreasing.length > 0) categories.push({ id: 'cat-decrease', title: 'Nilai Menurun', summary: `${result.decreasing.length} TW lebih rendah dari sebelumnya`, payload: result.decreasing });

        errorCategories.innerHTML = categories.map(cat => `
            <button type="button" data-cat="${cat.id}" class="w-full text-left px-4 py-3 hover:bg-slate-50 transition flex justify-between items-center group">
                <div>
                    <div class="text-[11px] font-bold text-slate-800">${cat.title}</div>
                    <div class="text-[10px] text-red-500 font-medium">${cat.summary}</div>
                </div>
                <span class="text-slate-300 group-hover:text-blue-900">›</span>
            </button>
        `).join("");

        // Attach details click
        errorCategories.querySelectorAll("button").forEach(btn => {
            btn.onclick = () => {
                const cat = categories.find(c => c.id === btn.dataset.cat);
                errorDetailPanel.classList.remove("hidden");
                errorDetailPanel.innerHTML = `<strong>${cat.title}:</strong> ${cat.summary}`;
                errorDropdown.classList.add("hidden");
                // Highlight inputs
                if (cat.id === 'cat-total') cat.payload.indices.forEach(idx => twInputs[idx].classList.add("border-red-500", "ring-red-100", "ring-4"));
                if (cat.id === 'cat-final') twInputs[3].classList.add("border-red-500", "ring-red-100", "ring-4");
                if (cat.id === 'cat-decrease') cat.payload.forEach(p => { twInputs[p.from].classList.add("border-red-500"); twInputs[p.to].classList.add("border-red-500"); });
            }
        });
    }

    twInputs.forEach(i => i.addEventListener("input", revalidateAndRender));
    targetPkInput.addEventListener("input", revalidateAndRender);
    iconErrorWrap.onclick = (e) => { e.stopPropagation(); errorDropdown.classList.toggle("hidden"); };
    document.onclick = () => errorDropdown.classList.add("hidden");

    // Form logic original (Sasaran & Kode)
    const tahunSelect = document.getElementById("tahunSelect");
    const sasaranSelect = document.getElementById("sasaranSelect");
    const kodeInput = document.getElementById("kode_indikator");
    const sasaranData = <?= json_encode($sasaran) ?>;

    tahunSelect.addEventListener("change", function () {
        const selectedYear = this.value;
        sasaranSelect.innerHTML = '<option value="">-- Pilih Sasaran --</option>';
        if (!selectedYear) return;
        sasaranData.forEach(s => {
            if (s.tahun == selectedYear) sasaranSelect.append(new Option(`${s.kode_sasaran} - ${s.nama_sasaran}`, s.id));
        });
    });

    sasaranSelect.addEventListener("change", function () {
        const id = this.value;
        if (!id) { kodeInput.value = ""; return; }
        fetch("<?= base_url('admin/indikator/getKode/') ?>" + id)
            .then(res => res.json())
            .then(data => kodeInput.value = data.kode)
            .catch(() => kodeInput.value = "");
    });

    form.onsubmit = (e) => {
        const { result } = gatherValidation();
        if (result.sumMismatch || result.finalMismatch || result.decreasing.length > 0) {
            e.preventDefault();
            alert("Harap perbaiki data target TW agar sesuai dengan mode dan PK.");
        }
    };
});
</script>

<?= $this->endSection() ?>