<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<style>
    :root {
        --polban-blue: #003366;
        --polban-gold: #D4AF37;
        --transition-smooth: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .form-card {
        background: white;
        border-radius: 32px;
        border: 1px solid #eef2f6;
        box-shadow: 0 20px 50px -12px rgba(0, 51, 102, 0.08);
    }

    .input-field {
        transition: var(--transition-smooth);
        border: 1.5px solid #e2e8f0;
    }

    .input-field:focus {
        border-color: var(--polban-blue);
        box-shadow: 0 0 0 4px rgba(0, 51, 102, 0.05);
        outline: none;
    }

    .btn-polban {
        transition: var(--transition-smooth);
        background: var(--polban-blue);
    }

    .btn-polban:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px -5px rgba(0, 51, 102, 0.3);
        filter: brightness(1.1);
    }

    /* Styling Scrollbar List Pegawai */
    .pegawai-list-container::-webkit-scrollbar { width: 6px; }
    .pegawai-list-container::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 10px; }
    .pegawai-list-container::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    .pegawai-list-container::-webkit-scrollbar-thumb:hover { background: var(--polban-gold); }

    .user-card {
        transition: var(--transition-smooth);
    }
    .user-card:hover {
        border-color: var(--polban-blue);
        background-color: #f8fafc;
    }
    
    .checkbox-polban {
        accent-color: var(--polban-blue);
    }
</style>

<div class="px-4 py-8 max-w-5xl mx-auto">
    <div class="flex items-center gap-5 mb-10">
        <div class="w-14 h-14 bg-blue-50 border border-blue-100 rounded-2xl flex items-center justify-center shadow-sm text-blue-900">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
        </div>
        <div>
            <h4 class="text-2xl font-black text-blue-900 tracking-tight">
                Delegasi Tugas <span class="text-slate-400 font-light">|</span> <span class="text-blue-600">Tambah PIC</span>
            </h4>
            <p class="text-[11px] text-slate-400 font-semibold uppercase tracking-[0.2em] mt-1">
                Penetapan penanggung jawab indikator kinerja
            </p>
        </div>
    </div>

    <form action="<?= base_url('admin/pic/store') ?>" method="post">
        <?= csrf_field() ?>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <div class="lg:col-span-5 space-y-6">
                <div class="form-card p-8 space-y-6">
                    <h5 class="text-xs font-black text-blue-900 uppercase tracking-widest border-b border-slate-50 pb-4">Parameter Indikator</h5>
                    
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Tahun Anggaran</label>
                        <select name="tahun_id" id="tahun_id" class="input-field w-full px-4 py-3 rounded-xl text-blue-900 font-bold bg-slate-50/50">
                            <option value="">-- Pilih Tahun --</option>
                            <?php foreach($tahun as $t): ?>
                                <option value="<?= $t['id'] ?>"><?= $t['tahun'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Sasaran Strategis</label>
                        <select name="sasaran_id" id="sasaran_id" class="input-field w-full px-4 py-3 rounded-xl text-blue-900 font-bold bg-slate-50/50">
                            <option value="">-- Pilih Sasaran --</option>
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Indikator Kinerja</label>
                        <select name="indikator_id" id="indikator_id" class="input-field w-full px-4 py-3 rounded-xl text-blue-900 font-bold bg-slate-50/50">
                            <option value="">-- Pilih Indikator --</option>
                        </select>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-4">
                    <button type="submit" class="btn-polban flex-[2] text-white font-black py-4 rounded-2xl uppercase tracking-widest text-xs shadow-lg">
                        Simpan PIC
                    </button>
                    <a href="<?= base_url('admin/pic') ?>" class="flex-1 bg-white border border-slate-200 text-slate-400 hover:text-slate-600 font-black py-4 rounded-2xl uppercase tracking-widest text-xs text-center transition-all hover:bg-slate-50">
                        Batal
                    </a>
                </div>
            </div>

            <div class="lg:col-span-7">
                <div class="form-card overflow-hidden flex flex-col h-full min-h-[500px]">
                    <div class="p-8 border-b border-slate-50 bg-slate-50/30">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                            <h5 class="text-xs font-black text-blue-900 uppercase tracking-widest">Daftar Pegawai & Staff</h5>
                            <div class="relative group">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400 group-focus-within:text-blue-600 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                </span>
                                <input type="text" id="searchUser" placeholder="Cari nama..."
                                       class="pl-10 pr-4 py-2 bg-white border border-slate-200 rounded-full text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-blue-100 transition-all w-full md:w-64">
                            </div>
                        </div>
                    </div>

                    <div id="pegawaiList" class="pegawai-list-container flex-1 overflow-y-auto p-8 space-y-3">
                        <div class="flex flex-col items-center justify-center h-full text-center space-y-4 opacity-40">
                            <svg class="w-16 h-16 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122" />
                            </svg>
                            <p class="text-sm font-medium text-slate-500 italic">Silakan pilih indikator terlebih dahulu<br>untuk memuat daftar pegawai.</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>

<script>
const baseUrl = "<?= base_url() ?>";

// Tahun → Sasaran
document.querySelector('#tahun_id').addEventListener('change', async function(){
    if(!this.value) return;
    const res = await fetch(`${baseUrl}/admin/pic/getSasaran?tahun_id=${this.value}`);
    const data = await res.json();

    let sasaran = document.querySelector('#sasaran_id');
    sasaran.innerHTML = '<option value="">-- Pilih Sasaran --</option>';
    data.forEach(row => {
        sasaran.innerHTML += `<option value="${row.id}">${row.nama_sasaran}</option>`;
    });
});

// Sasaran → Indikator
document.querySelector('#sasaran_id').addEventListener('change', async function(){
    if(!this.value) return;
    const res = await fetch(`${baseUrl}/admin/pic/getIndikator?sasaran_id=${this.value}`);
    const data = await res.json();

    let indikator = document.querySelector('#indikator_id');
    indikator.innerHTML = '<option value="">-- Pilih Indikator --</option>';
    data.forEach(row => {
        indikator.innerHTML += `<option value="${row.id}">${row.nama_indikator}</option>`;
    });
});

// Load User setelah indikator dipilih
document.querySelector('#indikator_id').addEventListener('change', async function(){
    if(!this.value) return;
    const res = await fetch(`${baseUrl}/admin/pic/getPegawai`);
    const data = await res.json();

    let container = document.querySelector('#pegawaiList');
    container.innerHTML = '';

    data.forEach(u => {
        container.innerHTML += `
            <label class="user-card flex items-center gap-4 border border-slate-100 p-4 rounded-2xl cursor-pointer">
                <div class="relative">
                    <input type="checkbox" name="pegawai[]" value="${u.id}" class="checkbox-polban h-5 w-5 rounded border-slate-300">
                </div>
                <div class="flex-1">
                    <p class="text-[13px] font-black text-blue-900 leading-none mb-1">${u.nama}</p>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-tight">
                        ${u.nama_jabatan} <span class="mx-1 text-slate-200">|</span> ${u.nama_bidang}
                    </p>
                </div>
                <div class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
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
        const name = label.querySelector('p.text-blue-900').textContent.toLowerCase();
        if(name.includes(filter)) {
            label.style.display = 'flex';
        } else {
            label.style.display = 'none';
        }
    });
});
</script>

<?= $this->endSection() ?>