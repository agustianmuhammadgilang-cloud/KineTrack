<?php

namespace App\Models;

use CodeIgniter\Model;

class LaporanModel extends Model
{
    protected $table = 'laporan';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'user_id',
        'judul',
        'deskripsi',
        'tanggal',
        'file_bukti',
        'status',
        'catatan_atasan'
    ];

    protected $returnType = 'array';
}
