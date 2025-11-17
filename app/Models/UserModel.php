<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'nama',
        'email',
        'password',
        'jabatan_id',
        'bidang_id',
        'role'
    ];

    protected $returnType = 'array';
}
