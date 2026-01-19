<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'nama',
        'email',
        'password',
        'jabatan_id',
        'bidang_id',
        'role',
        'foto',
        'ttd_digital',
        'atasan_id'
    ];

    protected $returnType = 'array';
    /**
     * =====================================================
     * GLOBAL SEARCH USER
     * Cari berdasarkan:
     * - nama user
     * - email
     * - nama jabatan
     * - nama bidang (unit kerja)
     * =====================================================
     */
    public function searchUsers(?string $keyword = null): array
    {
        $builder = $this->db->table($this->table)
            ->select('
                users.*,
                jabatan.nama_jabatan,
                bidang.nama_bidang
            ')
            ->join('jabatan', 'jabatan.id = users.jabatan_id', 'left')
            ->join('bidang', 'bidang.id = users.bidang_id', 'left');

        if (!empty($keyword)) {
            $builder->groupStart()
                ->like('users.nama', $keyword)
                ->orLike('users.email', $keyword)
                ->orLike('jabatan.nama_jabatan', $keyword)
                ->orLike('bidang.nama_bidang', $keyword)
            ->groupEnd();
        }

        return $builder
            ->orderBy('bidang.nama_bidang', 'ASC')
            ->orderBy('users.nama', 'ASC')
            ->get()
            ->getResultArray();
    }
}
