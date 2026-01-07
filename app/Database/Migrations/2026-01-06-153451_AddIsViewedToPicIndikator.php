<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddIsViewedToPicIndikator extends Migration
{
    public function up()
    {
        $this->forge->addColumn('pic_indikator', [
            'is_viewed_by_staff' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
                'after'      => 'jabatan_id',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('pic_indikator', 'is_viewed_by_staff');
    }
}
