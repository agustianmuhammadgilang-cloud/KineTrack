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
    <title>Laporan Data User</title>
    <style>
        body {
            font-family: "DejaVu Sans", sans-serif; /* Mengikuti style laporan pertama */
            font-size: 11px;
            color: #000;
            line-height: 1.4;
            margin: 0;
            padding: 0;
        }

        /* HEADER / KOP LAPORAN */
        .kop {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000; /* Garis pemisah kop */
            padding-bottom: 10px;
        }
        
        .kop img {
            width: 80px;
            margin-bottom: 8px;
        }

        .kop-title {
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .kop-sub {
            font-size: 12px;
            margin-top: 2px;
        }

        /* JUDUL LAPORAN */
        .judul {
            text-align: center;
            font-weight: bold;
            font-size: 13px;
            margin: 20px 0;
            text-transform: uppercase;
        }

        /* UNIT SECTION */
        .unit-container {
            margin-bottom: 30px;
        }

        .unit-header {
            background-color: #f5f5f5; /* Warna sasaran di laporan 1 */
            border: 1px solid #000;
            padding: 8px;
            font-weight: bold;
            font-size: 11px;
        }

        /* TABLE STYLE (DISAMAKAN DENGAN LAPORAN 1) */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: -1px; /* Menempel dengan unit-header */
        }

        th, td {
            border: 1px solid #000;
            padding: 6px;
            vertical-align: middle;
        }

        th {
            background: #e9ecef; /* Abu-abu header tabel */
            text-align: center;
            font-weight: bold;
        }

        .center {
            text-align: center;
        }

        /* FOOTER / TTD */
        .footer {
            margin-top: 40px;
            width: 100%;
        }

        .ttd-container {
            float: right;
            width: 250px;
            text-align: center;
        }

        .ttd-img {
            height: 70px;
            margin: 5px 0;
        }

        .ttd-name {
            font-weight: bold;
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="kop">
    <?php if ($logoBase64): ?>
        <img src="<?= $logoBase64 ?>">
    <?php endif; ?>
    <div class="kop-title">Politeknik Negeri Bandung</div>
    <div class="kop-sub">Laporan Data Pengguna Sistem Kinetrack</div>
    <p style="font-size: 9px; margin: 5px 0 0 0;">Dicetak pada: <?= date('d F Y, H:i') ?></p>
</div>

<div class="judul">
    DAFTAR PENGGUNA BERDASARKAN UNIT KERJA
</div>

<?php foreach ($groupedUsers as $unitName => $users): ?>

    <div class="unit-container">
        <div class="unit-header">
            Unit Kerja: <?= esc($unitName) ?>
        </div>

        <?php
        $atasan = [];
        $staff  = [];
        foreach ($users as $u) {
            if ($u['role'] === 'atasan') { $atasan[] = $u; } 
            else { $staff[] = $u; }
        }
        ?>

        <table>
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 25%;">Nama Lengkap</th>
                    <th style="width: 30%;">Jabatan</th>
                    <th style="width: 25%;">Email</th>
                    <th style="width: 15%;">Peran</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>

                <?php foreach ($atasan as $a): ?>
                    <tr>
                        <td class="center"><?= $no++ ?></td>
                        <td><b><?= esc($a['nama']) ?></b></td>
                        <td><?= esc($a['nama_jabatan']) ?></td>
                        <td><?= esc($a['email']) ?></td>
                        <td class="center"><b>Atasan</b></td>
                    </tr>
                <?php endforeach; ?>

                <?php foreach ($staff as $s): ?>
                    <tr>
                        <td class="center"><?= $no++ ?></td>
                        <td><?= esc($s['nama']) ?></td>
                        <td><?= esc($s['nama_jabatan']) ?></td>
                        <td><?= esc($s['email']) ?></td>
                        <td class="center">Staff</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

<?php endforeach; ?>

<div class="footer">
    <div class="ttd-container">
        <p>Bandung, <?= date('d F Y') ?></p>
        <p>Mengetahui,<br>Admin Sistem</p>
        
        <?php if ($ttdBase64): ?>
            <img src="<?= $ttdBase64 ?>" class="ttd-img"><br>
        <?php else: ?>
            <div style="height: 75px;"></div> 
        <?php endif; ?>

        <div class="ttd-name"><?= esc($namaAdmin) ?></div>
        <p style="margin-top: 2px;">e-Kinerja Politeknik Negeri Bandung</p>
    </div>
</div>

</body>
</html>