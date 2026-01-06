<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSasaranStrategisTable extends Migration
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
            'tahun_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'kode_sasaran' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'nama_sasaran' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'triwulan' => [
                'type'       => 'TINYINT',
                'constraint' => 4,
                'null'       => true,
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

        // Index (sesuai MUL)
        $this->forge->addKey('tahun_id');

        $this->forge->createTable('sasaran_strategis');
    }

    public function down()
    {
        $this->forge->dropTable('sasaran_strategis');
    }
}
