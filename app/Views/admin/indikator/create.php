<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<h3 class="text-2xl font-bold text-[var(--polban-blue)] mb-6">
    Tambah Indikator Kinerja
</h3>

<div class="bg-white p-6 rounded-xl shadow-md border border-gray-200 max-w-3xl">
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

        <!-- ===================== SATUAN ===================== -->
        <div>
            <label class="block font-semibold text-gray-700 mb-1">Satuan</label>
            <input type="text" name="satuan" placeholder="% / Unit / Dokumen / dll"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[var(--polban-blue)]">
        </div>

        <!-- ===================== TARGET PK ===================== -->
        <div>
            <label class="block font-semibold text-gray-700 mb-1">Target PK</label>
            <input type="number" name="target_pk"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[var(--polban-blue)]">
        </div>

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

    /* ---------- MODE ---------- */
    let mode = "non"; // default

    function setMode(m) {
        mode = m;
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
        // revalidate on mode change
        const errors = validateTW();
        renderErrorState(errors);
    }

    btnNon.addEventListener("click", () => setMode("non"));
    btnAkm.addEventListener("click", () => setMode("akm"));
    setMode("non");

    /* ---------- VALIDATION LOGIC (fixed for NON sum case) ---------- */
    function gatherValidation() {
        const vals = twInputs.map(i => {
            const raw = i.value;
            if (raw === "" || raw === null) return null;
            const n = Number(raw);
            return isFinite(n) ? n : null;
        });

        const result = {
            over100: [],      // per-TW >100 (akumulatif)
            decreasing: [],   // pairs for akumulatif
            sumOver100: null, // { sum: number, indices: [..] } for non
        };

        // MODE NON: total TW must not exceed 100 (FIX)
        if (mode === "non") {
            const sum = vals.reduce((acc, v) => acc + (v ?? 0), 0);
            if (sum > 100) {
                // also capture which TWs contributed (>0) for detail
                const indices = vals.map((v, idx) => v !== null && v > 0 ? idx : -1).filter(i => i >= 0);
                result.sumOver100 = { sum, indices };
            }
            return { vals, result };
        }

        // MODE AKUMULATIF (unchanged logic)
        vals.forEach((v, idx) => {
            if (v !== null && v > 100) result.over100.push(idx);
        });

        for (let i = 1; i < vals.length; i++) {
            const prev = vals[i-1], cur = vals[i];
            if (prev !== null && cur !== null && cur < prev) {
                result.decreasing.push({from: i-1, to: i});
            }
        }

        return { vals, result };
    }

    function validateTW() {
        const { vals, result } = gatherValidation();
        const messages = [];

        // NON: sumOver100 message
        if (mode === "non" && result.sumOver100) {
            messages.push({
                type: 'sumOver100',
                text: `Total TW (TW1+TW2+TW3+TW4) = ${result.sumOver100.sum} melebihi 100`,
                payload: result.sumOver100
            });
        }

        // AKM: per-TW >100
        result.over100.forEach(idx => {
            messages.push({type: 'over100', text: `TW${idx+1} tidak boleh melebihi 100`, index: idx});
        });

        // AKM: decreasing
        result.decreasing.forEach(obj => {
            messages.push({type: 'decreasing', text: `TW${obj.to+1} tidak boleh turun dari TW${obj.from+1}`, from: obj.from, to: obj.to});
        });

        return { raw: result, messages, vals };
    }

    /* ---------- ERROR UI RENDER (includes sum detail) ---------- */
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

        // NEW: total/sum category (NON mode)
        if (raw.sumOver100) {
            categories.push({
                id: 'cat-total',
                title: 'Jumlah Total Melebihi 100',
                summary: `Total = ${raw.sumOver100.sum} (maks 100)`,
                payload: raw.sumOver100
            });
        }

        if (raw.over100 && raw.over100.length > 0) {
            categories.push({
                id: 'cat-over100',
                title: 'Melebihi Batas 100 (per TW)',
                summary: `${raw.over100.length} TW melebihi 100`,
                payload: raw.over100.slice()
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
                    const indices = cat.payload.indices;
                    // detail lines: list each TW with its value
                    const lines = vals.map((v, idx) => `• TW${idx+1} = ${v === null ? '—' : v}`);
                    const exceed = sum - 100;
                    errorDetailPanel.innerHTML =
                        `<div class="font-semibold mb-1">Detail: Total Melebihi 100</div>
                         <div class="text-sm text-gray-700 mb-2">${lines.join('<br>')}</div>
                         <div class="text-sm font-medium text-red-600">Total = ${sum} (melebihi ${exceed})</div>`;
                    errorDetailPanel.classList.remove("hidden");

                    // highlight TW inputs that contribute (value > 0)
                    indices.forEach(i => {
                        const el = twInputs[i];
                        if (el) el.classList.add("border-red-500","ring-2","ring-red-200");
                    });

                } else if (cat.id === 'cat-over100') {
                    const lines = cat.payload.map(idx => `• TW${idx+1} = ${vals[idx]} (melebihi 100)`);
                    errorDetailPanel.innerHTML = `<div class="font-semibold mb-1">Detail: Melebihi 100 per TW</div>${lines.join('<br>')}`;
                    errorDetailPanel.classList.remove("hidden");
                    // highlight offending TWs
                    cat.payload.forEach(idx => {
                        const el = twInputs[idx];
                        if (el) el.classList.add("border-red-500","ring-2","ring-red-200");
                    });

                } else if (cat.id === 'cat-decrease') {
                    const lines = cat.payload.map(pair => `• TW${pair.to+1} (${vals[pair.to] ?? '-'}) < TW${pair.from+1} (${vals[pair.from] ?? '-'})`);
                    errorDetailPanel.innerHTML = `<div class="font-semibold mb-1">Detail: Penurunan Nilai</div>${lines.join('<br>')}`;
                    errorDetailPanel.classList.remove("hidden");
                    // highlight both sides of each pair
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
    revalidateAndRender();

    // input listeners
    twInputs.forEach(i => {
        i.addEventListener("input", () => {
            revalidateAndRender();
            // subtle inline notification
            const v = validateTW();
            if (v.messages.length > 0) {
                notifMode.innerText = "Validasi: Terdapat pelanggaran";
                setTimeout(() => notifMode.innerText = (mode === 'non' ? "Mode: NON-AKUMULATIF" : "Mode: AKUMULATIF"), 1600);
            }
        });
    });

    /* ---------- FORM SUBMIT PREVENT ---------- */
    form.addEventListener("submit", function(e) {
        const v = validateTW();
        if (v.messages.length > 0) {
            e.preventDefault();
            errorDropdown.classList.remove("hidden");
            alert("Validasi gagal! Klik ikon ⚠️ di samping mode untuk melihat detail.");
            return false;
        }
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
            });
    });

});
</script>

<?= $this->endSection() ?>
