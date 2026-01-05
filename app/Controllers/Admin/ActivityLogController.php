<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ActivityLogModel;
class ActivityLogController extends BaseController
{
    protected $activityLogModel;

    public function __construct()
    {
        $this->activityLogModel = new ActivityLogModel();
    }

    /**
     * Menampilkan log aktivitas (ADMIN ONLY)
     */
    public function index()
{
    if (session()->get('role') !== 'admin') {
        return redirect()->back()->with('error', 'Akses ditolak');
    }

    // Kita ambil 100 data terbaru agar monitoring lebih luas
    $limit = 100; 

    $data = [
        'title' => 'Manajemen Log Aktivitas',
        // Pastikan fungsi di model ini menerima parameter $limit
        'logs'  => $this->activityLogModel->getAllLogsWithUser($limit), 
    ];

    return view('admin/activity_logs/index', $data);
}

    /**
     * Log milik user sendiri (staff / atasan)
     * Controller ini tetap bisa dipakai kalau nanti dipisah role
     */
    public function myLogs()
    {
        $userId = session()->get('user_id');

        $data = [
            'title' => 'Log Aktivitas Saya',
            'logs'  => $this->activityLogModel->getLogsByUser($userId, 50),
        ];

        return view('admin/activity_logs/my_logs', $data);
    }
}
