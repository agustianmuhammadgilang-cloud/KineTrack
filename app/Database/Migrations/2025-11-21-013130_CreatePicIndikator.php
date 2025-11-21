<?php

// 1️⃣ Migration: app/Database/Migrations/20251121_create_pic_indikator.php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePicIndikator extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true],
            'indikator_id' => ['type' => 'INT', 'null' => false],
            'user_id' => ['type' => 'INT', 'null' => false],
            'tahun_id' => ['type' => 'INT', 'null' => false],
            'sasaran_id' => ['type' => 'INT', 'null' => false],
            'bidang_id' => ['type' => 'INT', 'null' => false],
            'jabatan_id' => ['type' => 'INT', 'null' => false],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('indikator_id','indikator_kinerja','id','CASCADE','CASCADE');
        $this->forge->addForeignKey('user_id','users','id','CASCADE','CASCADE');
        $this->forge->addForeignKey('tahun_id','tahun_anggaran','id','CASCADE','CASCADE');
        $this->forge->addForeignKey('sasaran_id','sasaran_strategis','id','CASCADE','CASCADE');
        $this->forge->addForeignKey('bidang_id','bidang','id','CASCADE','CASCADE');
        $this->forge->addForeignKey('jabatan_id','jabatan','id','CASCADE','CASCADE');
        $this->forge->createTable('pic_indikator');
    }

    public function down()
    {
        $this->forge->dropTable('pic_indikator');
    }
}
