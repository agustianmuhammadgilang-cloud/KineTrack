<?php

namespace App\Models;

use CodeIgniter\Model;

class ActivityLogScheduleModel extends Model
{
    protected $table = 'activity_log_schedules';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'archive_after_months',
        'delete_after_months',
        'auto_backup',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = true;
}
