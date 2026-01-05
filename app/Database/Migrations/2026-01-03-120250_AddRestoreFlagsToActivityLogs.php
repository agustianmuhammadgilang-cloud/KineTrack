<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddRestoreFlagsToActivityLogs extends Migration
{
    public function up()
    {
        $this->forge->addColumn('activity_logs', [
            'is_restored' => [
                'type'       => 'BOOLEAN',
                'default'    => false,
                'after'      => 'action',
                'comment'    => 'Menandai log hasil restore'
            ],
            'restored_at' => [
                'type'       => 'DATETIME',
                'null'       => true,
                'after'      => 'is_restored',
                'comment'    => 'Waktu data direstore'
            ],
            'restored_from_backup' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'restored_at',
                'comment'    => 'Nama file backup asal'
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('activity_logs', [
            'is_restored',
            'restored_at',
            'restored_from_backup'
        ]);
    }
}