<?php

namespace App\Models;

use CodeIgniter\Model;

class BidangModel extends Model
{
    protected $table = 'bidang';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama_bidang','jenis_unit','parent_id'];
    protected $returnType = 'array';
}
