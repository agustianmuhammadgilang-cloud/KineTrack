<?php

namespace App\Controllers\Staff;

use App\Controllers\BaseController;
use App\Models\LaporanModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $laporanModel = new LaporanModel();
        $userId = session('user_id');

        // Total laporan diterima
        $approved = $laporanModel->where('user_id', $userId)
                                 ->where('status', 'approved')
                                 ->countAllResults();

        // Total laporan ditolak
        $rejected = $laporanModel->where('user_id', $userId)
                                 ->where('status', 'rejected')
                                 ->countAllResults();

        // Progress
        $total = $approved + $rejected;
        $progress = ($total > 0) ? round(($approved / $total) * 100) : 0;

        // Ambil grafik harian bulan ini
        $daily = $laporanModel->getDailyData($userId);

        // Ambil grafik mingguan
        $weekly = $laporanModel->getWeeklyData($userId);

        // Ambil grafik bulanan
        $monthly = $laporanModel->getMonthlyData($userId);

        $data = [
            'approved' => $approved,
            'rejected' => $rejected,
            'progress' => $progress,
            'daily'    => $daily,
            'weekly'   => $weekly,
            'monthly'  => $monthly,
        ];

        return view('staff/dashboard', $data);
    }
}
