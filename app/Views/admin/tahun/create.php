<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<div class="max-w-3xl mx-auto bg-white p-8 rounded-xl shadow-md border border-gray-200">
    
    <h3 class="text-2xl font-bold text-[#1D2F83] mb-6">Tambah Tahun Anggaran</h3>

    <form action="<?= base_url('admin/tahun/store') ?>" method="post" class="space-y-6">

        <!-- Input Tahun -->
        <div>
            <label class="block font-semibold mb-1 text-gray-700">Tahun</label>
            <input 
                type="number" 
                name="tahun" 
                required
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1D2F83] focus:border-[#1D2F83]"
            >
        </div>

        <!-- Status -->
        <div>
            <label class="block font-semibold mb-1 text-gray-700">Status</label>
            <select 
                name="status" 
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1D2F83] focus:border-[#1D2F83]"
            >
                <option value="active">Aktif</option>
                <option value="inactive">Tidak Aktif</option>
            </select>
        </div>

        <!-- Buttons -->
        <div class="flex items-center gap-3 pt-4">
            <button 
                class="bg-[#1D2F83] text-white px-6 py-2 rounded-lg hover:bg-[#16256A] transition duration-200"
            >
                Simpan
            </button>

            <a 
                href="<?= base_url('admin/tahun') ?>" 
                class="px-6 py-2 rounded-lg border border-gray-400 text-gray-700 hover:bg-gray-100 transition"
            >
                Kembali
            </a>
        </div>

    </form>
</div>

<?= $this->endSection() ?>