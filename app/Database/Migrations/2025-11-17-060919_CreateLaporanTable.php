<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLaporanTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'auto_increment' => true,
                'unsigned'       => true,
            ],

            'user_id' => [
                'type'     => 'INT',
                'unsigned' => true,
            ],

            'judul' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],

            'deskripsi' => [
                'type' => 'TEXT',
            ],

            'tanggal' => [
                'type' => 'DATE',
            ],

            'file_bukti' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],

            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['pending', 'approved', 'rejected'],
                'default'    => 'pending',
            ],

            'catatan_atasan' => [
                'type' => 'TEXT',
                'null' => true,
            ],

            'created_at' => ['type'=>'DATETIME', 'null'=>true],
            'updated_at' => ['type'=>'DATETIME', 'null'=>true],
        ]);

        $this->forge->addKey('id', true);

        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE');

        $this->forge->createTable('laporan');
    }

    public function down()
    {
        $this->forge->dropTable('laporan');
    }
}
