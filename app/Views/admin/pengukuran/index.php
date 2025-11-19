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
                <option value="<?= $t['id'] ?>"><?= $t['tahun'] ?> <?= $t['status']=='active' ? '(active)':'' ?></option>
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

<!-- container indikator -->
<div id="indikatorWrap"></div>

<script>
document.querySelector('#loadBtn').addEventListener('click', async function(){
    const tahunId = document.querySelector('#tahun_id').value;
    const activeBtn = document.querySelector('.tw-btn.active');
    const tw = activeBtn ? activeBtn.dataset.tw : null;
    if (!tahunId || !tw) { alert('Pilih tahun dan triwulan'); return; }

    // show loader
    const res = await fetch("<?= base_url('admin/pengukuran/load') ?>", {
        method:'POST', headers:{ 'Content-Type':'application/x-www-form-urlencoded' },
        body: new URLSearchParams({ tahun_id: tahunId, triwulan: tw }).toString()
    });
    const json = await res.json();
    if (!json.status) { alert(json.message||'error'); return; }

    // build table + form rows
    let html = `<form id="bulkSaveForm"><input type="hidden" name="tahun_id" value="${tahunId}"><input type="hidden" name="triwulan" value="${tw}">`;
    html += '<table class="table table-bordered"><thead><tr><th>Sasaran</th><th>Indikator</th><th>Satuan</th><th>Target (TW)</th><th>Realisasi</th><th>Kendala</th><th>Strategi</th><th>Data Dukung</th></tr></thead><tbody>';

    json.indikator.forEach(ind => {
        const ex = json.existing && json.existing[ind.id] ? json.existing[ind.id] : null;
        const target = (ind["target_tw"+tw] !== null && ind["target_tw"+tw] !== undefined && ind["target_tw"+tw] !== "") ? ind["target_tw"+tw] : ind.target_pk;
        html += `<tr>
            <td>${ind.kode_sasaran ? '['+ind.kode_sasaran+'] ':' '}${ind.nama_sasaran}</td>
            <td>${ind.kode_indikator ? '['+ind.kode_indikator+'] ' : ''}${ind.nama_indikator}</td>
            <td>${ind.satuan||'-'}</td>
            <td><input type="hidden" name="rows[]" value='${JSON.stringify({indikator_id:ind.id,tahun_id:tahunId,triwulan:tw,target:target})}' /></td>
            <td><input class="form-control realisasi" data-id="${ind.id}" value="${ex?ex.realisasi:''}" /></td>
            <td><input class="form-control kendala" data-id="${ind.id}" value="${ex? (ex.kendala || '') : ''}" /></td>
            <td><input class="form-control strategi" data-id="${ind.id}" value="${ex? (ex.strategi || '') : ''}" /></td>
            <td><input class="form-control data_dukung" data-id="${ind.id}" value="${ex? (ex.data_dukung || '') : ''}" /></td>
        </tr>`;
    });

    html += '</tbody></table>';
    html += '<div class="mb-3"><button class="btn btn-polban" id="saveBulk">Simpan Semua</button></div>';
    html += '</form>';

    document.querySelector('#indikatorWrap').innerHTML = html;

    // attach save handler
    document.querySelector('#saveBulk').addEventListener('click', async function(e){
        e.preventDefault();
        // build rows array
        const rows = [];
        document.querySelectorAll('input.realisasi').forEach(inp => {
            const id = inp.dataset.id;
            const real = inp.value;
            const kend = document.querySelector('input.kendala[data-id="'+id+'"]').value;
            const strat = document.querySelector('input.strategi[data-id="'+id+'"]').value;
            const data = document.querySelector('input.data_dukung[data-id="'+id+'"]').value;
            rows.push({ indikator_id: id, tahun_id: tahunId, triwulan: tw, realisasi: real, kendala: kend, strategi: strat, data_dukung: data, target: ''});
        });

        // send to store
        const res2 = await fetch("<?= base_url('admin/pengukuran/store') ?>", {
            method:'POST',
            headers:{ 'Content-Type':'application/x-www-form-urlencoded' },
            body: new URLSearchParams({ rows: JSON.stringify(rows) }).toString()
        });
        if (res2.redirected) window.location = res2.url;
        else {
            alert('Tersimpan'); location.reload();
        }
    });

});

// triwulan button toggle
document.querySelectorAll('.tw-btn').forEach(b=>{
    b.addEventListener('click', function(){
        document.querySelectorAll('.tw-btn').forEach(x=>x.classList.remove('active'));
        this.classList.add('active');
    });
});
</script>

<?= $this->endSection() ?>
