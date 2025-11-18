<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rekap Bidang <?= esc($bidang['nama_bidang']) ?></title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size:12px; }
        table { width:100%; border-collapse: collapse; }
        th, td { border:1px solid #333; padding:6px; }
        th { background:#f0f0f0; }
    </style>
</head>
<body>
    <h2>Rekap Bidang: <?= esc($bidang['nama_bidang']) ?></h2>

    <h4>Ranking Pegawai (Bulan Ini)</h4>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Jabatan</th>
                <th>Diterima</th>
                <th>Ditolak</th>
                <th>Progress %</th>
            </tr>
        </thead>
        <tbody>
        <?php $i=1; foreach($items as $it): ?>
            <tr>
                <td><?= $i++ ?></td>
                <td><?= esc($it['nama']) ?></td>
                <td><?= esc($it['jabatan']) ?></td>
                <td><?= esc($it['approved']) ?></td>
                <td><?= esc($it['rejected']) ?></td>
                <td><?= esc($it['progress']) ?>%</td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
