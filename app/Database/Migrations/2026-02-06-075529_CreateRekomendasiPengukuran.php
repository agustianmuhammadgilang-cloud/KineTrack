<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRekomendasiPengukuran extends Migration
{
    public function up()
    {
        $this->forge->addField([

            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],

            'tahun_id' => [
                'type'     => 'INT',
                'unsigned' => true,
            ],

            'triwulan' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
            ],

            'isi_rekomendasi' => [
                'type' => 'TEXT',
            ],

            'pimpinan_id' => [
                'type'     => 'INT',
                'unsigned' => true,
            ],

            'created_at DATETIME DEFAULT CURRENT_TIMESTAMP',
            'updated_at DATETIME NULL',

        ]);

        $this->forge->addKey('id', true);

        // UNIQUE: 1 rekomendasi per periode
        $this->forge->addUniqueKey(['tahun_id', 'triwulan']);

        // Foreign key
        $this->forge->addForeignKey('tahun_id', 'tahun_anggaran', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('pimpinan_id', 'users', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('rekomendasi_pengukuran');
    }

    public function down()
    {
        $this->forge->dropTable('rekomendasi_pengukuran');
    }
}
