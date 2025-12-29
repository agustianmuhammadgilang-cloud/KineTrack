<?php

namespace App\Models;

use CodeIgniter\Model;

class ActivityLogModel extends Model
{
    protected $table            = 'activity_logs';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;

    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

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
    ];

    // Log hanya INSERT, tidak pernah UPDATE
    protected $useTimestamps = false;

    /**
     * Ambil log untuk ADMIN (semua data)
     */
    public function getAllLogs($limit = 20)
    {
        return $this->orderBy('created_at', 'DESC')
                    ->findAll($limit);
    }

    /**
     * Ambil log untuk user tertentu (staff / atasan)
     */
    public function getLogsByUser($userId, $limit = 20)
    {
        return $this->where('user_id', $userId)
                    ->orderBy('created_at', 'DESC')
                    ->findAll($limit);
    }
    public function getAllLogsWithUser($limit = 50)
{
    return $this->select('activity_logs.*, users.nama')
                ->join('users', 'users.id = activity_logs.user_id', 'left')
                ->orderBy('activity_logs.created_at', 'DESC')
                ->findAll($limit);
}


}
