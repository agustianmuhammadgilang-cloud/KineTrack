<?php

namespace App\Models;

use CodeIgniter\Model;

class TwModel extends Model
{
    protected $table      = 'tw_settings';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'tahun_id',
        'tw',
        'is_open'
    ];
}
