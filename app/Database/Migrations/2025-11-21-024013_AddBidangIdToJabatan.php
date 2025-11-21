<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddBidangIdToJabatan extends Migration
{
    public function up()
    {
        // Tambah kolom bidang_id ke tabel jabatan
        $fields = [
            'bidang_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'after' => 'nama_jabatan', // optional, supaya kolom rapi
                'null' => false,
            ]
        ];
        $this->forge->addColumn('jabatan', $fields);

        // Tambah foreign key
        $this->forge->addForeignKey('bidang_id', 'bidang', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->forge->dropColumn('jabatan', 'bidang_id');
    }
}
