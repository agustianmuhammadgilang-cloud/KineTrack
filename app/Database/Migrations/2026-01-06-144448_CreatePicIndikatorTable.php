<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePicIndikatorTable extends Migration
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
            'user_id' => [
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
            'sasaran_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'bidang_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'jabatan_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
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

        // Index sesuai MUL (penting untuk performa join)
        $this->forge->addKey('indikator_id');
        $this->forge->addKey('user_id');
        $this->forge->addKey('tahun_id');
        $this->forge->addKey('sasaran_id');
        $this->forge->addKey('bidang_id');
        $this->forge->addKey('jabatan_id');

        $this->forge->createTable('pic_indikator');
    }

    public function down()
    {
        $this->forge->dropTable('pic_indikator');
    }
}
