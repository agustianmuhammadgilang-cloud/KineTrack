<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTwSettingsTable extends Migration
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
            'tahun_id' => [
                'type'       => 'INT',
                'constraint' => 10,
                'unsigned'   => true,
                'null'       => false,
            ],
            'tw' => [
                'type'       => 'TINYINT',
                'constraint' => 4,
                'null'       => false,
            ],
            'is_open' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => false,
                'default'    => 0,
            ],
            'auto_mode' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => true,
                'default'    => 1,
            ],
        ]);

        $this->forge->addPrimaryKey('id');

        // Index penting
        $this->forge->addKey('tahun_id');
        $this->forge->addKey('tw');

        $this->forge->createTable('tw_settings');
    }

    public function down()
    {
        $this->forge->dropTable('tw_settings');
    }
}
