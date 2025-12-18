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

    // hanya kategori aktif (dipakai nanti di staff)
    public function getAktif()
    {
        return $this->where('status', 'aktif')->findAll();
    }
}
