<h3>Task Anda</h3>
<ul>
<?php foreach($tasks as $t): ?>
    <li>
        <?= $t['nama_indikator'] ?> (Tahun <?= $t['tahun'] ?>)
        <a href="<?= base_url('staff/task/input/'.$t['indikator_id']) ?>">Isi Pengukuran</a>
    </li>
<?php endforeach; ?>
</ul>