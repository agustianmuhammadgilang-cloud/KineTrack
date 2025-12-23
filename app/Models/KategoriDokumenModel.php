<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriDokumenModel extends Model
{
    protected $table      = 'kategori_dokumen';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'nama_kategori',
        'deskripsi',
        'status',
        'created_by'
    ];

    protected $useTimestamps = true;

    /**
     * =====================================
     * KATEGORI YANG BISA DIPAKAI STAFF
     * (aktif + draft)
     * =====================================
     */
    public function getUntukStaff()
    {
        return $this->whereIn('status', ['aktif', 'draft'])
                    ->orderBy('nama_kategori', 'ASC')
                    ->findAll();
    }

    /**
     * =====================================
     * KATEGORI RESMI (TERVALIDASI ADMIN)
     * =====================================
     */
    // kategori aktif (sudah tervalidasi admin)
public function getTervalidasi()
{
    return $this->where('status', 'aktif')->findAll();
}

// kategori belum tervalidasi
public function getTidakTervalidasi()
{
    return $this->where('status', 'pending')->findAll();
}


    /**
     * =====================================
     * (LEGACY) — JANGAN DIHAPUS
     * Dipakai kode lama
     * =====================================
     */
    public function getAktif()
    {
        return $this->where('status', 'aktif')->findAll();
    }

    /**
 * =====================================
 * KATEGORI YANG BISA DIPAKAI STAFF
 * (aktif + pending)
 * =====================================
 */
public function getAktifDanPending()
{
    return $this->whereIn('status', ['aktif', 'pending'])
                ->orderBy('nama_kategori', 'ASC')
                ->findAll();
}

public function getUntukFormStaff()
{
    return $this->select("
            id,
            nama_kategori,
            status
        ")
        ->whereIn('status', ['aktif', 'pending', 'rejected'])
        ->orderBy("
            CASE 
                WHEN status = 'aktif' THEN 1
                WHEN status = 'pending' THEN 2
                WHEN status = 'rejected' THEN 3
            END
        ")
        ->orderBy('nama_kategori', 'ASC')
        ->findAll();
}


}
