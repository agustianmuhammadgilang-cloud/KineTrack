<?php

namespace App\Models;

use CodeIgniter\Model;

class DokumenViewModel extends Model
{
    protected $table            = 'dokumen_views';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'dokumen_id',
        'user_id',
        'menu_type',
        'viewed_at'
        // 'created_at'
    ];

    protected $useTimestamps = false;
}
