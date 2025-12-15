<?php
// ================= DATA ADMIN =================
$userModel = new \App\Models\UserModel();
$admin = $userModel->find(session('user_id'));

$namaAdmin = $admin['nama'] ?? 'Admin';
$ttdAdmin  = $admin['ttd_digital'] ?? null;

// ================= LOAD TTD ADMIN AS BASE64 =================
$ttdBase64 = '';

if (!empty($ttdAdmin)) {
    $ttdPath = FCPATH . 'uploads/ttd/' . $ttdAdmin;

    if (file_exists($ttdPath)) {
        $mimeType = mime_content_type($ttdPath);
        $ttdBase64 = 'data:' . $mimeType . ';base64,' . base64_encode(
            file_get_contents($ttdPath)
        );
    }
}

// ================= LOAD LOGO AS BASE64 =================
$logoPolbanPath = FCPATH . 'assets/logo/LOGO_POLBAN_4K.png';
$logoPolban = '';

if (file_exists($logoPolbanPath)) {
    $logoPolban = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPolbanPath));
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #000;
        }
        .kop {
            text-align: center;
            margin-bottom: 12px;
        }
        .kop img {
            width: 85px;
            margin-bottom: 6px;
        }
        .kop-title {
            font-size: 14px;
            font-weight: bold;
        }
        .kop-sub {
            font-size: 12px;
        }
        .judul {
            text-align: center;
            font-weight: bold;
            margin: 14px 0 10px;
            font-size: 13px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px;
        }
        th {
            background: #e9ecef;
            text-align: center;
        }
        .sasaran {
            font-weight: bold;
            background: #f5f5f5;
        }
        .center {
            text-align: center;
        }
        .footer {
            margin-top: 40px;
            text-align: right;
            font-size: 11px;
        }
        .ttd-name {
            font-weight: bold;
            text-decoration: underline;
        }
    </style>
</head>
<body>

<!-- ================= KOP ================= -->
<div class="kop">
    <img src="<?= $logoPolban ?>">
    <div class="kop-title">
        KEMENTERIAN PENDIDIKAN TINGGI, SAINS, DAN TEKNOLOGI
    </div>
    <div class="kop-sub">
        Politeknik Negeri Bandung
    </div>
</div>

<!-- ================= JUDUL ================= -->
<div class="judul">
    Laporan Kinerja Triwulan <?= esc($tw) ?><br>
    Politeknik Negeri Bandung<br>
    Tahun <?= esc($tahun) ?>
</div>

<p>
    Berikut ini kami sampaikan hasil capaian kinerja pada Politeknik Negeri Bandung
    selama Triwulan <?= esc($tw) ?> tahun <?= esc($tahun) ?>.
</p>

<p><b>A. Progress Capaian Kinerja</b></p>

<!-- ================= TABEL ================= -->
<table>
    <thead>
        <tr>
            <th style="width:32%">Sasaran / Indikator</th>
            <th style="width:12%">PIC</th>
            <th style="width:10%">Target PK</th>
            <th style="width:10%">Satuan</th>
            <th style="width:18%">TW <?= esc($tw) ?><br>Target</th>
            <th style="width:18%">TW <?= esc($tw) ?><br>Realisasi</th>
        </tr>
    </thead>
    <tbody>

    <?php
    $currentSasaran = null;
    foreach ($data as $row):
        if ($currentSasaran !== $row['nama_sasaran']):
            $currentSasaran = $row['nama_sasaran'];
    ?>
        <tr>
            <td class="sasaran" colspan="6"><?= esc($currentSasaran) ?></td>
        </tr>
    <?php endif; ?>

        <tr>
            <td><?= esc($row['nama_indikator']) ?></td>
            <td class="center"><?= esc($row['pic'] ?? '-') ?></td>
            <td class="center"><?= esc($row['target_pk']) ?></td>
            <td class="center"><?= esc($row['satuan']) ?></td>
            <td class="center"><?= esc($row["target_tw$tw"]) ?></td>
            <td class="center"><?= esc($row['realisasi'] ?? 0) ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<!-- ================= FOOTER + TTD ADMIN ================= -->
<div class="footer">
    Bandung, <?= date('d F Y') ?><br>
    Admin Sistem e-Kinerja<br><br>

    <?php if ($ttdBase64): ?>
        <img src="<?= $ttdBase64 ?>" style="height:80px;"><br>
    <?php endif; ?>

    <div class="ttd-name"><?= esc($namaAdmin) ?></div>
    Admin e-Kinerja Politeknik Negeri Bandung
</div>
<!-- ================= B. ANALISIS HASIL CAPAIAN KINERJA ================= -->
<p style="margin-top:25px;"><b>B. Analisis Hasil Capaian Kinerja</b></p>

<?php
$currentSasaranB   = null;
$currentIndikator  = null;
?>

<?php foreach ($data as $row): ?>

    <!-- SASARAN -->
    <?php if ($currentSasaranB !== $row['nama_sasaran']): 
        $currentSasaranB = $row['nama_sasaran'];
    ?>
        <div style="margin-top:18px; font-weight:bold;">
            <?= esc($currentSasaranB) ?>
        </div>
    <?php endif; ?>

    <!-- INDIKATOR -->
    <?php if ($currentIndikator !== $row['nama_indikator']):
        $currentIndikator = $row['nama_indikator'];
    ?>
        <div style="margin-top:10px; font-weight:bold;">
            <?= esc($row['nama_indikator']) ?>
        </div>
    <?php endif; ?>

    <!-- INFO PIC -->
    <table style="margin-top:6px;">
        <tr>
            <td style="width:20%; font-weight:bold;">PIC</td>
            <td><?= esc($row['pic'] ?? '-') ?></td>
        </tr>
    </table>

    <!-- PROGRESS -->
    <div style="margin-top:6px;">
        <b>Progress / Kegiatan</b><br>
        <?= !empty($row['progress']) ? nl2br(esc($row['progress'])) : '-' ?>
    </div>

    <!-- KENDALA -->
    <div style="margin-top:6px;">
        <b>Kendala / Permasalahan</b><br>
        <?= !empty($row['kendala']) ? nl2br(esc($row['kendala'])) : '-' ?>
    </div>

    <!-- STRATEGI -->
    <div style="margin-top:6px;">
        <b>Strategi / Tindak Lanjut</b><br>
        <?= !empty($row['strategi']) ? nl2br(esc($row['strategi'])) : '-' ?>
    </div>

    <!-- FILE DUKUNG -->
    <div style="margin-top:6px;">
        <b>File Pendukung</b><br>
        <?php
        $files = json_decode($row['file_dukung'] ?? '[]', true);
        ?>
        <?php if (empty($files)): ?>
            -
        <?php else: ?>
            <ul style="margin:4px 0 0 15px;">
                <?php foreach ($files as $f): ?>
                    <li><?= esc($f) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>

<?php endforeach; ?>

</body>
</html>
