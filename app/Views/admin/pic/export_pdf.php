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
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan PIC Indikator Kinerja</title>
    <style>
        body { font-family: "Times New Roman", serif; font-size: 12px; color: #000; }
        .header { text-align: center; border-bottom: 3px solid #0f2a44; padding-bottom: 10px; margin-bottom: 20px; }
        .header img { width: 70px; margin-bottom: 5px; } /* Style Logo */
        .header h2 { margin:0; font-size:16px; text-transform:uppercase; }
        .header h3 { margin:4px 0; font-size:14px; font-weight:normal; }
        .header p { font-size:11px; margin:0; }

        table { width:100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border:1px solid #333; padding:6px 8px; font-size:11px; }
        th { background-color: #e5e7eb; text-align:left; }
        .text-center { text-align:center; }

        .role-pic { font-weight: bold; color: #003366; }

        .footer { margin-top: 40px; font-size:11px; }
        .ttd { width:40%; float:right; text-align:center; }
        .ttd-img { height: 70px; margin: 5px 0; } /* Style TTD */
    </style>
</head>
<body>

<div class="header">
    <?php if ($logoBase64): ?>
        <img src="<?= $logoBase64 ?>"><br>
    <?php endif; ?>
    <h2>Politeknik Negeri Bandung</h2>
    <h3>Laporan PIC Indikator Kinerja</h3>
    <p>Dicetak pada: <?= date('d F Y') ?></p>
</div>

<table>
    <thead>
        <tr>
            <th>Informasi Indikator</th>
            <th>Penanggung Jawab (PIC)</th>
            <th>Bidang / Jabatan</th>
            <th class="text-center">Tahun</th>
        </tr>
    </thead>
    <tbody>
        <?php if(!empty($pic_list)): ?>
            <?php foreach($pic_list as $p): ?>
                <tr>
                    <td>
                        <strong><?= esc($p['nama_indikator']) ?></strong><br>
                        <span style="font-size:9px; color:#555;">ID: #<?= esc($p['id']) ?></span>
                    </td>
                    <td class="role-pic"><?= esc($p['nama_pic']) ?></td>
                    <td>
                        <?= esc($p['nama_bidang']) ?><br>
                        <span style="font-size:9px; color:#555;"><?= esc($p['nama_jabatan']) ?></span>
                    </td>
                    <td class="text-center"><?= esc($p['tahun']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4" class="text-center" style="padding:15px; font-style:italic; color:#888;">
                    Data PIC tidak ditemukan
                </td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<div class="footer">
    <div class="ttd">
        <p>Bandung, <?= date('d F Y') ?></p>
        <p>Mengetahui,</p>
        
        <?php if ($ttdBase64): ?>
            <img src="<?= $ttdBase64 ?>" class="ttd-img"><br>
        <?php else: ?>
            <br><br><br>
        <?php endif; ?>

        <p><strong><?= esc($namaAdmin) ?></strong></p>
        <p style="margin-top: -10px;">Administrator Sistem</p>
    </div>
</div>

</body>
</html>