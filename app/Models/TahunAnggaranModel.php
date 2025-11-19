<?php
namespace App\Models;
use CodeIgniter\Model;

class TahunAnggaranModel extends Model
{
    protected $table = 'tahun_anggaran';
    protected $primaryKey = 'id';
    protected $allowedFields = ['tahun','status'];
    protected $returnType = 'array';
    protected $useTimestamps = true;
}
