<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?= esc($judul) ?></title>
    <style>
        body {
            font-family: "Times New Roman", serif;
            font-size: 12px;
            color: #000;
            line-height: 1.5;
        }

        /* HEADER LAPORAN */
        .header {
            text-align: center;
            border-bottom: 3px solid #0f2a44;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .header h2 {
            margin: 0;
            font-size: 16px;
            text-transform: uppercase;
        }

        .header h3 {
            margin: 4px 0;
            font-size: 14px;
            font-weight: normal;
        }

        .header p {
            font-size: 11px;
            margin: 0;
        }

        /* KATEGORI */
        .kategori {
            margin-bottom: 24px;
            page-break-inside: avoid;
        }

        .kategori-title {
            background-color: #1D2F83;
            color: #fff;
            padding: 6px 10px;
            font-weight: bold;
            font-size: 12px;
            text-transform: uppercase;
        }

        /* TABLE DOKUMEN */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }

        th, td {
            border: 1px solid #333;
            padding: 6px 8px;
            font-size: 11px;
        }

        th {
            background-color: #e5e7eb;
            text-align: left;
        }

        .status-pending {
            color: #b45309;
            font-weight: bold;
        }

        .status-ditolak {
            color: #991b1b;
            font-weight: bold;
        }

        .status-tervalidasi {
            color: #065f46;
            font-weight: bold;
        }

        /* FOOTER */
        .footer {
            margin-top: 40px;
            font-size: 11px;
        }

        .ttd {
            width: 40%;
            float: right;
            text-align: center;
        }
    </style>
</head>
<body>

<!-- HEADER -->
<div class="header">
    <h2>Politeknik Negeri Bandung</h2>
    <h3><?= esc($judul) ?></h3>
    <p>Dicetak pada: <?= date('d F Y') ?></p>
</div>

<?php foreach ($kategori as $k): ?>
    <div class="kategori">
        <div class="kategori-title">
            Kategori: <?= esc($k['nama_kategori']) ?> 
            (Status: <?= isset($k['status']) ? esc(ucfirst($k['status'])) : 'Aktif' ?>)
        </div>

        <?php if (empty($k['dokumen'])): ?>
            <p>Tidak ada dokumen</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th style="width:5%">ID</th>
                        <th style="width:35%">Judul Dokumen</th>
                        <th style="width:25%">Unit / Pengirim</th>
                        <th style="width:20%">Tanggal Validasi</th>
                        <th style="width:15%">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($k['dokumen'] as $d): ?>
                        <tr>
                            <td>#<?= esc($d['id']) ?></td>
                            <td><?= esc($d['judul']) ?></td>
                            <td><?= esc($d['nama_unit']) ?></td>
                            <td><?= date('d M Y', strtotime($d['updated_at'])) ?></td>
                            <td>
                                <?php
                                    switch($d['status']) {
                                        case 'archived':
                                            echo '<span class="status-tervalidasi">Disetujui Kajur</span>';
                                            break;
                                        case 'pending_kaprodi':
                                        case 'pending_kajur':
                                            echo '<span class="status-pending">Pending</span>';
                                            break;
                                        case 'rejected_kaprodi':
                                        case 'rejected_kajur':
                                            echo '<span class="status-ditolak">Ditolak</span>';
                                            break;
                                        default:
                                            echo esc($d['status']);
                                    }
                                ?>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        <?php endif ?>
    </div>
<?php endforeach ?>

<!-- FOOTER TTD -->
<div class="footer">
    <div class="ttd">
        <p>Bandung, <?= date('d F Y') ?></p>
        <p>Mengetahui,</p>
        <br><br><br>
        <p><strong>Administrator Sistem</strong></p>
    </div>
</div>

</body>
</html>
