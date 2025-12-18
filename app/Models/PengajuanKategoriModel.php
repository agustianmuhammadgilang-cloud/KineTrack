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
        'admin_id'
    ];

    protected $useTimestamps = true;
}
