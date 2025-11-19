<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<h3>Input Pengukuran Kinerja</h3>

<div class="card p-3 mb-3">
    <div class="row g-2 align-items-center">
        <div class="col-md-4">
            <label>Pilih Tahun</label>
            <select id="tahun_id" class="form-control">
                <option value="">-- Pilih Tahun --</option>
                <?php foreach($tahun as $t): ?>
                <option value="<?= $t['id'] ?>"><?= $t['tahun'] ?> <?= $t['status']=='active' ? '(active)' : '' ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-4">
            <label>Triwulan</label>
            <div>
                <button class="btn btn-outline-secondary tw-btn" data-tw="1">TW1</button>
                <button class="btn btn-outline-secondary tw-btn" data-tw="2">TW2</button>
                <button class="btn btn-outline-secondary tw-btn" data-tw="3">TW3</button>
                <button class="btn btn-outline-secondary tw-btn" data-tw="4">TW4</button>
            </div>
        </div>

        <div class="col-md-4">
            <label>&nbsp;</label><br>
            <button id="loadBtn" class="btn btn-polban">Tampilkan Indikator</button>
        </div>
    </div>
</div>

<div id="indikatorWrap"></div>

<script>
document.querySelector('#loadBtn').addEventListener('click', async function(){
    const tahunId = document.querySelector('#tahun_id').value;
    const activeBtn = document.querySelector('.tw-btn.active');
    const tw = activeBtn ? activeBtn.dataset.tw : null;

    if (!tahunId || !tw) {
        alert("Pilih tahun dan triwulan!");
        return;
    }

    const res = await fetch("<?= base_url('admin/pengukuran/load') ?>", {
        method:'POST',
        headers:{ 'Content-Type':'application/x-www-form-urlencoded' },
        body: new URLSearchParams({ tahun_id: tahunId, triwulan: tw }).toString()
    });

    const json = await res.json();
    if (!json.status) { alert(json.message); return; }

    let html = `
    <form id="bulkSaveForm" enctype="multipart/form-data">
        <input type="hidden" name="tahun_id" value="${tahunId}">
        <input type="hidden" name="triwulan" value="${tw}">
        <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sasaran</th>
                <th>Indikator</th>
                <th>Satuan</th>
                <th>Realisasi</th>
                <th>Kendala</th>
                <th>Strategi</th>
                <th>Data Dukung</th>
                <th>File</th>
            </tr>
        </thead>
        <tbody>
    `;

    json.indikator.forEach(ind => {
        const ex = json.existing[ind.id] ?? null;

        html += `
            <tr>
                <td>${ind.nama_sasaran}</td>
                <td>${ind.nama_indikator}</td>
                <td>${ind.satuan ?? '-'}</td>

                <td>
                    <input class="form-control realisasi" 
                           name="realisasi_${ind.id}"
                           value="${ex ? (ex.realisasi ?? '') : ''}">
                </td>

                <td>
                    <input class="form-control kendala" 
                           name="kendala_${ind.id}"
                           value="${ex ? (ex.kendala ?? '') : ''}">
                </td>

                <td>
                    <input class="form-control strategi" 
                           name="strategi_${ind.id}"
                           value="${ex ? (ex.strategi ?? '') : ''}">
                </td>

                <td>
                    <input class="form-control data_dukung" 
                           name="data_dukung_${ind.id}"
                           value="${ex ? (ex.data_dukung ?? '') : ''}">
                </td>

                <td>
                    <input type="file" class="form-control" name="file_${ind.id}">
                </td>
            </tr>
        `;
    });

    html += `
        </tbody></table>
        <button class="btn btn-polban" id="saveBulk">Simpan Semua</button>
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
        else alert('Tersimpan!');
    });
});

// Triwulan toggle
document.querySelectorAll('.tw-btn').forEach(btn => {
    btn.addEventListener('click', function(){
        document.querySelectorAll('.tw-btn').forEach(x => x.classList.remove('active'));
        this.classList.add('active');
    });
});
</script>

<?= $this->endSection() ?>
