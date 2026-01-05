<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<h3 class="text-2xl font-bold text-[var(--polban-blue)] mb-6">
    Tambah Indikator Kinerja
</h3>

<div class="bg-white p-6 rounded-xl shadow-md border border-gray-200 max-w-3xl">

<!-- NOTIFIKASI (TAMBAHAN, TANPA UBAH LOGIKA FORM) -->
<?php if (session()->getFlashdata('error')): ?>
    <div class="mb-4 p-3 rounded-lg bg-red-100 text-red-700 font-semibold">
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

    <form id="indikatorForm" action="<?= base_url('admin/indikator/store') ?>" method="post" class="space-y-5">

        <!-- ===================== TAHUN ===================== -->
        <div>
            <label class="block font-semibold text-gray-700 mb-1">Tahun</label>
            <select id="tahunSelect" required
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[var(--polban-blue)]">
                <option value="">-- Pilih Tahun --</option>

                <?php 
                $listTahun = array_unique(array_column($sasaran, 'tahun')); 
                sort($listTahun);
                foreach ($listTahun as $t): ?>
                    <option value="<?= $t ?>"><?= $t ?></option>
                <?php endforeach ?>
            </select>
        </div>

        <!-- ===================== SASARAN ===================== -->
        <div>
            <label class="block font-semibold text-gray-700 mb-1">Sasaran</label>
            <select id="sasaranSelect" name="sasaran_id" required
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[var(--polban-blue)]">
                <option value="">-- Pilih Tahun Terlebih Dahulu --</option>
            </select>
        </div>

        <!-- ===================== KODE INDIKATOR ===================== -->
        <div>
            <label class="block font-semibold text-gray-700 mb-1">Kode Indikator</label>
            <input type="text" id="kode_indikator" name="kode_indikator" 
                readonly class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-lg">
        </div>

        <!-- ===================== NAMA INDIKATOR ===================== -->
        <div>
            <label class="block font-semibold text-gray-700 mb-1">Nama Indikator</label>
            <textarea name="nama_indikator" required
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[var(--polban-blue)] h-28"></textarea>
        </div>

        <!-- ===================== SATUAN (SELECT DROPDOWN) ===================== -->
        <div>
            <label class="block font-semibold text-gray-700 mb-1">Satuan</label>
            <select id="satuanSelect" name="satuan" required
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[var(--polban-blue)]">
                <option value="">-- Pilih Satuan --</option>
                <option value="%">%</option>
                <option value="unit">Unit</option>
                <option value="dokumentasi">Dokumen</option>
            </select>
        </div>

        <!-- ===================== TARGET PK ===================== -->
        <div>
            <label class="block font-semibold text-gray-700 mb-1">Target PK</label>
            <input type="number" id="target_pk" name="target_pk" min="0" step="0.01"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[var(--polban-blue)]">
            <div id="hintPK" class="text-xs text-gray-500 mt-1"></div>
        </div>

        <input type="hidden" name="mode" id="modeInput" value="non">

        <hr class="my-4">

        <!-- ===================== MODE INPUT (di bawah Target PK) ===================== -->
        <div class="mt-2">
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border">
                <div class="flex items-center gap-3">
                    <button type="button" id="btnNonAkm"
                        class="px-4 py-2 rounded-lg font-semibold transition bg-green-600 text-white shadow-sm hover:scale-105">
                        Non-Akumulatif
                    </button>

                    <button type="button" id="btnAkm"
                        class="px-4 py-2 rounded-lg font-semibold transition bg-gray-300 text-gray-700 hover:scale-105">
                        Akumulatif
                    </button>

                    <!-- ICON VALIDASI GAGAL (clickable -> show dropdown) -->
                    <div id="iconErrorWrap" class="relative">
                        <button id="iconError" class="ml-2 inline-flex items-center px-2 py-1 rounded-lg text-red-600 bg-red-50 border border-red-100 hidden hover:bg-red-100 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M12 5a7 7 0 100 14 7 7 0 000-14z" />
                            </svg>
                        </button>

                        <!-- DROPDOWN: item kategori (muncul saat icon diklik) -->
                        <div id="errorDropdown" class="hidden absolute z-50 mt-2 w-80 right-0 bg-white border border-gray-200 rounded-lg shadow-lg">
                            <div class="px-3 py-2 text-sm font-medium text-gray-700 border-b">Detail Validasi</div>
                            <div id="errorCategories" class="divide-y divide-gray-100"></div>
                        </div>
                    </div>
                </div>

                <div id="notifMode" class="text-sm font-semibold text-[var(--polban-blue)]"></div>
            </div>

            <!-- PANEL DETAIL PESAN ketika user klik kategori -->
            <div id="errorDetailPanel" class="mt-2 hidden bg-red-50 border border-red-200 text-red-800 p-3 rounded-lg text-sm"></div>
        </div>

        <hr class="my-4">

        <!-- ===================== TARGET TW ===================== -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <?php for ($i=1; $i<=4; $i++): ?>
            <div>
                <label class="block font-semibold text-gray-700 mb-1">TW<?= $i ?></label>
                <input type="number" name="target_tw<?= $i ?>" class="twInput w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[var(--polban-blue)]" min="0" step="0.01">
            </div>
            <?php endfor ?>
        </div>

        <!-- ===================== BUTTON ===================== -->
        <div class="flex gap-3 pt-3">
            <button id="btnSubmit"
                class="bg-[var(--polban-blue)] text-white px-6 py-2 rounded-lg font-semibold hover:bg-blue-900 shadow">
                Simpan
            </button>

            <a href="<?= base_url('admin/indikator') ?>"
                class="px-6 py-2 rounded-lg font-semibold border border-gray-400 text-gray-700 hover:bg-gray-100">
                Kembali
            </a>
        </div>

    </form>
