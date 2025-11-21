<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<h3 class="text-2xl font-bold text-[var(--polban-blue)] mb-4">
    Input Pengukuran Kinerja
</h3>

<div class="flex flex-wrap gap-3 mb-6">
    <a href="<?= base_url('admin/tahun') ?>"
        class="px-4 py-2 bg-[var(--polban-blue)] text-white rounded-lg shadow hover:bg-blue-900 transition">
        Kelola Tahun Anggaran
    </a>

    <a href="<?= base_url('admin/sasaran') ?>"
        class="px-4 py-2 bg-[var(--polban-orange)] text-white rounded-lg shadow hover:bg-orange-600 transition">
        Kelola Sasaran Strategis
    </a>

    <a href="<?= base_url('admin/indikator') ?>"
        class="px-4 py-2 bg-gray-700 text-white rounded-lg shadow hover:bg-gray-900 transition">
        Kelola Indikator Kinerja
    </a>

    <a href="<?= base_url('admin/pic') ?>"
        class="px-4 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 transition">
        Kelola PIC
    </a>
</div>

<!-- FILTER -->
<div class="bg-white shadow-md rounded-xl p-6 mb-6 border border-gray-200">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

        <div>
            <label class="font-semibold text-gray-700">Pilih Tahun</label>
            <select id="tahun_id" 
                class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg">
                <option value="">-- Pilih Tahun --</option>
                <?php foreach($tahun as $t): ?>
                <option value="<?= $t['id'] ?>">
                    <?= $t['tahun'] ?> <?= $t['status']=='aktif' ? '(active)' : '' ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label class="font-semibold text-gray-700">Triwulan</label>
            <div class="flex gap-2 mt-1">
                <button class="tw-btn px-4 py-2 border rounded-lg text-gray-700 hover:bg-gray-100" data-tw="1" type="button">TW1</button>
                <button class="tw-btn px-4 py-2 border rounded-lg text-gray-700 hover:bg-gray-100" data-tw="2" type="button">TW2</button>
                <button class="tw-btn px-4 py-2 border rounded-lg text-gray-700 hover:bg-gray-100" data-tw="3" type="button">TW3</button>
                <button class="tw-btn px-4 py-2 border rounded-lg text-gray-700 hover:bg-gray-100" data-tw="4" type="button">TW4</button>
            </div>
        </div>

        <div class="flex items-end">
            <button id="loadBtn" type="button"
                class="w-full bg-[var(--polban-orange)] text-white py-2 rounded-lg font-semibold shadow hover:bg-orange-600 transition">
                Tampilkan Indikator
            </button>
        </div>

    </div>
</div>

<div id="indikatorWrap"></div>

<script>
// ---------- Helper UI CSS (injected) ----------
const injectedStyles = `
/* Improved textarea style for comfortable typing */
.improved-textarea {
  width: 100%;
  min-height: 56px;
  max-height: 240px; /* allow grow but cap height */
  padding: .5rem .75rem;
  border: 1px solid rgba(156,163,175,1);
  border-radius: .5rem;
  resize: vertical;
  overflow: auto;
  line-height: 1.4;
  font-size: .95rem;
  background: #fff;
  /* prevent layout break on long single-words */
  white-space: pre-wrap;
  overflow-wrap: anywhere;
  word-break: break-word;
}
.table-cell-compact { padding: .75rem; vertical-align: top; }
.small-note { font-size: .75rem; color: rgba(107,114,128,1); margin-top: .25rem; }
.btn-disabled { opacity: .6; cursor: not-allowed; }
`;
// append style
const styleTag = document.createElement('style'); styleTag.innerText = injectedStyles; document.head.appendChild(styleTag);

// ============================
// UPDATE TRIWULAN
// ============================
document.querySelector('#tahun_id').addEventListener('change', async function(){
    const tahunId = this.value;
    const res = await fetch(`<?= base_url('admin/sasaran/getTriwulan') ?>?tahun_id=${tahunId}`);
    const twList = await res.json();
    document.querySelectorAll('.tw-btn').forEach(btn => {
        const tw = parseInt(btn.dataset.tw);
        btn.disabled = !twList.includes(tw);
        btn.classList.remove('active','bg-[var(--polban-blue)]','text-white');
    });
});

