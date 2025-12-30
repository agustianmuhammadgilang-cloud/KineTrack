<?php
use App\Models\PicModel;
use App\Models\PengukuranModel;

// Helper untuk menghitung jumlah tugas pending untuk user tertentu
function getPendingTaskCount($userId)
{
    // Ambil model PIC dan Pengukuran
    $pic = new PicModel();
    $peng = new PengukuranModel();

    // Ambil semua tugas yang diberikan kepada user
    $tasks = $pic->getTasksForUser($userId);
    $pending = 0;

    // Cek setiap tugas apakah sudah ada pengukuran terkait
    foreach ($tasks as $t) {
        $cek = $peng->where('indikator_id', $t['indikator_id'])
                    ->where('user_id', $userId)
                    ->first();
        // Jika belum ada pengukuran, hitung sebagai pending
        if (!$cek) {
            $pending++;
        }
    }
    return $pending;
}
