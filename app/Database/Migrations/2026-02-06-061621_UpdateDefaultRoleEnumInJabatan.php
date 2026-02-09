<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateDefaultRoleEnumInJabatan extends Migration
{
    public function up()
    {
        $this->forge->modifyColumn('jabatan', [
            'default_role' => [
                'type'       => 'ENUM',
                'constraint' => ['staff', 'atasan', 'pimpinan'],
                'null'       => false,
            ],
        ]);
    }

    public function down()
    {
        // rollback ke kondisi lama
        $this->forge->modifyColumn('jabatan', [
            'default_role' => [
                'type'       => 'ENUM',
                'constraint' => ['staff', 'atasan'],
                'null'       => false,
            ],
        ]);
    }
}
