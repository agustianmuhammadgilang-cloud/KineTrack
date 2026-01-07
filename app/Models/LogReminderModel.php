<?php

namespace App\Models;

use CodeIgniter\Model;

class LogReminderModel extends Model
{
    protected $table = 'log_reminders';
    protected $allowedFields = [
        'type',
        'title',
        'message',
        'level',
        'is_read',
        'created_at',
        'read_at'
    ];
}