<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'nama'        => 'Administrator',
            'email'       => 'admin@kinetrack.test',
            'password'    => password_hash('admin123', PASSWORD_DEFAULT),
            'jabatan_id'  => NULL,
            'bidang_id'   => NULL,
            'role'        => 'admin'
        ];

        $this->db->table('users')->insert($data);
    }
}
