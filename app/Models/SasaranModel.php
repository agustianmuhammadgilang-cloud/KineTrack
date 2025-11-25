<?php
namespace App\Models;
use CodeIgniter\Model;

class SasaranModel extends Model
{
    protected $table = 'sasaran_strategis';
    protected $primaryKey = 'id';
    protected $allowedFields = ['tahun_id','kode_sasaran','nama_sasaran'];
    protected $returnType = 'array';
    protected $useTimestamps = true;
}
