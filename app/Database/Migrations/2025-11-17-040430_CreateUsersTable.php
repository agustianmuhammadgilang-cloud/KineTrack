<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'auto_increment' => true,
                'unsigned'       => true,
            ],

            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],

            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'unique'     => true,
            ],

            'password' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],

            'jabatan_id' => [
                'type'       => 'INT',
                'null'       => true,
                'unsigned'   => true,
            ],

            'bidang_id' => [
                'type'       => 'INT',
                'null'       => true,
                'unsigned'   => true,
            ],

            'role' => [
                'type'       => 'ENUM',
                'constraint' => ['admin','atasan','staff'],
                'default'    => 'staff',
            ],

            'created_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],

            'updated_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],

        ]);

        $this->forge->addKey('id', true);

        // foreign key kalau nanti jabatan + bidang sudah ada tabelnya
        // sementara bisa disable dulu, nanti tinggal aktifkan:

        // $this->forge->addForeignKey('jabatan_id', 'jabatan', 'id', 'CASCADE', 'SET NULL');
        // $this->forge->addForeignKey('bidang_id', 'bidang', 'id', 'CASCADE', 'SET NULL');

        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
