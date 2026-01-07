<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SystemReminderModel;

class ActivityLogReminderController extends BaseController
{
    public function index()
    {
        $model = new SystemReminderModel();

        $data['reminders'] = $model
            ->orderBy('executed_at', 'DESC')
            ->findAll();

        return view('admin/activity_logs/reminder', $data);
    }
}