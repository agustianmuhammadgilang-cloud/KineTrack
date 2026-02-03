<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDocumentAccessTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],

            'document_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],

            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],

            'granted_by' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],

            'granted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);

        // Mencegah akses ganda ke dokumen yang sama
        $this->forge->addUniqueKey(['document_id', 'user_id']);

        $this->forge->createTable('document_access');
    }

    public function down()
    {
        $this->forge->dropTable('document_access');
    }
}