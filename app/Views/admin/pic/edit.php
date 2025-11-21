<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<h3>Edit PIC</h3>

<form action="<?= base_url('admin/pic/update/'.$pic['id']) ?>" method="post">
    <select name="tahun_id">
        <?php foreach($tahun as $t): ?>
            <option value="<?= $t['id'] ?>" <?= $t['id']==$pic['tahun_id']?'selected':'' ?>><?= $t['tahun'] ?></option>
        <?php endforeach; ?>
    </select>

    <select name="sasaran_id">
        <?php foreach($sasaran as $s): ?>
            <option value="<?= $s['id'] ?>" <?= $s['id']==$pic['sasaran_id']?'selected':'' ?>><?= $s['nama_sasaran'] ?></option>
        <?php endforeach; ?>
    </select>

    <select name="indikator_id">
        <?php foreach($indikator as $i): ?>
            <option value="<?= $i['id'] ?>" <?= $i['id']==$pic['indikator_id']?'selected':'' ?>><?= $i['nama_indikator'] ?></option>
        <?php endforeach; ?>
    </select>

    <select name="bidang_id">
        <?php foreach($bidang as $b): ?>
            <option value="<?= $b['id'] ?>" <?= $b['id']==$pic['bidang_id']?'selected':'' ?>><?= $b['nama_bidang'] ?></option>
        <?php endforeach; ?>
    </select>

    <select name="jabatan_id">
        <?php foreach($jabatan as $j): ?>
            <option value="<?= $j['id'] ?>" <?= $j['id']==$pic['jabatan_id']?'selected':'' ?>><?= $j['nama_jabatan'] ?></option>
        <?php endforeach; ?>
    </select>

    <select name="user_id">
        <?php foreach($user as $u): ?>
            <option value="<?= $u['id'] ?>" <?= $u['id']==$pic['user_id']?'selected':'' ?>><?= $u['nama'] ?> (<?= $u['email'] ?>)</option>
        <?php endforeach; ?>
    </select>

    <button type="submit">Update PIC</button>
</form>

<?= $this->endSection() ?>