<?php

use App\Models\TwModel;

/**
 * Ambil status TW lengkap:
 * - is_open (true/false)
 * - source: admin / auto
 */
function getTwStatus(int $tahunId, int $tw): array
{
    $model = new TwModel();
    $row = $model->where('tahun_id', $tahunId)
                 ->where('tw', $tw)
                 ->first();

    if (!$row) {
        return ['is_open' => false, 'source' => 'unknown'];
    }

    $isOpenDB = (int)$row['is_open'] === 1;
    $autoMode = (int)$row['auto_mode'] === 1;

    // Hitung TW otomatis berdasarkan bulan
    $currentMonth = (int) date('n');
    $currentTw = ceil($currentMonth / 3);

    // DETEKSI SUMBER PEMBUKAAN
    if ($autoMode && $tw == $currentTw && $isOpenDB) {
        $source = 'auto';
    } elseif ($isOpenDB) {
        $source = 'admin';
    } else {
        $source = 'closed';
    }

    return [
        'is_open' => $isOpenDB,
        'source'  => $source
    ];
}




/**
 * Return true/false mudah untuk controller
 */
function isTwOpenEffective(int $tahunId, int $tw): bool
{
    $status = getTwStatus($tahunId, $tw);
    return $status['is_open'];
}


/**
 * Auto update tabel tw_settings berdasarkan bulan berjalan
 * (hanya untuk auto_mode = 1)
 */
function autoUnlockTW()
{
    $db = \Config\Database::connect();
    $currentMonth = (int) date('n');
    $currentTw = ceil($currentMonth / 3);

    $rows = $db->table('tw_settings')->get()->getResultArray();

    foreach ($rows as $row) {

        if ((int)$row['auto_mode'] !== 1) continue;

        // TW cocok dengan TW berjalan → buka
        $isOpen = ($row['tw'] == $currentTw) ? 1 : 0;

        $db->table('tw_settings')
            ->where('id', $row['id'])
            ->update(['is_open' => $isOpen]);
    }
}
