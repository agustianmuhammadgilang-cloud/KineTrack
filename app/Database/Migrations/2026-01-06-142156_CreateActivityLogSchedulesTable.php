<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateActivityLogSchedulesTable extends Migration
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
            'archive_after_months' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 3,
                'comment'    => 'Log dipindahkan ke archive setelah X bulan',
            ],
            'delete_after_months' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 6,
                'comment'    => 'Log dihapus permanen setelah X bulan',
            ],
            'auto_backup' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
                'comment'    => '1 = backup otomatis aktif',
            ],
            'created_at' => [
                'type' => 'DATETIME',
            ],
            'updated_at' => [
                'type' => 'DATETIME',
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('activity_log_schedules', true);
    }

    public function down()
    {
        $this->forge->dropTable('activity_log_schedules', true);
    }
}