</div>

<!-- ===================== JS ===================== -->
<script>
document.addEventListener("DOMContentLoaded", function() {

    /* ---------- ELEMENTS ---------- */
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

    /* ---------- MODE ---------- */
    let mode = "non"; // default

    function setMode(m) {
        mode = m;
        document.getElementById("modeInput").value = mode;

        if (mode === "non") {
        btnNon.classList.remove("bg-gray-300","text-gray-700");
        btnNon.classList.add("bg-green-600","text-white");

        btnAkm.classList.remove("bg-green-600","text-white");
        btnAkm.classList.add("bg-gray-300","text-gray-700");

        notifMode.innerText = "Mode: NON-AKUMULATIF";
    } else {
        btnAkm.classList.remove("bg-gray-300","text-gray-700");
        btnAkm.classList.add("bg-green-600","text-white");

        btnNon.classList.remove("bg-green-600","text-white");
        btnNon.classList.add("bg-gray-300","text-gray-700");

        notifMode.innerText = "Mode: AKUMULATIF";
    }

    revalidateAndRender();
    }

    btnAkm.addEventListener("click", () => setMode("akumulatif"));
    btnNon.addEventListener("click", () => setMode("non"));
    setMode("non");

    /* ---------- SATUAN & PK BEHAVIOR ---------- */
    function applySatuanBehavior() {
    const s = satuanSelect.value;

    if (s === "%" || s === "unit" || s === "dokumentasi") {
        // SEMUA SATUAN DIPERLAKUKAN SAMA
        targetPkInput.readOnly = false;
        targetPkInput.classList.remove("bg-gray-100");
        hintPK.innerText = "Isi Target PK sesuai kebutuhan. Total TW harus sama dengan PK.";

        twInputs.forEach(i => {
            i.removeAttribute("max");
            i.setAttribute("min", "0");
            i.step = "0.01";
        });
    } else {
        targetPkInput.readOnly = false;
        hintPK.innerText = "";
    }

    revalidateAndRender();
}


    satuanSelect.addEventListener("change", applySatuanBehavior);

    /* ---------- VALIDATION LOGIC (NEW: sesuai permintaan) ---------- */

    function gatherValidation() {
    const vals = twInputs.map(i => {
        const raw = i.value;
        if (raw === "" || raw === null) return null;
        const n = Number(raw);
        return isFinite(n) ? n : null;
    });

    const satuan = satuanSelect.value;
    const pkRaw = targetPkInput.value;
    const pk = (pkRaw === "" || pkRaw === null) ? null : Number(pkRaw);

    const result = {
        overLimit: [],      // optional: per-TW max limit if needed
        decreasing: [],     // pairs for akumulatif where cur < prev
        sumMismatch: null,  // for NON mode: { sum, pk, indices }
        finalMismatch: null // for AKM mode: { tw4, pk }
    };

    // Validate each TW input
    if (mode === "non") {
        if (pk !== null && !isNaN(pk)) {
            const sum = vals.reduce((acc, v) => acc + (v ?? 0), 0);
            if (Math.abs(sum - pk) > 1e-9) {
                const indices = vals.map((v, idx) => v !== null ? idx : -1).filter(i => i >= 0);
                result.sumMismatch = { sum, pk, indices };
            }
        }
    } else { // mode === "akm"
        // check non-decreasing
        for (let i = 1; i < vals.length; i++) {
            const prev = vals[i-1], cur = vals[i];
            if (prev !== null && cur !== null && cur < prev) {
                result.decreasing.push({from: i-1, to: i});
            }
        }
        // check TW4 = PK if PK provided
        const tw4 = vals[3];
        if (pk !== null && !isNaN(pk)) {
            if (tw4 === null || Math.abs(tw4 - pk) > 1e-9) {
                result.finalMismatch = { tw4: tw4 === null ? null : tw4, pk };
            }
        }
    }

    return { vals, result, satuan, pk };
}

function validateTW() {
    const { vals, result, satuan, pk } = gatherValidation();
    const messages = [];

    if (result.sumMismatch) {
        messages.push({
            type: 'sumMismatch',
            text: `Total TW (TW1+TW2+TW3+TW4) = ${result.sumMismatch.sum} harus sama dengan ${result.sumMismatch.pk}`,
            payload: result.sumMismatch
        });
    }

    if (result.finalMismatch) {
        const t4 = result.finalMismatch.tw4 === null ? '—' : result.finalMismatch.tw4;
        messages.push({
            type: 'finalMismatch',
            text: `Mode AKUMULATIF: TW4 = ${t4} harus sama dengan PK (${result.finalMismatch.pk})`,
            payload: result.finalMismatch
        });
    }

    result.decreasing.forEach(obj => {
        messages.push({
            type: 'decreasing',
            text: `TW${obj.to+1} tidak boleh turun dari TW${obj.from+1}`,
            from: obj.from,
            to: obj.to
        });
    });

    return { raw: result, messages, vals, satuan, pk };
}


    /* ---------- ERROR UI RENDER (includes sum/detail) ---------- */
    function renderErrorState(validation) {
        const { raw, messages, vals } = validation;

        // clear input highlights first
        twInputs.forEach(i => {
            i.classList.remove("border-red-500", "ring-2", "ring-red-200");
        });

        if (messages.length === 0) {
            iconError.classList.add("hidden");
            errorDropdown.classList.add("hidden");
            errorCategories.innerHTML = "";
            errorDetailPanel.classList.add("hidden");
            errorDetailPanel.innerHTML = "";
            return;
        }

        iconError.classList.remove("hidden");

        const categories = [];

        // sumMismatch (non)
        if (raw.sumMismatch) {
            categories.push({
                id: 'cat-total',
                title: 'Jumlah Total Tidak Sesuai PK',
                summary: `Total = ${raw.sumMismatch.sum} (harus ${raw.sumMismatch.pk})`,
                payload: raw.sumMismatch
            });
        }

        // finalMismatch (akm)
        if (raw.finalMismatch) {
            categories.push({
                id: 'cat-final',
                title: 'Nilai Akumulatif Akhir Tidak Sama dengan PK',
                summary: `TW4 = ${raw.finalMismatch.tw4 === null ? '—' : raw.finalMismatch.tw4} (harus ${raw.finalMismatch.pk})`,
                payload: raw.finalMismatch
            });
        }

        if (raw.overLimit && raw.overLimit.length > 0) {
            categories.push({
                id: 'cat-over100',
                title: 'Melebihi Batas 100 (per TW)',
                summary: `${raw.overLimit.length} TW melebihi 100`,
                payload: raw.overLimit.slice()
            });
        }

        if (raw.decreasing && raw.decreasing.length > 0) {
            categories.push({
                id: 'cat-decrease',
                title: 'Penurunan Nilai (TW turun)',
                summary: `${raw.decreasing.length} pasangan TW turun`,
                payload: raw.decreasing.slice()
            });
        }

        // render categories
        errorCategories.innerHTML = categories.map(cat => `
            <button data-cat="${cat.id}" type="button" class="w-full text-left px-3 py-3 hover:bg-gray-50 flex justify-between items-center">
                <div>
                    <div class="font-medium text-gray-800">${cat.title}</div>
                    <div class="text-xs text-gray-500 mt-0.5">${cat.summary}</div>
                </div>
                <div class="text-gray-400 ml-2">›</div>
            </button>
        `).join("");

        // attach handlers
        Array.from(errorCategories.querySelectorAll("button[data-cat]")).forEach(btn => {
            btn.addEventListener("click", () => {
                const catId = btn.getAttribute("data-cat");
                const cat = categories.find(c => c.id === catId);
                if (!cat) return;

                // hide all highlights first
                twInputs.forEach(i => i.classList.remove("border-red-500", "ring-2", "ring-red-200"));

                if (cat.id === 'cat-total') {
                    const sum = cat.payload.sum;
                    const pk = cat.payload.pk;
                    const indices = cat.payload.indices;
                    const lines = vals.map((v, idx) => `• TW${idx+1} = ${v === null ? '—' : v}`);
                    const diff = sum - pk;
                    errorDetailPanel.innerHTML =
                        `<div class="font-semibold mb-1">Detail: Total Tidak Sesuai PK</div>
                         <div class="text-sm text-gray-700 mb-2">${lines.join('<br>')}</div>
                         <div class="text-sm font-medium text-red-600">Total = ${sum} (harus ${pk}) ${diff !== 0 ? '(selisih ' + diff + ')' : ''}</div>`;
                    errorDetailPanel.classList.remove("hidden");

                    indices.forEach(i => {
                        const el = twInputs[i];
                        if (el) el.classList.add("border-red-500","ring-2","ring-red-200");
                    });

                } else if (cat.id === 'cat-final') {
                    const tw4 = cat.payload.tw4 === null ? '—' : cat.payload.tw4;
                    const pk = cat.payload.pk;
                    errorDetailPanel.innerHTML =
                        `<div class="font-semibold mb-1">Detail: TW Akhir Tidak Sesuai PK</div>
                         <div class="text-sm text-gray-700 mb-2">TW4 = ${tw4}</div>
                         <div class="text-sm font-medium text-red-600">TW4 harus sama dengan PK (${pk})</div>`;
                    errorDetailPanel.classList.remove("hidden");

                    // highlight TW4
                    const el4 = twInputs[3];
                    if (el4) el4.classList.add("border-red-500","ring-2","ring-red-200");

                } else if (cat.id === 'cat-over100') {
                    const lines = cat.payload.map(idx => `• TW${idx+1} = ${vals[idx]} (melebihi 100)`);
                    errorDetailPanel.innerHTML = `<div class="font-semibold mb-1">Detail: Melebihi 100 per TW</div>${lines.join('<br>')}`;
                    errorDetailPanel.classList.remove("hidden");
                    cat.payload.forEach(idx => {
                        const el = twInputs[idx];
                        if (el) el.classList.add("border-red-500","ring-2","ring-red-200");
                    });

                } else if (cat.id === 'cat-decrease') {
                    const lines = cat.payload.map(pair => `• TW${pair.to+1} (${vals[pair.to] ?? '-'}) < TW${pair.from+1} (${vals[pair.from] ?? '-'})`);
                    errorDetailPanel.innerHTML = `<div class="font-semibold mb-1">Detail: Penurunan Nilai</div>${lines.join('<br>')}`;
                    errorDetailPanel.classList.remove("hidden");
                    cat.payload.forEach(pair => {
                        const a = twInputs[pair.from], b = twInputs[pair.to];
                        if (a) a.classList.add("border-red-500","ring-2","ring-red-200");
                        if (b) b.classList.add("border-red-500","ring-2","ring-red-200");
                    });
                } else {
                    errorDetailPanel.classList.add("hidden");
                    errorDetailPanel.innerHTML = "";
                }

                // close dropdown to focus on detail panel
                errorDropdown.classList.add("hidden");
            });
        });
    }

    /* ---------- ICON DROPDOWN TOGGLE ---------- */
    iconErrorWrap.addEventListener("click", function(e) {
        if (iconError.classList.contains("hidden")) return;
        errorDropdown.classList.toggle("hidden");
        errorDetailPanel.classList.add("hidden");
    });

    // click outside to close dropdown
    document.addEventListener("click", function(e) {
        if (!iconErrorWrap.contains(e.target)) {
            errorDropdown.classList.add("hidden");
        }
    });

    /* ---------- REALTIME VALIDATION TRIGGERS ---------- */
    function revalidateAndRender() {
        const v = validateTW();
        renderErrorState(v);
        return v;
    }

    // initial
    applySatuanBehavior();
    revalidateAndRender();

    // input listeners TW
    twInputs.forEach(i => {
        i.addEventListener("input", () => {
            revalidateAndRender();
            const v = validateTW();
            if (v.messages.length > 0) {
                notifMode.innerText = "Validasi: Terdapat pelanggaran";
                setTimeout(() => notifMode.innerText = (mode === 'non' ? "Mode: NON-AKUMULATIF" : "Mode: AKUMULATIF"), 1600);
            }
        });
    });

    // PK change revalidate
    targetPkInput.addEventListener("input", () => {
        revalidateAndRender();
    });

    /* ---------- FORM SUBMIT PREVENT ---------- */
    form.addEventListener("submit", function(e) {
        const v = validateTW();

        // If there are validation messages, block submit
        if (v.messages.length > 0) {
            e.preventDefault();
            errorDropdown.classList.remove("hidden");
            alert("Validasi gagal! Klik ikon ⚠️ di samping mode untuk melihat detail.");
            return false;
        }

        // Extra safety checks:
        if (!satuanSelect.value) {
            e.preventDefault();
            alert("Pilih satuan terlebih dahulu.");
            return false;
        }

        // For unit/dokumentasi we require PK to be filled
        if ((satuanSelect.value === "unit" || satuanSelect.value === "dokumentasi")) {
            if (targetPkInput.value === "" || isNaN(Number(targetPkInput.value))) {
                e.preventDefault();
                alert("Isi Target PK terlebih dahulu untuk satuan Unit/Dokumentasi.");
                return false;
            }
        }

        // For akumulatif, ensure PK is provided (for non-% cases) and TW4 equals PK
        if (mode === "akm") {
            const satuan = satuanSelect.value;
            const pk = (targetPkInput.value === "" ? null : Number(targetPkInput.value));

            if (pk === null) {
                e.preventDefault();
                alert("Untuk mode Akumulatif, isi Target PK terlebih dahulu.");
                return false;
            }
            const tw4Raw = twInputs[3].value;
            const tw4 = (tw4Raw === "" ? null : Number(tw4Raw));
            if (tw4 === null || Math.abs(tw4 - pk) > 1e-9) {
                e.preventDefault();
                alert("Mode Akumulatif: nilai TW4 harus sama dengan Target PK.");
                return false;
            }
        }

        // For non-akumulatif, ensure PK provided and sum equals PK
        if (mode === "non") {
            const satuan = satuanSelect.value;
            const pk = (targetPkInput.value === "" ? null : Number(targetPkInput.value));

            if (pk === null) {
                e.preventDefault();
                alert("Untuk mode Non-Akumulatif, isi Target PK terlebih dahulu.");
                return false;
            }
            const sum = twInputs.reduce((acc, el) => acc + (el.value === "" ? 0 : Number(el.value)), 0);
            if (Math.abs(sum - pk) > 1e-9) {
                e.preventDefault();
                alert("Mode Non-Akum: total TW1..TW4 harus sama dengan Target PK.");
                return false;
            }
        }

        // allow submit
    });

    /* ===================== LOGIKA KODE (original) ===================== */
    const tahunSelect = document.getElementById("tahunSelect");
    const sasaranSelect = document.getElementById("sasaranSelect");
    const kodeInput = document.getElementById("kode_indikator");

    const sasaranData = <?= json_encode($sasaran) ?>;

    tahunSelect.addEventListener("change", function () {
        const selectedYear = this.value;
        sasaranSelect.innerHTML = "";

        if (!selectedYear) {
            sasaranSelect.append(new Option("-- Pilih Tahun Terlebih Dahulu --", ""));
            kodeInput.value = "";
            return;
        }

        sasaranSelect.append(new Option("-- Pilih Sasaran --", ""));

        sasaranData.forEach(s => {
            if (s.tahun == selectedYear) {
                let label = s.kode_sasaran + " - " + s.nama_sasaran;
                sasaranSelect.append(new Option(label, s.id));
            }
        });
    });

    sasaranSelect.addEventListener("change", function () {
        const id = this.value;

        if (!id) {
            kodeInput.value = "";
            return;
        }

        fetch("<?= base_url('admin/indikator/getKode/') ?>" + id)
            .then(res => res.json())
            .then(data => {
                kodeInput.value = data.kode;
            })
            .catch(() => {
                kodeInput.value = "";
            });
    });

});
</script>

<?= $this->endSection() ?>
