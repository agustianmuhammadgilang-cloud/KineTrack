<?php

namespace App\Models;

use CodeIgniter\Model;

class ActivityLogArchiveModel extends Model
{
    protected $table            = 'activity_logs_archive';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'user_id',
        'role',
        'action',
        'description',
        'subject_type',
        'subject_id',
        'ip_address',
        'user_agent',
        'created_at',
        'archived_at',
    ];

    protected $useTimestamps = false;
}
