<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateActivityLogBackupsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 10,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'backup_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'file_path' => [
                'type' => 'TEXT',
            ],
            'period_start' => [
                'type' => 'DATE',
            ],
            'period_end' => [
                'type' => 'DATE',
            ],
            'created_by' => [
                'type'       => 'INT',
                'constraint' => 10,
                'unsigned'   => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('created_by');

        $this->forge->createTable('activity_log_backups', true);
    }

    public function down()
    {
        $this->forge->dropTable('activity_log_backups', true);
    }
}
