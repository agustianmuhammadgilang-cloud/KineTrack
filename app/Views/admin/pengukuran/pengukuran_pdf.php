<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pengukuran <?= esc($data['id']) ?></title>
    <style>
        body {
            font-family: "Arial", sans-serif;
            font-size: 13px;
            color: #1f2937; /* teks abu gelap */
            margin: 20px;
        }

        h1, h2 {
            color: #1E40AF; /* Polban blue */
        }

        h1 {
            font-size: 20px;
            margin-bottom: 5px;
        }

        h2 {
            font-size: 16px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #d1d5db; /* abu terang */
            padding: 8px 10px;
            text-align: left;
            vertical-align: top;
        }

        th {
            background-color: #1E40AF; /* Polban blue */
            color: white;
            font-weight: bold;
        }

        .section-title {
            background-color: #e0e7ff; /* light blue */
            font-weight: bold;
            padding: 5px 10px;
            margin-top: 15px;
        }

        .small {
            font-size: 11px;
            color: #6b7280; /* teks abu */
        }
    </style>
</head>
<body>

<h1>Detail Pengukuran</h1>
<h2>Indikator: <?= esc($data['nama_indikator']) ?></h2>

<p class="small">ID Pengukuran: <?= esc($data['id']) ?> | Tahun: <?= esc($data['tahun_id']) ?> | Triwulan: <?= esc($data['triwulan']) ?></p>
<p class="small">Staff: <?= esc($data['user_nama'] ?? '-') ?></p>

<table>
    <tr>
        <th>Realisasi</th>
        <td><?= esc($data['realisasi']) ?></td>
    </tr>
    <tr>
        <th>Progress / Kegiatan</th>
        <td><?= esc($data['progress'] ?: '-') ?></td>
    </tr>
    <tr>
        <th>Kendala</th>
        <td><?= esc($data['kendala'] ?: '-') ?></td>
    </tr>
    <tr>
        <th>Strategi / Tindak Lanjut</th>
        <td><?= esc($data['strategi'] ?: '-') ?></td>
    </tr>
    <tr>
        <th>File Dukung</th>
        <td>
            <?php if (!empty($data['file_dukung'])): ?>
                <?= esc($data['file_dukung']) ?>
            <?php else: ?>
                -
            <?php endif; ?>
        </td>
    </tr>
    <tr>
        <th>Tanggal Input</th>
        <td><?= esc($data['created_at']) ?></td>
    </tr>
    <tr>
        <th>Terakhir Update</th>
        <td><?= esc($data['updated_at'] ?: '-') ?></td>
    </tr>
</table>

<p class="small">Laporan ini dihasilkan oleh sistem Polban</p>

</body>
</html>