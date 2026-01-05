<?php

namespace App\Models;

use CodeIgniter\Model;

class ActivityLogBackupModel extends Model
{
    protected $table            = 'activity_log_backups';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'backup_name',
        'file_path',
        'period_start',
        'period_end',
        'created_by',
        'created_at',
    ];

    protected $useTimestamps = false;
}
