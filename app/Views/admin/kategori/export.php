<?php
// ================= DATA ADMIN & LOGIC TTD =================
$userModel = new \App\Models\UserModel();
$admin = $userModel->find(session('user_id'));

$namaAdmin = $admin['nama'] ?? 'Administrator Sistem';
$ttdAdmin  = $admin['ttd_digital'] ?? null;

$ttdBase64 = '';
if (!empty($ttdAdmin)) {
    $ttdPath = FCPATH . 'uploads/ttd/' . $ttdAdmin;
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
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Laporan Dokumen Kinerja</title>
    <style>
        /* Pengaturan Ukuran Kertas */
        @page {
            size: A4;
            margin: 1.5cm;
        }

        body { 
            font-family: 'DejaVu Sans', sans-serif; 
            font-size: 11px; 
            color: #000; /* Warna teks utama hitam */
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

        /* Judul Laporan */
        .judul {
            text-align: center;
            font-weight: bold;
            font-size: 13px;
            margin: 20px 0;
            text-transform: uppercase;
        }

        /* Group Status */
        .status-section {
            margin-top: 20px;
        }

        .status-header {
            background-color: #f5f5f5; /* Abu-abu muda */
            border: 1px solid #000;
            padding: 8px;
            font-weight: bold;
            text-transform: uppercase;
            color: #000; /* Memastikan warna teks Status (Resmi, dll) adalah HITAM */
        }

        /* Kategori Title */
        .kategori-title {
            font-weight: bold;
            margin: 15px 0 5px 0;
            padding-left: 5px;
            color: #000;
        }

        /* Tabel Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px;
            color: #000;
        }
        th {
            background-color: #e9ecef; /* Abu-abu header tabel */
            text-align: center;
            font-weight: bold;
        }
        .center { text-align: center; }
        
        /* Footer Tanda Tangan */
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

        tr { page-break-inside: avoid; }
    </style>
</head>
<body>

<div class="kop">
    <?php if ($logoBase64): ?>
        <img src="<?= $logoBase64 ?>">
    <?php endif; ?>
    <div class="kop-title">POLITEKNIK NEGERI BANDUNG</div>
    <div class="kop-sub">LAPORAN REKAPITULASI DOKUMEN KINERJA</div>
</div>

<div class="judul">DAFTAR DOKUMEN PER KATEGORI</div>

<p style="font-size: 9px; color: #000;">Dicetak pada: <?= date('d F Y, H:i') ?></p>

<?php
$mapKategoriStatus = [
    'resmi'   => 'aktif',
    'pending' => 'pending',
    'reject'  => 'rejected',
];
?>

<?php foreach ($statusMap as $statusKey => $statusTitle): ?>
    
    <div class="status-section">
        <div class="status-header">STATUS: <?= esc($statusTitle) ?></div>

        <?php foreach ($kategoriList as $kat): ?>
            <?php if ($kat['status'] !== $mapKategoriStatus[$statusKey]) continue; ?>

            <?php
                $dokumenList = $dokumenModel
                    ->where('kategori_id', $kat['id'])
                    ->findAll();
            ?>

            <?php if (!empty($dokumenList)): ?>
                <div class="kategori-title">Kategori: <?= esc($kat['nama_kategori']) ?></div>

                <table>
                    <thead>
                        <tr>
                            <th style="width: 5%;">No</th>
                            <th style="width: 95%;">Judul Dokumen</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($dokumenList as $dok): ?>
                            <tr>
                                <td class="center"><?= $no++ ?></td>
                                <td><?= esc($dok['judul']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>

        <?php endforeach; ?>
    </div>
<?php endforeach; ?>

<div class="footer">
    <div class="ttd-container">
        <p>Bandung, <?= date('d F Y') ?></p>
        <p>Administrator Sistem,</p>
        
        <?php if ($ttdBase64): ?>
            <img src="<?= $ttdBase64 ?>" class="ttd-img"><br>
        <?php else: ?>
            <div style="height: 80px;"></div> 
        <?php endif; ?>

        <div class="ttd-name"><?= esc($namaAdmin) ?></div>
        <p style="margin-top: 2px;">NIP. .................................</p>
    </div>
</div>

</body>
</html>