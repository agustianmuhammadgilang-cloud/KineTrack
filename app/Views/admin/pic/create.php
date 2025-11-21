// 4️⃣ View: admin/pic/create.php (simplified + repeatable block)
<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<h3>Tambah PIC</h3>
<form action="<?= base_url('admin/pic/store') ?>" method="post" id="picForm">
    <div>
        <label>Tahun Anggaran</label>
        <select name="tahun_id" id="tahun_id">
            <option value="">--Pilih Tahun--</option>
            <?php foreach($tahun as $t): ?>
                <option value="<?= $t['id'] ?>"><?= $t['tahun'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div>
        <label>Sasaran Strategis</label>
        <select name="sasaran_id" id="sasaran_id"><option>--Pilih Sasaran--</option></select>
    </div>
    <div>
        <label>Indikator</label>
        <select name="indikator_id" id="indikator_id"><option>--Pilih Indikator--</option></select>
    </div>

    <div id="picBlockContainer">
        <div class="pic-block">
            <select name="bidang[]" class="bidang"><option>--Pilih Bidang--</option><?php foreach($bidang as $b): ?><option value="<?= $b['id'] ?>"><?= $b['nama_bidang'] ?></option><?php endforeach; ?></select>
            <select name="jabatan[]" class="jabatan"><option>--Pilih Jabatan--</option></select>
            <select name="pegawai[]" class="pegawai"><option>--Pilih Pegawai--</option></select>
        </div>
    </div>
    <button type="button" id="addPicBlock">+ Tambah PIC</button>
    <button type="submit">Simpan</button>
</form>

<script>
document.querySelector('#tahun_id').addEventListener('change', async function(){
    const res = await fetch(<?= base_url('admin/pic/getSasaran') ?>?tahun_id=${this.value});
    const data = await res.json();
    let sasaranSelect = document.querySelector('#sasaran_id');
    sasaranSelect.innerHTML = '<option>--Pilih Sasaran--</option>';
    data.forEach(s => { sasaranSelect.innerHTML += <option value="${s.id}">${s.nama_sasaran}</option> });
});

document.querySelector('#sasaran_id').addEventListener('change', async function(){
    const res = await fetch(<?= base_url('admin/pic/getIndikator') ?>?sasaran_id=${this.value});
    const data = await res.json();
    let indSelect = document.querySelector('#indikator_id');
    indSelect.innerHTML = '<option>--Pilih Indikator--</option>';
    data.forEach(i => { indSelect.innerHTML += <option value="${i.id}">${i.nama_indikator}</option> });
});

// repeatable PIC block
document.querySelector('#addPicBlock').addEventListener('click', function(){
    let container = document.querySelector('#picBlockContainer');
    let block = document.querySelector('.pic-block').cloneNode(true);
    block.querySelectorAll('select').forEach(s => s.value = '');
    container.appendChild(block);
});

// cascading bidang -> jabatan -> pegawai
document.querySelector('#picBlockContainer').addEventListener('change', async function(e){
    if(e.target.classList.contains('bidang')){
        let block = e.target.closest('.pic-block');
        let res = await fetch(<?= base_url('admin/pic/getJabatan') ?>?bidang_id=${e.target.value});
        let data = await res.json();
        let jabatanSelect = block.querySelector('.jabatan');
        jabatanSelect.innerHTML = '<option>--Pilih Jabatan--</option>';
        data.forEach(j => { jabatanSelect.innerHTML += <option value="${j.id}">${j.nama_jabatan}</option> });
    }
    if(e.target.classList.contains('jabatan')){
        let block = e.target.closest('.pic-block');
        let res = await fetch(<?= base_url('admin/pic/getPegawai') ?>?jabatan_id=${e.target.value});
        let data = await res.json();
        let pegawaiSelect = block.querySelector('.pegawai');
        pegawaiSelect.innerHTML = '<option>--Pilih Pegawai--</option>';
        data.forEach(u => { pegawaiSelect.innerHTML += <option value="${u.id}">${u.nama} (${u.email})</option> });
    }
});
</script>
<?= $this->endSection() ?>