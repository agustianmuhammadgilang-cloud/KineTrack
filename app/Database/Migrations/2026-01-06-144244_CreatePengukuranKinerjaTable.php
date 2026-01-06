<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePengukuranKinerjaTable extends Migration
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
            'indikator_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'tahun_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'triwulan' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => false,
                'default'    => 1,
            ],
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'realisasi' => [
                'type' => 'DOUBLE',
                'null' => true,
            ],
            'progress' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'kendala' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'strategi' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'file_dukung' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_by' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
            ],
            'pic_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => false,
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

        // Index sesuai DESCRIBE (MUL)
        $this->forge->addKey('indikator_id');
        $this->forge->addKey('tahun_id');
        $this->forge->addKey('user_id');
        $this->forge->addKey('pic_id');

        $this->forge->createTable('pengukuran_kinerja');
    }

    public function down()
    {
        $this->forge->dropTable('pengukuran_kinerja');
    }
}
