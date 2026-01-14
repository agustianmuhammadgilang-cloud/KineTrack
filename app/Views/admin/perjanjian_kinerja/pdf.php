<?php
// ================= LOGIKA DATA & ASSETS =================
$userModel = new \App\Models\UserModel();
$user = $userModel->find(session('user_id'));

$namaUser = $user['nama'] ?? 'Admin/PIC';
$ttdDigital = $user['ttd_digital'] ?? null;

// Load TTD
$ttdBase64 = '';
if (!empty($ttdDigital)) {
    $ttdPath = FCPATH . 'uploads/ttd/' . $ttdDigital;
    if (file_exists($ttdPath)) {
        $mimeType = mime_content_type($ttdPath);
        $ttdBase64 = 'data:' . $mimeType . ';base64,' . base64_encode(file_get_contents($ttdPath));
    }
}

// Load Logo POLBAN
$logoPath = FCPATH . 'assets/logo/LOGO_POLBAN_4K.png';
$logoPolban = '';
if (file_exists($logoPath)) {
    $logoPolban = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Perjanjian Kinerja <?= esc($tahunAktif['tahun']) ?></title>
    <style>
        /* Pengaturan Ukuran Kertas A4 */
        @page {
            size: A4;
            margin: 1.5cm; /* Margin standar laporan */
        }

        body { 
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11px; 
            color: #000;
            line-height: 1.4;
            margin: 0;
            padding: 0;
        }

        /* Kop Surat */
        .kop {
            text-align: center;
            margin-bottom: 12px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        .kop img { width: 85px; margin-bottom: 6px; }
        .kop-title { font-size: 14px; font-weight: bold; text-transform: uppercase; }
        .kop-sub { font-size: 12px; }

        /* Judul */
        .judul {
            text-align: center;
            font-weight: bold;
            margin: 14px 0 10px;
            font-size: 13px;
            text-transform: uppercase;
        }

        /* Tabel PK */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
            table-layout: fixed; /* Menjaga lebar kolom tetap konsisten */
        }
        th, td {
            border: 1px solid #000;
            padding: 6px;
            word-wrap: break-word; /* Memastikan teks panjang tidak merusak tabel */
        }
        th {
            background: #e9ecef;
            text-align: center;
            font-weight: bold;
            font-size: 10px;
        }
        .sasaran-row {
            background: #f5f5f5;
            font-weight: bold;
        }
        .center { text-align: center; }
        .text-left { text-align: left; }

        /* Footer TTD */
        .footer {
            margin-top: 40px;
            width: 100%;
        }
        .ttd-container {
            float: right;
            width: 250px;
            text-align: center;
        }
        .ttd-img { height: 80px; margin: 5px 0; }
        .ttd-name { font-weight: bold; text-decoration: underline; }

        /* Menghindari pemotongan baris tabel di tengah halaman */
        tr { page-break-inside: avoid; }
    </style>
</head>
<body>

<div class="kop">
    <?php if ($logoPolban): ?>
        <img src="<?= $logoPolban ?>">
    <?php endif; ?>
    <div class="kop-title">KEMENTERIAN PENDIDIKAN TINGGI, SAINS, DAN TEKNOLOGI</div>
    <div class="kop-sub">Politeknik Negeri Bandung</div>
</div>

<div class="judul">
    PERJANJIAN KINERJA TAHUN <?= esc($tahunAktif['tahun']) ?>
</div>

<table>
    <thead>
        <tr>
            <th style="width:5%;">No</th>
            <th style="width:40%;">Sasaran Strategis / Indikator Kinerja</th>
            <th style="width:10%;">Satuan</th>
            <th style="width:10%;">Target PK</th>
            <th style="width:8%;">TW1</th>
            <th style="width:8%;">TW2</th>
            <th style="width:8%;">TW3</th>
            <th style="width:8%;">TW4</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; foreach ($sasaran as $s): 
            $indikatorSasaran = array_filter($indikator, fn($i) => $i['sasaran_id'] == $s['id']);
        ?>
            <tr class="sasaran-row">
                <td class="center"><?= $no++ ?></td>
                <td colspan="7" class="text-left"><?= esc($s['nama_sasaran']) ?></td>
            </tr>

            <?php if (count($indikatorSasaran) > 0): ?>
                <?php foreach ($indikatorSasaran as $i): ?>
                    <tr>
                        <td class="center"></td>
                        <td class="text-left"><?= esc($i['nama_indikator']) ?></td>
                        <td class="center"><?= esc($i['satuan']) ?></td>
                        <td class="center"><b><?= esc($i['target_pk']) ?></b></td>
                        <td class="center"><?= esc($i['target_tw1']) ?></td>
                        <td class="center"><?= esc($i['target_tw2']) ?></td>
                        <td class="center"><?= esc($i['target_tw3']) ?></td>
                        <td class="center"><?= esc($i['target_tw4']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td></td>
                    <td colspan="7" class="center" style="color:#999; font-style:italic;">Belum ada indikator kinerja</td>
                </tr>
            <?php endif; ?>

        <?php endforeach; ?>
    </tbody>
</table>

<div class="footer">
    <div class="ttd-container">
        <p>Bandung, <?= date('d F Y') ?></p>
        <p>Pihak yang menetapkan,</p>
        
        <?php if ($ttdBase64): ?>
            <img src="<?= $ttdBase64 ?>" class="ttd-img"><br>
        <?php else: ?>
            <div style="height:80px;"></div> 
        <?php endif; ?>

        <div class="ttd-name"><?= esc($namaUser) ?></div>
        <p style="margin-top: 2px;">Politeknik Negeri Bandung</p>
    </div>
</div>

</body>
</html>