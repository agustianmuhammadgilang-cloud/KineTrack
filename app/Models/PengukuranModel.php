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
        'target',
        'realisasi',
        'persentase',
        'catatan',
        'created_by'
    ];

    protected $returnType = 'array';
    protected $useTimestamps = true;
}
