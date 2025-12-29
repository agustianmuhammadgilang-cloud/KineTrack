<?php

namespace App\Controllers\Atasan;

use App\Controllers\BaseController;
use App\Models\ActivityLogModel;

class ActivityLogController extends BaseController
{
    protected $logModel;

    public function __construct()
    {
        $this->logModel = new ActivityLogModel();
    }

    public function index()
    {
        // proteksi role
        if (session()->get('role') !== 'atasan') {
            return redirect()->back();
        }

        $userId = session()->get('user_id');

        $logs = $this->logModel
            ->where('user_id', $userId)
            ->orderBy('created_at', 'DESC')
            ->findAll(100);

        return view('atasan/activity_log/index', [
            'logs' => $logs
        ]);
    }
}
