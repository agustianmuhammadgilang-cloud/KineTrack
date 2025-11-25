<?php

namespace App\Controllers\Staff;

use App\Controllers\BaseController;
use App\Models\LaporanModel;
use App\Models\NotificationModel;

class Dashboard extends BaseController
{
    public function index()
    {
        // ==================== PENDING TASK ====================
        $data['pending_count'] = $this->pending_count;

        $userId = session('user_id');

        // ==================== LAPORAN ====================
        $laporanModel = new LaporanModel();

        $approved = $laporanModel->where('user_id', $userId)
                                 ->where('status', 'approved')
                                 ->countAllResults();

        $rejected = $laporanModel->where('user_id', $userId)
                                 ->where('status', 'rejected')
                                 ->countAllResults();

        $total = $approved + $rejected;
        $progress = ($total > 0) ? round(($approved / $total) * 100) : 0;

        $daily   = $laporanModel->getDailyData($userId);
        $weekly  = $laporanModel->getWeeklyData($userId);
        $monthly = $laporanModel->getMonthlyData($userId);

        $data['approved'] = $approved;
        $data['rejected'] = $rejected;
        $data['progress'] = $progress;
        $data['daily']    = $daily;
        $data['weekly']   = $weekly;
        $data['monthly']  = $monthly;

        // ==================== NOTIFIKASI ====================
        $notifModel = new NotificationModel();

        // Ambil notifikasi belum dibaca
        $data['notifications'] = $notifModel
            ->where('user_id', $userId)
            ->where('is_read', 0)
            ->orderBy('created_at', 'DESC')
            ->findAll();

        // Tandai semua notifikasi sebagai sudah dibaca
        foreach ($data['notifications'] as $n) {
            $notifModel->update($n['id'], ['is_read' => 1]);
        }

        // ==================== RETURN VIEW ====================
        return view('staff/dashboard', $data);
    }

    public function markRead($id)
{
    $notifModel = new \App\Models\NotificationModel();
    $notifModel->update($id, ['is_read' => 1]);
    return $this->response->setStatusCode(200);
}

}
