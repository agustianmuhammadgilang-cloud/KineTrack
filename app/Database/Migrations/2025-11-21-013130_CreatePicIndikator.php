<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePicIndikator extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'indikator_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'tahun_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'sasaran_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'bidang_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'jabatan_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true
            ]
        ]);

        $this->forge->addKey('id', true);

        // FOREIGN KEYS
        $this->forge->addForeignKey('indikator_id', 'indikator_kinerja', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('tahun_id', 'tahun_anggaran', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('sasaran_id', 'sasaran_strategis', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('bidang_id', 'bidang', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('jabatan_id', 'jabatan', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('pic_indikator', true, ['ENGINE' => 'InnoDB', 'DEFAULT CHARSET' => 'utf8mb4']);
    }

    public function down()
    {
        $this->forge->dropTable('pic_indikator', true);
    }
}
