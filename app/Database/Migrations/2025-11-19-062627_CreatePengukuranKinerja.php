<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePengukuranKinerja extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type'=>'INT','constraint'=>11,'unsigned'=>true,'auto_increment'=>true],
            'indikator_id' => ['type'=>'INT','constraint'=>11,'unsigned'=>true],
            'tahun_id' => ['type'=>'INT','constraint'=>11,'unsigned'=>true],
            'triwulan' => ['type'=>'TINYINT','constraint'=>1,'default'=>1],
            'user_id' => ['type'=>'INT','constraint'=>11,'unsigned'=>true,'null'=>true],
            'realisasi' => ['type'=>'DOUBLE','null'=>true],
            'progress' => ['type'=>'DOUBLE','null'=>true],
            'kendala' => ['type'=>'TEXT','null'=>true],
            'strategi' => ['type'=>'TEXT','null'=>true],
            'data_dukung' => ['type'=>'TEXT','null'=>true], // url(s) or json
            'file_dukung' => ['type'=>'VARCHAR','constraint'=>255,'null'=>true],
            'created_by' => ['type'=>'INT','constraint'=>11,'null'=>true],
            'created_at' => ['type'=>'DATETIME','null'=>true],
            'updated_at' => ['type'=>'DATETIME','null'=>true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('indikator_id','indikator_kinerja','id','CASCADE','CASCADE');
        $this->forge->addForeignKey('tahun_id','tahun_anggaran','id','CASCADE','CASCADE');
        $this->forge->createTable('pengukuran_kinerja');
    }

    public function down()
    {
        $this->forge->dropTable('pengukuran_kinerja');
    }
}
