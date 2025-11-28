<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<h3 class="text-2xl font-bold text-[var(--polban-blue)] mb-6">Tambah PIC</h3>

<form action="<?= base_url('admin/pic/store') ?>" method="post" class="space-y-6">

    <!-- Tahun / Sasaran / Indikator -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div>
            <label class="block font-medium mb-2">Tahun Anggaran</label>
            <select name="tahun_id" id="tahun_id" 
                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-orange-300 focus:outline-none transition">
                <option value="">--Pilih Tahun--</option>
                <?php foreach($tahun as $t): ?>
                    <option value="<?= $t['id'] ?>"><?= $t['tahun'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label class="block font-medium mb-2">Triwulan</label>
            <select name="tw" id="tw"
                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-orange-300 focus:outline-none transition">
                <option value="">--Pilih Triwulan--</option>
                <option value="1">TW 1</option>
                <option value="2">TW 2</option>
                <option value="3">TW 3</option>
                <option value="4">TW 4</option>
            </select>
        </div>

        <div>
            <label class="block font-medium mb-2">Sasaran Strategis</label>
            <select name="sasaran_id" id="sasaran_id" 
                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-orange-300 focus:outline-none transition">
                <option value="">--Pilih Sasaran--</option>
            </select>
        </div>

        <div>
            <label class="block font-medium mb-2">Indikator</label>
            <select name="indikator_id" id="indikator_id" 
                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-orange-300 focus:outline-none transition">
                <option value="">--Pilih Indikator--</option>
            </select>
        </div>
    </div>

    <!-- PEMILIHAN USER -->
<div class="bg-white border border-gray-200 p-4 rounded-lg shadow-md">
    <h4 class="font-semibold mb-3 text-gray-700">Pilih PIC</h4>

    <!-- Search Box -->
    <input type="text" id="searchUser" placeholder="Cari nama staff..."
        class="w-full mb-3 border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-300 focus:outline-none transition">

    <div id="pegawaiList" class="space-y-2 max-h-72 overflow-y-auto scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
        <p class="text-gray-400 italic">Pilih indikator terlebih dahulu...</p>
    </div>
</div>

        <div id="pegawaiList" class="space-y-2 max-h-72 overflow-y-auto scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
            <!-- AJAX load list user -->
            <p class="text-gray-400 italic">Pilih indikator terlebih dahulu...</p>
        </div>
    </div>

    <button type="submit"
        class="w-full md:w-auto bg-[var(--polban-orange)] hover:bg-orange-600 text-white font-semibold px-6 py-2 rounded-lg shadow-md transition">
        Simpan
    </button>

</form>

<script>
const baseUrl = "<?= base_url() ?>";

// Tahun → Sasaran
document.querySelector('#tahun_id').addEventListener('change', async function(){
    const res = await fetch(`${baseUrl}/admin/pic/getSasaran?tahun_id=${this.value}`);
    const data = await res.json();

    let sasaran = document.querySelector('#sasaran_id');
    sasaran.innerHTML = '<option value="">--Pilih Sasaran--</option>';
    data.forEach(row => {
        sasaran.innerHTML += `<option value="${row.id}">${row.nama_sasaran}</option>`;
    });
});

// Sasaran → Indikator
document.querySelector('#sasaran_id').addEventListener('change', async function(){
    const res = await fetch(`${baseUrl}/admin/pic/getIndikator?sasaran_id=${this.value}`);
    const data = await res.json();

    let indikator = document.querySelector('#indikator_id');
    indikator.innerHTML = '<option value="">--Pilih Indikator--</option>';
    data.forEach(row => {
        indikator.innerHTML += `<option value="${row.id}">${row.nama_indikator}</option>`;
    });
});

// Load User setelah indikator dipilih
document.querySelector('#indikator_id').addEventListener('change', async function(){

    const res = await fetch(`${baseUrl}/admin/pic/getPegawai`);
    const data = await res.json();

    let container = document.querySelector('#pegawaiList');
    container.innerHTML = '';

    data.forEach(u => {
        container.innerHTML += `
            <label class="flex items-center gap-3 border border-gray-200 p-3 rounded-lg hover:bg-gray-50 cursor-pointer transition">
                <input type="checkbox" name="pegawai[]" value="${u.id}" class="form-checkbox h-5 w-5 text-orange-500">
                <div>
                    <p class="font-semibold text-gray-800">${u.nama}</p>
                    <p class="text-sm text-gray-500">${u.nama_jabatan} — ${u.nama_bidang}</p>
                </div>
            </label>
        `;
    });
});

// FILTER USER BY SEARCH
document.querySelector('#searchUser').addEventListener('input', function() {
    const filter = this.value.toLowerCase();
    const labels = document.querySelectorAll('#pegawaiList label');

    labels.forEach(label => {
        const name = label.querySelector('p.font-semibold').textContent.toLowerCase();
        if(name.includes(filter)) {
            label.style.display = 'flex';
        } else {
            label.style.display = 'none';
        }
    });
});

</script>

<?= $this->endSection() ?>