// ============================
// ACTIVE BUTTON
// ============================
document.querySelectorAll('.tw-btn').forEach(btn => {
    btn.addEventListener('click', function(){
        if(this.disabled) return;
        document.querySelectorAll('.tw-btn')
            .forEach(x => x.classList.remove('bg-[var(--polban-blue)]','text-white','active'));
        this.classList.add('bg-[var(--polban-blue)]','text-white','active');
    });
});

// ============================
// LOAD INDIKATOR (improved textarea in-table UX)
// ============================
document.querySelector('#loadBtn').addEventListener('click', async function(){

    const tahunId = document.querySelector('#tahun_id').value;
    const activeBtn = document.querySelector('.tw-btn.active');
    const tw = activeBtn ? activeBtn.dataset.tw : null;
    if (!tahunId || !tw) return alert("Pilih tahun dan triwulan!");

    const res = await fetch("<?= base_url('admin/pengukuran/load') ?>", {
        method:'POST',
        headers:{ 'Content-Type':'application/x-www-form-urlencoded' },
        body: new URLSearchParams({ tahun_id: tahunId, triwulan: tw }).toString()
    });

    const json = await res.json();
    if (!json.status) return alert(json.message);

    // build table
    let html = `
    <form id="bulkSaveForm" enctype="multipart/form-data" novalidate>
        <input type="hidden" name="tahun_id" value="${tahunId}">
        <input type="hidden" name="triwulan" value="${tw}">

        <div class="overflow-x-auto shadow-md bg-white rounded-xl border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-[var(--polban-blue)] text-white">
            <tr>
                <th class="px-4 py-3 text-left text-sm font-semibold">Sasaran</th>
                <th class="px-4 py-3 text-left text-sm font-semibold">Indikator</th>
                <th class="px-4 py-3 text-left text-sm font-semibold">Satuan</th>
                <th class="px-4 py-3 text-left text-sm font-semibold">Realisasi</th>
                <th class="px-4 py-3 text-left text-sm font-semibold">Kendala</th>
                <th class="px-4 py-3 text-left text-sm font-semibold">Strategi</th>
                <th class="px-4 py-3 text-left text-sm font-semibold">Data Dukung</th>
                <th class="px-4 py-3 text-left text-sm font-semibold">File</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
    `;

    json.indikator.forEach(ind => {
        const ex = json.existing[ind.id] ?? {};
        // escape values for safety in template insertion (simple)
        const esc = s => (s||'').toString().replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');

        html += `
        <tr class="hover:bg-gray-50">
            <td class="table-cell-compact px-4 py-3">${esc(ind.nama_sasaran)}</td>
            <td class="table-cell-compact px-4 py-3">${esc(ind.nama_indikator)}</td>
            <td class="table-cell-compact px-4 py-3">${esc(ind.satuan ?? '-')}</td>

            <td class="table-cell-compact px-4 py-3">
                <textarea name="realisasi_${ind.id}" class="improved-textarea" data-field="realisasi_${ind.id}" placeholder="Tulis realisasi...">${esc(ex.realisasi ?? '')}</textarea>
                <div class="small-note">Tekan Enter untuk baris baru. Kotak akan bertambah otomatis.</div>
            </td>

            <td class="table-cell-compact px-4 py-3">
                <textarea name="kendala_${ind.id}" class="improved-textarea" data-field="kendala_${ind.id}" placeholder="Tuliskan kendala...">${esc(ex.kendala ?? '')}</textarea>
                <div class="small-note">Cantumkan yang relevan, singkat & padat.</div>
            </td>

            <td class="table-cell-compact px-4 py-3">
                <textarea name="strategi_${ind.id}" class="improved-textarea" data-field="strategi_${ind.id}" placeholder="Strategi/tindakan...">${esc(ex.strategi ?? '')}</textarea>
                <div class="small-note">Rencana aksi singkat.</div>
            </td>

            <td class="table-cell-compact px-4 py-3">
                <textarea name="data_dukung_${ind.id}" class="improved-textarea" data-field="data_dukung_${ind.id}" placeholder="Link / keterangan data dukung...">${esc(ex.data_dukung ?? '')}</textarea>
                <div class="small-note">Link / file referensi (lihat kolom file).</div>
            </td>

            <td class="table-cell-compact px-4 py-3">
                <input type="file" name="file_${ind.id}" class="w-full text-sm text-gray-600 cursor-pointer file:bg-[var(--polban-orange)] file:text-white file:border-none file:rounded-lg file:px-3 file:py-2">
                <div class="small-note">File max: sesuai konfigurasi server.</div>
            </td>
        </tr>`;
    });

    html += `
        </tbody></table>
        </div>

        <div class="flex items-center justify-between mt-4 gap-4">
            <div class="text-sm text-gray-600">Periksa kembali lalu klik Simpan Semua untuk menyimpan data.</div>
            <button id="saveBulk" type="button" class="bg-[var(--polban-blue)] text-white px-6 py-3 rounded-lg font-semibold shadow disabled:opacity-60 btn-disabled" disabled>Simpan Semua</button>
        </div>
    </form>`;

    // render
    document.querySelector('#indikatorWrap').innerHTML = html;

    // ====== enhance behaviour ======
    const form = document.querySelector('#bulkSaveForm');
    const textareas = Array.from(form.querySelectorAll('textarea.improved-textarea'));
    const fileInputs = Array.from(form.querySelectorAll('input[type="file"]'));
    const saveBtn = document.getElementById('saveBulk');

    // auto-resize helper (initial + on input)
    function autoResizeTa(el) {
        el.style.height = 'auto';
        // limit max, but allow scroll inside if exceed
        const max = 240; // px matches CSS max-height
        const newH = Math.min(el.scrollHeight, max);
        el.style.height = (newH) + 'px';
    }

    textareas.forEach(ta => {
        // initial sizing
        autoResizeTa(ta);

        // on input
        ta.addEventListener('input', (e) => {
            autoResizeTa(ta);
            markDirty();
        });

        // optional: allow Ctrl+Enter to submit all quickly
        ta.addEventListener('keydown', (e) => {
            if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
                // enable and trigger save
                if (!saveBtn.disabled) saveBulkHandler();
            }
        });
    });

    // when file selected -> mark dirty
    fileInputs.forEach(fi => fi.addEventListener('change', markDirty));

    // Enable Save button only when user edits something
    let dirty = false;
    function markDirty() {
        if (!dirty) {
            dirty = true;
            saveBtn.disabled = false;
            saveBtn.classList.remove('btn-disabled');
        }
    }

    // Save handler (uses Fetch + FormData)
    async function saveBulkHandler() {
        // disable to prevent double submit
        saveBtn.disabled = true;
        saveBtn.classList.add('btn-disabled');
        saveBtn.textContent = 'Menyimpan...';

        const fd = new FormData(form);

        try {
            const r = await fetch("<?= base_url('admin/pengukuran/store') ?>", {
                method: 'POST',
                body: fd
            });

            if (r.redirected) {
                // mengikuti redirect (mis. ke halaman list)
                window.location.href = r.url;
                return;
            }

            // coba parse json untuk response
            let data = null;
            try { data = await r.json(); } catch (err) { /* ignore */ }

            // beri feedback
            if (r.ok) {
                // sukses (server mungkin kirim {status:true, message:'...'} atau redirect)
                alert((data && data.message) ? data.message : 'Data berhasil disimpan.');
                dirty = false;
            } else {
                alert((data && data.message) ? ('Error: ' + data.message) : 'Gagal menyimpan data (server error)');
            }
        } catch (err) {
            console.error(err);
            alert('Gagal menyimpan: ' + err.message);
        } finally {
            saveBtn.disabled = false;
            saveBtn.classList.remove('btn-disabled');
            saveBtn.textContent = 'Simpan Semua';
        }
    }

    saveBtn.addEventListener('click', saveBulkHandler);
});
</script>

<?= $this->endSection() ?>
