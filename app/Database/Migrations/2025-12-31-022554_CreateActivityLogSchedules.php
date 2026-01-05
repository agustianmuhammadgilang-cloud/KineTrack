<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateActivityLogSchedules extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'archive_after_months' => [
                'type' => 'INT',
                'default' => 3,
            ],
            'delete_after_months' => [
                'type' => 'INT',
                'default' => 6,
            ],
            'auto_backup' => [
                'type' => 'BOOLEAN',
                'default' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
            ],
            'updated_at' => [
                'type' => 'DATETIME',
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('activity_log_schedules');
    }

    public function down()
    {
        $this->forge->dropTable('activity_log_schedules');
    }
}
