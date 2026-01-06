<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDokumenKinerjaTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 10,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'judul' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'deskripsi' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'kategori_id' => [
                'type'       => 'INT',
                'constraint' => 10,
                'unsigned'   => true,
                'null'       => true,
            ],
            'scope' => [
                'type'       => 'ENUM',
                'constraint' => ['personal', 'unit', 'public'],
                'null'       => false,
            ],
            'file_path' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'created_by' => [
                'type'       => 'INT',
                'constraint' => 10,
                'unsigned'   => true,
                'null'       => false,
            ],
            'unit_asal_id' => [
                'type'       => 'INT',
                'constraint' => 10,
                'unsigned'   => true,
                'null'       => false,
            ],
            'unit_jurusan_id' => [
                'type'       => 'INT',
                'constraint' => 10,
                'unsigned'   => true,
                'null'       => false,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => [
                    'pending_kaprodi',
                    'rejected_kaprodi',
                    'approved_kaprodi',
                    'pending_kajur',
                    'rejected_kajur',
                    'archived',
                ],
                'null' => false,
            ],
            'current_reviewer' => [
                'type'       => 'ENUM',
                'constraint' => ['kaprodi', 'kajur'],
                'null'       => false,
            ],
            'catatan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
                'default' => null,
            ],
            'updated_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
                'default' => null,
            ],
            'published_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addPrimaryKey('id');

        // Index (sesuai DESCRIBE -> MUL)
        $this->forge->addKey('created_by');
        $this->forge->addKey('unit_asal_id');
        $this->forge->addKey('unit_jurusan_id');

        $this->forge->createTable('dokumen_kinerja');
    }

    public function down()
    {
        $this->forge->dropTable('dokumen_kinerja');
    }
}
