<?php
use App\Models\PicModel;
use App\Models\PengukuranModel;

function getPendingTaskCount($userId)
{
    $pic = new PicModel();
    $peng = new PengukuranModel();

    $tasks = $pic->getTasksForUser($userId);
    $pending = 0;

    foreach ($tasks as $t) {
        $cek = $peng->where('indikator_id', $t['indikator_id'])
                    ->where('user_id', $userId)
                    ->first();
        if (!$cek) {
            $pending++;
        }
    }
    return $pending;
}
