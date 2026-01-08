<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDokumenViewsTable extends Migration
{
    public function up()
{
    $this->forge->addField([
        'id' => [
            'type'           => 'BIGINT',
            'constraint'     => 20,
            'unsigned'       => true,
            'auto_increment' => true,
        ],
        'dokumen_id' => [
            'type'       => 'BIGINT',
            'constraint' => 20,
            'unsigned'   => true,
        ],
        'user_id' => [
            'type'       => 'BIGINT',
            'constraint' => 20,
            'unsigned'   => true,
        ],
        'viewed_at' => [
            'type' => 'DATETIME',
            'null' => true,
        ],
        'created_at' => [
            'type' => 'DATETIME',
            'null' => true,
        ],
    ]);

    $this->forge->addKey('id', true);
    $this->forge->addUniqueKey(['dokumen_id', 'user_id']);
    $this->forge->createTable('dokumen_views');
}


    public function down()
    {
        $this->forge->dropTable('dokumen_views', true);
    }
}
