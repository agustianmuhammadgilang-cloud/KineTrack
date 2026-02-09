<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPimpinanRoleToUsers extends Migration
{
    public function up()
    {
        $this->forge->modifyColumn('users', [
            'role' => [
                'type'       => "ENUM('admin','pimpinan','atasan','staff')",
                'null'       => false,
            ],
        ]);
    }

    public function down()
    {
        // rollback: hapus pimpinan dari enum
        $this->forge->modifyColumn('users', [
            'role' => [
                'type'       => "ENUM('admin','atasan','staff')",
                'null'       => false,
            ],
        ]);
    }
}
