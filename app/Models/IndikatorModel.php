<?php
namespace App\Models;
use CodeIgniter\Model;

class IndikatorModel extends Model
{
    protected $table = 'indikator_kinerja';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'sasaran_id','kode_indikator','nama_indikator','satuan',
        'target_pk','target_tw1','target_tw2','target_tw3','target_tw4'
    ];
    protected $returnType = 'array';
    protected $useTimestamps = true;
}
