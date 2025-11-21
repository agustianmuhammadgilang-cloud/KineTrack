<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<h3 class="text-2xl font-bold text-[var(--polban-blue)] mb-6">Edit PIC</h3>

<form action="<?= base_url('admin/pic/update/'.$pic['id']) ?>" method="post" class="space-y-6">

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label class="block font-medium mb-1">Tahun Anggaran</label>
            <select name="tahun_id" class="w-full border rounded px-3 py-2 focus:ring focus:ring-orange-300">
                <?php foreach($tahun as $t): ?>
                    <option value="<?= $t['id'] ?>" <?= $t['id']==$pic['tahun_id']?'selected':'' ?>><?= $t['tahun'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label class="block font-medium mb-1">Sasaran Strategis</label>
            <select name="sasaran_id" class="w-full border rounded px-3 py-2 focus:ring focus:ring-orange-300">
                <?php foreach($sasaran as $s): ?>
                    <option value="<?= $s['id'] ?>" <?= $s['id']==$pic['sasaran_id']?'selected':'' ?>><?= $s['nama_sasaran'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label class="block font-medium mb-1">Indikator</label>
            <select name="indikator_id" class="w-full border rounded px-3 py-2 focus:ring focus:ring-orange-300">
                <?php foreach($indikator as $i): ?>
                    <option value="<?= $i['id'] ?>" <?= $i['id']==$pic['indikator_id']?'selected':'' ?>><?= $i['nama_indikator'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label class="block font-medium mb-1">Bidang</label>
            <select name="bidang_id" class="w-full border rounded px-3 py-2 focus:ring focus:ring-orange-300">
                <?php foreach($bidang as $b): ?>
                    <option value="<?= $b['id'] ?>" <?= $b['id']==$pic['bidang_id']?'selected':'' ?>><?= $b['nama_bidang'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label class="block font-medium mb-1">Jabatan</label>
            <select name="jabatan_id" class="w-full border rounded px-3 py-2 focus:ring focus:ring-orange-300">
                <?php foreach($jabatan as $j): ?>
                    <option value="<?= $j['id'] ?>" <?= $j['id']==$pic['jabatan_id']?'selected':'' ?>><?= $j['nama_jabatan'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label class="block font-medium mb-1">Pegawai</label>
            <select name="user_id" class="w-full border rounded px-3 py-2 focus:ring focus:ring-orange-300">
                <?php foreach($user as $u): ?>
                    <option value="<?= $u['id'] ?>" <?= $u['id']==$pic['user_id']?'selected':'' ?>><?= $u['nama'] ?> (<?= $u['email'] ?>)</option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="flex gap-3 mt-4">
        <button type="submit" class="bg-[var(--polban-blue)] hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded shadow transition-all">
            Update PIC
        </button>
        <a href="<?= base_url('admin/pic') ?>" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold px-4 py-2 rounded shadow transition-all">
            Kembali
        </a>
    </div>

</form>

<?= $this->endSection() ?>
