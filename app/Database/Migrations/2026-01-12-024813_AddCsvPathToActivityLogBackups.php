<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCsvPathToActivityLogBackups extends Migration
{
    public function up()
    {
        $this->forge->addColumn('activity_log_backups', [
            'csv_path' => [
                'type'       => 'varchar',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'file_path',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('activity_log_backups', 'csv_path');
    }
}