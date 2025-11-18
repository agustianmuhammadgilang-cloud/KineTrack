<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rekap Kinerja <?= esc($pegawai['nama']) ?></title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size:12px; }
        table { width:100%; border-collapse: collapse; }
        th, td { border:1px solid #333; padding:6px; }
        th { background:#f0f0f0; }
        .center { text-align:center; }
    </style>
</head>
<body>
    <h2 class="center">Rekap Kinerja Pegawai</h2>
    <p><b>Nama:</b> <?= esc($pegawai['nama']) ?></p>
    <p><b>Jabatan:</b>
    <?= esc($pegawai['nama_jabatan'] ?? $pegawai['jabatan'] ?? $pegawai['jabatan_id'] ?? '-') ?>
</p>


    <hr>

    <h4>Riwayat Laporan</h4>
    <table>
        <thead>
            <tr>
                <th>Judul</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Catatan</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($laporan as $l): ?>
            <tr>
                <td><?= esc($l['judul']) ?></td>
                <td><?= esc($l['tanggal']) ?></td>
                <td><?= esc($l['status']) ?></td>
                <td><?= esc($l['catatan_atasan'] ?? '-') ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
