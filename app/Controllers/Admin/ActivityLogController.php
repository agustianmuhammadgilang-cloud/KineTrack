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

    public function index()
    {
        // Proteksi role (WAJIB)
        if (session()->get('role') !== 'admin') {
            return redirect()->back();
        }

        $data = [
            'title' => 'Log Aktivitas',
            'logs' => $this->activityLogModel->getAllLogsWithUser(50),
        ];

        return view('admin/activity_logs/index', $data);
    }
}
