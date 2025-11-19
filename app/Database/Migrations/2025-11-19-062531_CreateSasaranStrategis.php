<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSasaranStrategis extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type'=>'INT','constraint'=>11,'unsigned'=>true,'auto_increment'=>true],
            'tahun_id' => ['type'=>'INT','constraint'=>11,'unsigned'=>true],
            'kode_sasaran' => ['type'=>'VARCHAR','constraint'=>50,'null'=>true],
            'nama_sasaran' => ['type'=>'TEXT'],
            'created_at' => ['type'=>'DATETIME','null'=>true],
            'updated_at' => ['type'=>'DATETIME','null'=>true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('tahun_id','tahun_anggaran','id','CASCADE','CASCADE');
        $this->forge->createTable('sasaran_strategis');
    }

    public function down()
    {
        $this->forge->dropTable('sasaran_strategis');
    }
}
