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

</div>


<!-- FILTER CARD -->
<div class="bg-white shadow-md rounded-xl p-6 mb-6 border border-gray-200">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

        <!-- Tahun -->
        <div>
            <label class="font-semibold text-gray-700">Pilih Tahun</label>
            <select id="tahun_id" 
                class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[var(--polban-blue)]">
                <option value="">-- Pilih Tahun --</option>
                <?php foreach($tahun as $t): ?>
                <option value="<?= $t['id'] ?>">
                    <?= $t['tahun'] ?> <?= $t['status']=='active' ? '(active)' : '' ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Triwulan -->
        <div>
            <label class="font-semibold text-gray-700">Triwulan</label>
            <div class="flex gap-2 mt-1">
                <button class="tw-btn px-4 py-2 border rounded-lg text-gray-700 hover:bg-gray-100" data-tw="1">TW1</button>
                <button class="tw-btn px-4 py-2 border rounded-lg text-gray-700 hover:bg-gray-100" data-tw="2">TW2</button>
                <button class="tw-btn px-4 py-2 border rounded-lg text-gray-700 hover:bg-gray-100" data-tw="3">TW3</button>
                <button class="tw-btn px-4 py-2 border rounded-lg text-gray-700 hover:bg-gray-100" data-tw="4">TW4</button>
            </div>
        </div>

        <!-- Button -->
        <div class="flex items-end">
            <button id="loadBtn" 
                class="w-full bg-[var(--polban-orange)] text-white py-2 rounded-lg font-semibold shadow hover:bg-orange-600 transition">
                Tampilkan Indikator
            </button>
        </div>

    </div>
</div>

<!-- TABLE WRAPPER -->
<div id="indikatorWrap"></div>

<script>
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

    let html = `
    <form id="bulkSaveForm" enctype="multipart/form-data">
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
        const ex = json.existing[ind.id] ?? null;

        html += `
        <tr class="hover:bg-gray-50">
            <td class="px-4 py-3">${ind.nama_sasaran}</td>
            <td class="px-4 py-3">${ind.nama_indikator}</td>
            <td class="px-4 py-3">${ind.satuan ?? '-'}</td>

            <td class="px-4 py-3">
                <input name="realisasi_${ind.id}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg"
                    value="${ex ? (ex.realisasi ?? '') : ''}">
            </td>

            <td class="px-4 py-3">
                <input name="kendala_${ind.id}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg"
                    value="${ex ? (ex.kendala ?? '') : ''}">
            </td>

            <td class="px-4 py-3">
                <input name="strategi_${ind.id}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg"
                    value="${ex ? (ex.strategi ?? '') : ''}">
            </td>

            <td class="px-4 py-3">
                <input name="data_dukung_${ind.id}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg"
                    value="${ex ? (ex.data_dukung ?? '') : ''}">
            </td>

            <td class="px-4 py-3">
                <input type="file" name="file_${ind.id}"
                    class="w-full text-sm text-gray-600 cursor-pointer file:bg-[var(--polban-orange)] file:text-white file:border-none file:rounded-lg file:px-3 file:py-2">
            </td>
        </tr>`;
    });

    html += `
        </tbody></table>
        </div>

        <button id="saveBulk"
            class="mt-4 bg-[var(--polban-blue)] text-white px-6 py-3 rounded-lg font-semibold shadow hover:bg-blue-900 transition">
            Simpan Semua
        </button>
    </form>`;

    document.querySelector('#indikatorWrap').innerHTML = html;

    document.querySelector('#saveBulk').addEventListener('click', async function(e){
        e.preventDefault();
        const form = document.querySelector('#bulkSaveForm');
        const formData = new FormData(form);

        const res2 = await fetch("<?= base_url('admin/pengukuran/store') ?>", {
            method: 'POST',
            body: formData
        });

        if (res2.redirected) location.href = res2.url;
        else alert("Tersimpan!");
    });
});

// TW button active state
document.querySelectorAll('.tw-btn').forEach(btn => {
    btn.addEventListener('click', function(){
        document.querySelectorAll('.tw-btn').forEach(x => x.classList.remove('bg-[var(--polban-blue)]','text-white'));
        this.classList.add('bg-[var(--polban-blue)]','text-white');
        this.classList.add('active');
    });
});
</script>

<?= $this->endSection() ?>
