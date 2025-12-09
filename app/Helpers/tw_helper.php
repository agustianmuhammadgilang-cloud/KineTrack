<?php

use App\Models\TwModel;

/**
 * Cek apakah TW boleh diinput oleh PIC.
 * Menggabungkan logika:
 * 1. Triwulan otomatis berdasarkan bulan sekarang
 * 2. Override admin dari tabel tw_settings
 */
function isTwOpen(int $tahunId, int $tw): bool
{
    $currentMonth = (int) date('n'); // bulan 1–12
    $currentYear  = (int) date('Y');

    // ================================
    // 1. Tentukan TW aktif otomatis
    // ================================
    $autoTw = 0;

    if ($currentMonth >= 1  && $currentMonth <= 3)  $autoTw = 1;
    if ($currentMonth >= 4  && $currentMonth <= 6)  $autoTw = 2;
    if ($currentMonth >= 7  && $currentMonth <= 9)  $autoTw = 3;
    if ($currentMonth >= 10 && $currentMonth <= 12) $autoTw = 4;

    // Jika tahun cocok dan TW sedang aktif otomatis → langsung boleh
    if ($tahunId == $currentYear && $autoTw == $tw) {
        return true;
    }

    // ====================================
    // 2. Cek override admin pada database
    // ====================================
    $twModel = new TwModel();
    $row = $twModel
        ->where('tahun_id', $tahunId)
        ->where('tw', $tw)
        ->first();

    if ($row && $row['is_open'] == 1) {
        return true; // override admin
    }

    // default: tidak boleh
    return false;
}

function autoUnlockTW()
{
    $db = \Config\Database::connect();

    $currentMonth = (int) date('n');
    $currentTw = ceil($currentMonth / 3); // 1–4

    // Ambil semua tahun
    $tahun = $db->table('tahun_anggaran')->get()->getResultArray();

    foreach ($tahun as $t) {
        // Ambil TW untuk tahun ini
        $twList = $db->table('tw_settings')
            ->where('tahun_id', $t['id'])
            ->get()->getResultArray();

        foreach ($twList as $tw) {

            // Hanya auto-update TW yang auto_mode = 1
            if ($tw['auto_mode'] != 1) {
                continue;
            }

            // Sistem: TW selain TW bulan ini → kunci
            $isOpen = ($tw['tw'] == $currentTw) ? 1 : 0;

            $db->table('tw_settings')
                ->where('id', $tw['id'])
                ->update([
                    'is_open' => $isOpen
                ]);
        }
    }
}
