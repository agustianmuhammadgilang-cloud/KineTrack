<?php

namespace App\Models;

use CodeIgniter\Model;

class SystemReminderModel extends Model
{
    protected $table      = 'system_reminders';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'action_type',
        'message',
        'related_table',
        'total_data',
        'status',
        'executed_at',
        'created_at',
    ];

    protected $useTimestamps = false;
}