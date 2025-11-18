<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rekap Bidang - <?= esc($bidang['nama_bidang'] ?? '-') ?></title>
    <style>
        body { font-family: DejaVu Sans, Arial, sans-serif; font-size: 12px; color:#111; }
        .header { text-align: center; margin-bottom: 6px; }
        h2 { margin: 0; }
        .meta { margin-top: 10px; margin-bottom: 14px; }
        .meta td { padding: 4px 6px; }
        table { border-collapse: collapse; width: 100%; margin-top: 8px; }
        th, td { border: 1px solid #444; padding: 8px; text-align: left; }
        th { background: #f3f3f3; }
        .small { font-size: 11px; color:#555; }
        .center { text-align:center; }
    </style>
</head>
<body>

<div class="header">
    <h2>Rekap Kinerja Bidang</h2>
    <div class="small"><?= esc($bidang['nama_bidang'] ?? '-') ?></div>
</div>

<table class="meta" width="100%">
    <tr>
        <td><strong>Total Pegawai</strong></td>
        <td><?= $total_pegawai ?? 0 ?></td>
        <td><strong>Total Laporan (Bulan Ini)</strong></td>
        <td><?= $total_laporan ?? 0 ?></td>
    </tr>
    <tr>
        <td><strong>Total Diterima</strong></td>
        <td><?= $total_approved ?? 0 ?></td>
        <td><strong>Total Ditolak</strong></td>
        <td><?= $total_rejected ?? 0 ?></td>
    </tr>
</table>

<h4 style="margin-top:14px;">Ranking Pegawai</h4>
<table>
    <thead>
        <tr>
            <th style="width:6%">No</th>
            <th>Nama</th>
            <th>Jabatan</th>
            <th style="width:10%">Total</th>
            <th style="width:10%">Diterima</th>
            <th style="width:10%">Ditolak</th>
            <th style="width:10%">Progress</th>
        </tr>
    </thead>
    <tbody>
        <?php if(empty($pegawai)): ?>
            <tr><td colspan="7" class="center small">Tidak ada pegawai di bidang ini.</td></tr>
        <?php else: ?>
            <?php $i=1; foreach($pegawai as $p): ?>
                <tr>
                    <td class="center"><?= $i ?></td>
                    <td><?= esc($p['nama']) ?></td>
                    <td><?= esc($p['jabatan'] ?? '-') ?></td>
                    <td class="center"><?= $p['laporan_total'] ?></td>
                    <td class="center"><?= $p['approved'] ?></td>
                    <td class="center"><?= $p['rejected'] ?></td>
                    <td class="center"><?= $p['progress'] ?>%</td>
                </tr>
            <?php $i++; endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

</body>
</html>
