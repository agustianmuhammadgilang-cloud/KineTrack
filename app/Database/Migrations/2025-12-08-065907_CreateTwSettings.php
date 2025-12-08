<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTwSettings extends Migration
{
    public function up()
    {
        // Struktur tabel
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
            'tw' => [
                'type' => 'TINYINT',
            ],
            'is_open' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
            ],
        ]);

        $this->forge->addKey('id', true);

        // Foreign Key
        $this->forge->addForeignKey('tahun_id', 'tahun_anggaran', 'id', 'CASCADE', 'CASCADE');

        // Buat tabel
        $this->forge->createTable('tw_settings');
    }

    public function down()
    {
        // Hapus tabel
        $this->forge->dropTable('tw_settings', true);
    }
}
