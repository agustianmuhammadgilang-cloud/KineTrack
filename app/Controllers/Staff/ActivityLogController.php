<?php

namespace App\Controllers\Staff;

use App\Controllers\BaseController;
use App\Models\ActivityLogModel;
// Controller untuk mengelola log aktivitas staff
class ActivityLogController extends BaseController
{
    protected $logModel;
    // Konstruktor untuk inisialisasi model log aktivitas
    public function __construct()
    {
        $this->logModel = new ActivityLogModel();
    }

    /**
     * Halaman daftar log aktivitas staff
     */
    public function index()
    {
        $userId = session()->get('user_id');

        // Ambil hanya log milik staff ini
        $logs = $this->logModel
            ->where('user_id', $userId)
            ->orderBy('created_at', 'DESC')
            ->findAll(100); // batasi biar ringan

        return view('staff/activity_logs/index', [
            'logs' => $logs
        ]);
    }
}
