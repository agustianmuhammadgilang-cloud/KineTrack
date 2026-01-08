<?php

namespace App\Models;

use CodeIgniter\Model;

class PengajuanKategoriModel extends Model
{
    protected $table      = 'pengajuan_kategori_dokumen';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'nama_kategori',
        'deskripsi',
        'pengaju_user_id',
        'status',
        'admin_id',
        'is_viewed_by_admin',
    ];

    protected $useTimestamps = true;

    /**
     * =====================================
     * DEFAULT STATUS HANDLING
     * =====================================
     */
    protected $beforeInsert = ['setDefaultStatus'];

    protected function setDefaultStatus(array $data)
    {
        if (!isset($data['data']['status']) || empty($data['data']['status'])) {
            $data['data']['status'] = 'pending';
        }
        return $data;
    }

    /**
     * =====================================
     * HELPER QUERY (ADMIN)
     * =====================================
     */

    // Semua pengajuan (untuk index admin)
    public function getAllPengajuan()
    {
        return $this->orderBy('created_at', 'DESC')->findAll();
    }

    // Hanya pengajuan yang masih bisa diproses admin
    public function getPending()
    {
        return $this->where('status', 'pending')
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    /**
     * =====================================
     * HELPER VALIDASI STATUS
     * =====================================
     */
    public function isProcessable(array $pengajuan): bool
    {
        return in_array($pengajuan['status'], ['pending']);
    }

    /**
 * KATEGORI YANG BISA DIPAKAI STAFF
 * approved (aktif) + rejected
 */
public function getUntukStaff()
{
    return $this->whereIn('status', ['aktif', 'rejected'])
                ->orderBy('nama_kategori', 'ASC')
                ->findAll();
}

}
