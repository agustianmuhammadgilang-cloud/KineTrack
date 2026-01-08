<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddIsViewedByAtasanToDokumenKinerja extends Migration
{
    public function up()
    {
        // Tambahkan kolom is_viewed_by_atasan setelah kolom status
        $fields = [
            'is_viewed_by_atasan' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
                'after'      => 'status',
            ],
        ];
        $this->forge->addColumn('dokumen_kinerja', $fields);
    }

    public function down()
    {
        // Hapus kolom jika rollback
        $this->forge->dropColumn('dokumen_kinerja', 'is_viewed_by_atasan');
    }
}
