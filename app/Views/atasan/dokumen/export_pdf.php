<?php
// ================= DATA ATASAN & LOGIC TTD =================
$userModel = new \App\Models\UserModel();
// Mengambil data atasan yang sedang login
$atasan = $userModel->find(session('user_id'));

$namaUser = $atasan['nama'] ?? 'Atasan Unit Kerja';
$ttdUser  = $atasan['ttd_digital'] ?? null;

$ttdBase64 = '';
if (!empty($ttdUser)) {
    $ttdPath = FCPATH . 'uploads/ttd/' . $ttdUser;
    if (file_exists($ttdPath)) {
        $mimeType = mime_content_type($ttdPath);
        $ttdBase64 = 'data:' . $mimeType . ';base64,' . base64_encode(file_get_contents($ttdPath));
    }
}

// ================= LOAD LOGO POLBAN =================
$logoPolbanPath = FCPATH . 'assets/logo/LOGO_POLBAN_4K.png';
$logoBase64 = '';
if (file_exists($logoPolbanPath)) {
    $logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPolbanPath));
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Arsip Dokumen Atasan</title>
    <style>
        body { 
            font-family: "DejaVu Sans", sans-serif; 
            font-size: 11px; 
            color: #000; 
            line-height: 1.4;
        }
        
        /* HEADER / KOP - Disamakan dengan format resmi */
        .kop { 
            text-align: center; 
            margin-bottom: 12px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        .kop img { width: 85px; margin-bottom: 6px; }
        .kop-title { font-size: 14px; font-weight: bold; text-transform: uppercase; }
        .kop-sub { font-size: 12px; }

        /* JUDUL LAPORAN */
        .judul { 
            text-align: center; 
            font-weight: bold; 
            margin: 14px 0 10px; 
            font-size: 13px;
            text-transform: uppercase;
        }

        /* TABLE - Header Abu-abu & Border Hitam */
        table { width: 100%; border-collapse: collapse; margin-top: 8px; }
        th, td { border: 1px solid #000; padding: 6px; }
        th { 
            background: #e9ecef; 
            text-align: center; 
            font-weight: bold;
            text-transform: uppercase;
            font-size: 10px;
        }
        
        .center { text-align: center; }

        /* FOOTER TTD - Rata Kanan */
        .footer { 
            margin-top: 40px; 
            text-align: right; 
            font-size: 11px;
        }
        .ttd-box {
            display: inline-block;
            text-align: center;
            width: 250px;
        }
        .ttd-name { 
            font-weight: bold; 
            text-decoration: underline; 
        }

        /* Page Break Management */
        tr { page-break-inside: avoid; }
    </style>
</head>
<body>

    <div class="kop">
        <?php if ($logoBase64): ?>
            <img src="<?= $logoBase64 ?>">
        <?php endif; ?>
        <div class="kop-title">
            KEMENTERIAN PENDIDIKAN TINGGI, SAINS, DAN TEKNOLOGI
        </div>
        <div class="kop-sub">
            Politeknik Negeri Bandung
        </div>
    </div>

    <div class="judul">
        Laporan Arsip Dokumen Unit Kerja<br>
        Tahun <?= date('Y') ?>
    </div>

    <p>Dicetak pada: <?= date('d/m/Y H:i') ?></p>

    <table>
        <thead>
            <tr>
                <th style="width: 25%;">Judul Dokumen</th>
                <th style="width: 15%;">Pengirim</th>
                <th style="width: 15%;">Jabatan</th>
                <th style="width: 15%;">Unit</th>
                <th style="width: 10%;">Kategori</th>
                <th style="width: 10%;">Status</th>
                <th style="width: 10%;">Tgl Selesai</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($dokumen)): ?>
                <?php foreach ($dokumen as $d): ?>
                <tr>
                    <td><?= esc($d['judul']) ?></td>
                    <td><?= esc($d['nama_pengirim']) ?></td>
                    <td><?= esc($d['nama_jabatan']) ?></td>
                    <td><?= esc($d['nama_unit_asal'] ?? '-') ?></td>
                    <td class="center"><?= esc($d['nama_kategori']) ?></td>
                    <td class="center"><?= ucfirst(esc($d['status'])) ?></td>
                    <td class="center"><?= date('d/m/Y', strtotime($d['updated_at'])) ?></td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" class="center" style="font-style: italic;">Tidak ada data dokumen ditemukan.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="footer">
        <div class="ttd-box">
            Bandung, <?= date('d F Y') ?><br>
            Atasan Unit Kerja,<br><br>
            
            <?php if ($ttdBase64): ?>
                <img src="<?= $ttdBase64 ?>" style="height: 80px;"><br>
            <?php else: ?>
                <div style="height: 80px;"></div> 
            <?php endif; ?>

            <div class="ttd-name"><?= esc($namaUser) ?></div>
        </div>
    </div>

</body>
</html>