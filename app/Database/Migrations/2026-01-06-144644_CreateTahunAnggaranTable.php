<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTahunAnggaranTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'tahun' => [
                'type'       => 'INT',
                'constraint' => 4,
                'null'       => false,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['active', 'inactive'],
                'null'       => false,
                'default'    => 'inactive',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addPrimaryKey('id');

        // Optional index (sering difilter)
        $this->forge->addKey('status');

        $this->forge->createTable('tahun_anggaran');
    }

    public function down()
    {
        $this->forge->dropTable('tahun_anggaran');
    }
}
