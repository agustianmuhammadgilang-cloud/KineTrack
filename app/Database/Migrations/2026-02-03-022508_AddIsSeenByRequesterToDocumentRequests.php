<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddIsSeenByRequesterToDocumentRequests extends Migration
{
    public function up()
    {
        $this->forge->addColumn('document_requests', [
            'is_seen_by_requester' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
                'after'      => 'status', // opsional, biar rapi
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('document_requests', 'is_seen_by_requester');
    }
}
