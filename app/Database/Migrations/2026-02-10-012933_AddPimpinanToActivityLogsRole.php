<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPimpinanToActivityLogsRole extends Migration
{
    public function up()
    {
        // Tambah enum 'pimpinan'
        $this->db->query("
            ALTER TABLE activity_logs
            MODIFY role ENUM('admin','pimpinan','atasan','staff') NOT NULL
        ");
    }

    public function down()
    {
        // Rollback ke enum lama
        $this->db->query("
            ALTER TABLE activity_logs
            MODIFY role ENUM('admin','atasan','staff') NOT NULL
        ");
    }
}
