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
        $mimeType = mime_content_type($ttdPath);
        $ttdBase64 = 'data:' . $mimeType . ';base64,' . base64_encode(file_get_contents($ttdPath));
    }
}

// ================= LOAD LOGO POLBAN =================
$logoPath = FCPATH . 'assets/logo/LOGO_POLBAN_4K.png';
$logoPolban = '';
if (file_exists($logoPath)) {
    $logoPolban = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
    body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #000; }
    .kop { text-align: center; margin-bottom: 12px; }
    .kop img { width: 85px; margin-bottom: 6px; }
    .kop-title { font-size: 14px; font-weight: bold; }
    .kop-sub { font-size: 12px; }
    .judul { text-align: center; font-weight: bold; margin: 14px 0 10px; font-size: 13px; }
    table { width: 100%; border-collapse: collapse; margin-top: 8px; }
    th, td { border: 1px solid #000; padding: 6px; vertical-align: top; }
    th { background: #e9ecef; text-align: left; }
    .label { width: 180px; font-weight: bold; }
    .footer { margin-top: 40px; text-align: right; font-size: 11px; }
    .ttd-name { font-weight: bold; text-decoration: underline; }
</style>
</head>
<body>

<!-- ================= KOP ================= -->
<div class="kop">
    <img src="<?= $logoPolban ?>">
    <div class="kop-title">KEMENTERIAN PENDIDIKAN TINGGI, SAINS, DAN TEKNOLOGI</div>
    <div class="kop-sub">Politeknik Negeri Bandung</div>
</div>

<!-- ================= JUDUL ================= -->
<div class="judul">
    Laporan Pengukuran Triwulan <?= esc($tw) ?><br>
    Politeknik Negeri Bandung
</div>

<table>
    <tr>
        <th class="label">Nama Indikator</th>
        <td><?= esc($indikator['nama_indikator']) ?></td>
    </tr>
    <tr>
        <th>Satuan</th>
        <td><?= esc($indikator['satuan']) ?></td>
    </tr>
    <tr>
        <th>Target TW <?= esc($tw) ?></th>
        <td><?= esc($target) ?></td>
    </tr>
    <tr>
        <th>Realisasi</th>
        <td><?= esc($measure['realisasi']) ?></td>
    </tr>
</table>

<br>
<b>A. Uraian Kegiatan</b>
<table>
    <tr><td><?= $measure['progress'] ? nl2br(esc($measure['progress'])) : '-' ?></td></tr>
</table>

<b>B. Kendala / Permasalahan</b>
<table>
    <tr><td><?= $measure['kendala'] ? nl2br(esc($measure['kendala'])) : '-' ?></td></tr>
</table>

<b>C. Strategi / Tindak Lanjut</b>
<table>
    <tr><td><?= $measure['strategi'] ? nl2br(esc($measure['strategi'])) : '-' ?></td></tr>
</table>

<b>D. File Pendukung</b>
<table>
    <tr><td>
        <?php $files = json_decode($measure['file_dukung'], true); ?>
        <?php if (empty($files)): ?>
            Tidak ada file pendukung.
        <?php else: ?>
            <ul style="margin:0; padding-left:15px;">
                <?php foreach ($files as $file): ?>
                    <li><?= esc($file) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </td></tr>
</table>

<!-- ================= TTD ================= -->
<div class="footer">
    Bandung, <?= date('d F Y') ?><br>
    PIC Pengukuran<br><br>
    <?php if ($ttdBase64): ?><img src="<?= $ttdBase64 ?>" style="height:80px;"><br><?php endif; ?>
    <span class="ttd-name"><?= esc($namaPic) ?></span>
</div>

</body>
</html>