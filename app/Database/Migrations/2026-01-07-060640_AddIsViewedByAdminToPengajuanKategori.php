<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddIsViewedByAdminToPengajuanKategori extends Migration
{
    public function up()
    {
        $fields = [
            'is_viewed_by_admin' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
                'null' => false,
                'after' => 'status' // letakkan setelah kolom status
            ]
        ];

        $this->forge->addColumn('pengajuan_kategori_dokumen', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('pengajuan_kategori_dokumen', 'is_viewed_by_admin');
    }
}
