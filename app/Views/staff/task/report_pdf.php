<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pengukuran TW <?= esc($tw) ?></title>

    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
            color: #333;
        }

        h2 {
            color: #004e9f;
            margin-bottom: 5px;
        }

        h3 {
            color: #004e9f;
            margin-top: 30px;
            margin-bottom: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        th {
            background: #004e9f;
            color: white;
            padding: 8px;
            text-align: left;
            font-size: 12px;
        }

        td {
            padding: 8px;
            border: 1px solid #ddd;
            font-size: 12px;
        }

        .section-box {
            border: 1px solid #004e9f;
            padding: 12px;
            border-radius: 6px;
            margin-top: 10px;
        }

        .small-text {
            font-size: 11px;
            color: #444;
        }

        .file-item {
            margin-bottom: 4px;
        }
    </style>
</head>

<body>

    <!-- HEADER -->
    <h2>Laporan Pengukuran Kinerja — TW <?= esc($tw) ?></h2>
    <p class="small-text">Sistem eKinerja POLBAN</p>

    <!-- INFORMASI INDIKATOR -->
    <h3>Informasi Indikator</h3>
    <table>
        <tr>
            <th>Nama Indikator</th>
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
        <tr>
            <th>Satuan Baru (Progress)</th>
            <td>
                <?php 
                    $percent = ($target > 0) ? ($measure['realisasi'] / $target) * 100 : 0;
                    echo round($percent) . "%";
                ?>

                <!-- Tambahkan nilai lebih -->
                <?php if ($measure['realisasi'] > $target): ?>
                    <br><span style="color:green;">(+<?= esc($measure['realisasi'] - $target) ?> Nilai Tambah)</span>
                <?php endif; ?>
            </td>
        </tr>
    </table>

    <!-- DETAIL PROGRESS -->
    <h3>Detail Kegiatan</h3>

    <div class="section-box">
        <strong>Progress / Kegiatan:</strong><br>
        <span><?= nl2br(esc($measure['progress'])) ?: '-' ?></span>
    </div>

    <div class="section-box">
        <strong>Kendala / Permasalahan:</strong><br>
        <span><?= nl2br(esc($measure['kendala'])) ?: '-' ?></span>
    </div>

    <div class="section-box">
        <strong>Strategi / Tindak Lanjut:</strong><br>
        <span><?= nl2br(esc($measure['strategi'])) ?: '-' ?></span>
    </div>

    <!-- FILE DUKUNG -->
    <h3>File Dukung</h3>

    <?php $files = json_decode($measure['file_dukung'], true); ?>

    <?php if (empty($files)): ?>
        <p class="small-text">Tidak ada file dukung yang diunggah.</p>
    <?php else: ?>
        <ul>
            <?php foreach ($files as $file): ?>
                <li class="file-item">
                    <?= esc($file) ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>


</body>
</html>
