<?php
// ========================
//  LOAD LOGO AS BASE64
// ========================

// Path file logo di server (boleh di luar public)
$logoPolbanPath = FCPATH . 'assets/logo/LOGO_POLBAN_4K.png';
$logoRightPath  = FCPATH . 'assets/logo/image.png';

// Convert ke base64
$logoPolban = '';
$logoRight  = '';

if (file_exists($logoPolbanPath)) {
    $logoPolban = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPolbanPath));
}

if (file_exists($logoRightPath)) {
    $logoRight = 'data:image/png;base64,' . base64_encode(file_get_contents($logoRightPath));
}
?>

<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif; 
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 14px;
        }
        table, th, td {
            border: 1px solid #444;
        }
        th {
            background: #0b5ed7;
            color: white;
            padding: 6px;
            text-align: center;
            font-size: 12px;
        }
        td {
            padding: 6px;
            vertical-align: top;
        }

        .kop-table td {
            border: none;
        }

        .title {
            margin-top: 4px;
            text-align: center;
            font-weight: bold;
            font-size: 16px;
        }
        .subtitle {
            text-align: center;
            margin-bottom: 10px;
            font-size: 13px;
        }
        .footer {
            margin-top: 40px;
            width: 100%;
            text-align: right;
            font-size: 12px;
        }
    </style>
</head>
<body>

<!-- ========================== -->
<!--  KOP RESMI POLITEKNIK     -->
<!-- ========================== -->

<table class="kop-table">
    <tr>
        <!-- LOGO POLBAN -->
        <td style="width: 20%; text-align: left;">
            <img src="<?= $logoPolban ?>" width="90">
        </td>

        <!-- TEXT KOP -->
        <td style="width: 60%; text-align: center;">
            <div style="font-size: 18px; font-weight: bold;">POLITEKNIK NEGERI BANDUNG</div>
            <div style="font-size: 14px;">KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET, DAN TEKNOLOGI</div>
            <div style="margin-top: 5px; font-size: 12px;">
                Jl. Gegerkalong Hilir, Ciwaruga – Bandung 40559 • Telp. (022) 2013789
            </div>
        </td>

        <!-- LOGO KANAN -->
        <td style="width: 20%; text-align: right;">
            <img src="<?= $logoRight ?>" width="90">
        </td>
    </tr>
</table>

<hr style="margin-top: -4px; border: 1px solid #000;"><br>

<!-- ========================== -->
<!--  TITLE LAPORAN             -->
<!-- ========================== -->

<div class="title">LAPORAN PENGUKURAN KINERJA</div>
<div class="subtitle">Triwulan <?= $tw ?> – Tahun <?= $tahun ?></div>

<!-- ========================== -->
<!--  TABEL PENGUKURAN          -->
<!-- ========================== -->

<table>
    <thead>
        <tr>
            <th>Sasaran</th>
            <th>Indikator</th>
            <th>PIC</th>
            <th>Target<br>TW <?= $tw ?></th>
            <th>Realisasi</th>
            <th>Progress</th>
            <th>Kendala</th>
            <th>Strategi / Tindak Lanjut</th>
            <th>File Pendukung</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($data as $row): ?>
        <?php 
            $target = $row["target_tw$tw"]; 
        ?>
        <tr>
            <td><?= esc($row['nama_sasaran']) ?></td>
            <td><?= esc($row['nama_indikator']) ?></td>
            <td><?= esc($row['pic']) ?></td>
            <td style="text-align:center;"><?= esc($target) ?></td>
            <td style="text-align:center;"><?= esc($row['realisasi']) ?></td>
            <td><?= esc($row['progress']) ?></td>
            <td><?= esc($row['kendala']) ?></td>
            <td><?= esc($row['strategi']) ?></td>
            <td>
                <?= $row['file_dukung'] ? esc($row['file_dukung']) : '-' ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- FOOTER -->
<div class="footer">
    Bandung, <?= date('d F Y') ?><br>
    <b>Direktorat Politeknik Negeri Bandung</b>
</div>

</body>
</html>
