<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddRestoreColumnsToActivityLogs extends Migration
{
    public function up()
    {
        $db = \Config\Database::connect();

        if (!$db->fieldExists('is_restored', 'activity_logs')) {
            $this->forge->addColumn('activity_logs', [
                'is_restored' => [
                    'type'       => 'TINYINT',
                    'constraint' => 1,
                    'default'    => 0,
                    'after'      => 'action',
                ],
            ]);
        }

        if (!$db->fieldExists('restored_at', 'activity_logs')) {
            $this->forge->addColumn('activity_logs', [
                'restored_at' => [
                    'type'  => 'DATETIME',
                    'null'  => true,
                    'after' => 'is_restored',
                ],
            ]);
        }

        if (!$db->fieldExists('restored_from_backup', 'activity_logs')) {
            $this->forge->addColumn('activity_logs', [
                'restored_from_backup' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                    'null'       => true,
                    'after'      => 'restored_at',
                ],
            ]);
        }
    }

    public function down()
    {
        $db = \Config\Database::connect();

        if ($db->fieldExists('is_restored', 'activity_logs')) {
            $this->forge->dropColumn('activity_logs', 'is_restored');
        }

        if ($db->fieldExists('restored_at', 'activity_logs')) {
            $this->forge->dropColumn('activity_logs', 'restored_at');
        }

        if ($db->fieldExists('restored_from_backup', 'activity_logs')) {
            $this->forge->dropColumn('activity_logs', 'restored_from_backup');
        }
    }
}