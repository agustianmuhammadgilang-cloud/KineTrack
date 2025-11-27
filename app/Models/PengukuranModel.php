<?php
namespace App\Models;
use CodeIgniter\Model;

class PengukuranModel extends Model
{
    protected $table = 'pengukuran_kinerja';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'indikator_id',
        'tahun_id',
        'triwulan',
        'realisasi',
        'progress',
        'kendala',
        'strategi',
        'file_dukung',
        'user_id'       // ← dipakai untuk relasi ke users
    ];

    protected $returnType = 'array';
    protected $useTimestamps = true;
}