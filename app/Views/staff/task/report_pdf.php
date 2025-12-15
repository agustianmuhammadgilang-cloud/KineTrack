<?php
// ================= DATA PIC =================
$userModel = new \App\Models\UserModel();
$user = $userModel->find(session('user_id'));

$namaPic    = $user['nama'] ?? 'PIC';
$ttdDigital = $user['ttd_digital'] ?? null;

// ================= LOAD TTD AS BASE64 =================
$ttdBase64 = '';

if (!empty($ttdDigital)) {
    $ttdPath = FCPATH . 'uploads/ttd/' . $ttdDigital;

    if (file_exists($ttdPath)) {
        $mimeType = mime_content_type($ttdPath); // image/png, image/jpeg
        $ttdBase64 = 'data:' . $mimeType . ';base64,' . base64_encode(
            file_get_contents($ttdPath)
        );
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pengukuran TW <?= esc($tw) ?></title>

    <style>
        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 12px;
            margin: 30px;
            color: #333;
            line-height: 1.6;
        }
        .title {
            font-size: 18px;
            font-weight: bold;
            color: #004e9f;
            margin-bottom: 4px;
        }
        .subtitle {
            font-size: 12px;
            color: #555;
            margin-bottom: 20px;
        }
        .section {
            margin-top: 20px;
        }
        .section h3 {
            font-size: 14px;
            color: #004e9f;
            margin-bottom: 8px;
            border-bottom: 1px solid #004e9f;
            padding-bottom: 3px;
        }
        .item { margin-bottom: 6px; }
        .label {
            font-weight: bold;
            display: inline-block;
            width: 160px;
        }
        .box {
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 6px;
            margin-top: 6px;
            background: #fafafa;
        }
        ul { margin-top: 6px; padding-left: 18px; }
        .note {
            font-size: 11px;
            color: #666;
            margin-top: 30px;
        }
        .ttd {
            margin-top: 60px;
            text-align: right;
        }
        .ttd-name {
            font-weight: bold;
            text-decoration: underline;
            margin-top: 4px;
        }
    </style>
</head>

<body>

<div class="title">LAPORAN PENGUKURAN KINERJA</div>
<div class="subtitle">
    Triwulan <?= esc($tw) ?><br>
    Sistem eKinerja Politeknik Negeri Bandung
</div>

<div class="section">
    <h3>Informasi Indikator</h3>
    <div class="item"><span class="label">Nama Indikator</span>: <?= esc($indikator['nama_indikator']) ?></div>
    <div class="item"><span class="label">Satuan</span>: <?= esc($indikator['satuan']) ?></div>
    <div class="item"><span class="label">Target TW <?= esc($tw) ?></span>: <?= esc($target) ?></div>
    <div class="item"><span class="label">Realisasi</span>: <?= esc($measure['realisasi']) ?></div>
</div>

<div class="section">
    <h3>Uraian Kegiatan</h3>
    <div class="box"><?= $measure['progress'] ? nl2br(esc($measure['progress'])) : '-' ?></div>
</div>

<div class="section">
    <h3>Kendala / Permasalahan</h3>
    <div class="box"><?= $measure['kendala'] ? nl2br(esc($measure['kendala'])) : '-' ?></div>
</div>

<div class="section">
    <h3>Strategi / Tindak Lanjut</h3>
    <div class="box"><?= $measure['strategi'] ? nl2br(esc($measure['strategi'])) : '-' ?></div>
</div>

<div class="section">
    <h3>File Pendukung</h3>
    <?php $files = json_decode($measure['file_dukung'], true); ?>
    <div class="box">
        <?php if (empty($files)): ?>
            Tidak ada file pendukung.
        <?php else: ?>
            <ul>
                <?php foreach ($files as $file): ?>
                    <li><?= esc($file) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</div>

<!-- ================= TTD ================= -->
<div class="ttd">
    Bandung, <?= date('d F Y') ?><br>
    PIC Pengukuran,<br><br>

    <?php if ($ttdBase64): ?>
    <img src="<?= $ttdBase64 ?>" style="height:80px;"><br>
<?php endif; ?>


    <div class="ttd-name"><?= esc($namaPic) ?></div>
</div>

<div class="note">
    Dokumen ini dihasilkan secara otomatis oleh Sistem eKinerja POLBAN.
</div>

</body>
</html>
