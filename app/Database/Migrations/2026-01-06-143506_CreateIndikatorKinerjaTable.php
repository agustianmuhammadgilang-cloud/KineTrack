<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateIndikatorKinerjaTable extends Migration
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
            'sasaran_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'kode_indikator' => [
                'type'       => 'VARCHAR',
                'constraint' => 80,
                'null'       => true,
            ],
            'nama_indikator' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'satuan' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'target_pk' => [
                'type' => 'DOUBLE',
                'null' => true,
            ],
            'target_tw1' => [
                'type' => 'DOUBLE',
                'null' => true,
            ],
            'target_tw2' => [
                'type' => 'DOUBLE',
                'null' => true,
            ],
            'target_tw3' => [
                'type' => 'DOUBLE',
                'null' => true,
            ],
            'target_tw4' => [
                'type' => 'DOUBLE',
                'null' => true,
            ],
            'mode' => [
                'type'       => 'ENUM',
                'constraint' => ['akumulatif', 'non'],
                'null'       => true,
                'default'    => 'non',
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
        $this->forge->addKey('sasaran_id');

        $this->forge->createTable('indikator_kinerja');
    }

    public function down()
    {
        $this->forge->dropTable('indikator_kinerja');
    }
}
