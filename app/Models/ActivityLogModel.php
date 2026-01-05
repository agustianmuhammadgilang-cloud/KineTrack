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
    protected $useTimestamps    = false; // Log hanya INSERT

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
        'is_restored',
        'restored_at',
        'restored_from_backup',
    ];

    /**
     * ===============================
     * ADMIN METHODS
     * ===============================
     */

    /**
     * Ambil semua log (ADMIN)
     */
    public function getAllLogs($limit = 20)
    {
        return $this->orderBy('created_at', 'DESC')
                    ->findAll($limit);
    }

    /**
     * Ambil semua log + nama user (ADMIN)
     */
    public function getAllLogsWithUser($limit = 100)
{
    return $this->select('activity_logs.*, users.nama')
        ->join('users', 'users.id = activity_logs.user_id', 'left')
        ->orderBy('COALESCE(activity_logs.restored_at, activity_logs.created_at)', 'DESC', false)
        ->findAll($limit);
}
    /**
     * ===============================
     * USER METHODS
     * ===============================
     */

    /**
     * Ambil log milik user tertentu (staff / atasan)
     */
    public function getLogsByUser($userId, $limit = 20)
    {
        return $this->where('user_id', $userId)
                    ->orderBy('created_at', 'DESC')
                    ->findAll($limit);
    }

    /**
     * ===============================
     * ACTIVITY LOG MANAGEMENT
     * ===============================
     */

    /**
     * Ambil log yang lebih dari X bulan
     * Dipakai untuk archive & cleanup
     */
    public function getLogsOlderThanMonths($months)
    {
        return $this->where(
                        'created_at <',
                        date('Y-m-d H:i:s', strtotime("-{$months} months"))
                    )
                    ->findAll();
    }

    /**
     * Hapus log lebih dari X bulan (ADMIN)
     * Pastikan dipanggil setelah backup
     */
    public function deleteLogsOlderThanMonths($months)
    {
        return $this->where(
                        'created_at <',
                        date('Y-m-d H:i:s', strtotime("-{$months} months"))
                    )
                    ->delete();
    }
}
