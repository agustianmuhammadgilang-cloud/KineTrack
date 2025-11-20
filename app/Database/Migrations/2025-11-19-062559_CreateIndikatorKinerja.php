<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateIndikatorKinerja extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type'=>'INT','constraint'=>11,'unsigned'=>true,'auto_increment'=>true],
            'sasaran_id' => ['type'=>'INT','constraint'=>11,'unsigned'=>true],
            'kode_indikator' => ['type'=>'VARCHAR','constraint'=>80,'null'=>true],
            'nama_indikator' => ['type'=>'TEXT'],
            'satuan' => ['type'=>'VARCHAR','constraint'=>50,'null'=>true],
            // default target tahunan + optional target per triwulan
            'target_pk' => ['type'=>'DOUBLE','null'=>true],
            'target_tw1' => ['type'=>'DOUBLE','null'=>true],
            'target_tw2' => ['type'=>'DOUBLE','null'=>true],
            'target_tw3' => ['type'=>'DOUBLE','null'=>true],
            'target_tw4' => ['type'=>'DOUBLE','null'=>true],
            'created_at' => ['type'=>'DATETIME','null'=>true],
            'updated_at' => ['type'=>'DATETIME','null'=>true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('sasaran_id','sasaran_strategis','id','CASCADE','CASCADE');
        $this->forge->createTable('indikator_kinerja');
    }

    public function down()
    {
        $this->forge->dropTable('indikator_kinerja');
    }
}
