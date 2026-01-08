<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddViewedFlagsToDokumenKinerja extends Migration
{
    public function up()
    {
        $fields = [
            'is_viewed_unit' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
                'after'      => 'published_at',
            ],
            'is_viewed_public' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
                'after'      => 'is_viewed_unit',
            ],
        ];

        $this->forge->addColumn('dokumen_kinerja', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('dokumen_kinerja', [
            'is_viewed_unit',
            'is_viewed_public',
        ]);
    }
}
