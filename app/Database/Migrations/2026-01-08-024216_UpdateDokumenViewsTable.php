<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateDokumenViewsTable extends Migration
{
    public function up()
    {
        /**
         * ============================
         * 1. DROP UNIQUE INDEX LAMA
         * (dokumen_id, user_id)
         * ============================
         */
        $indexes = $this->db->query("
            SHOW INDEX FROM dokumen_views
            WHERE Non_unique = 0
        ")->getResultArray();

        foreach ($indexes as $index) {
            // ambil salah satu unique index lama
            if ($index['Column_name'] === 'dokumen_id') {
                $this->db->query("
                    ALTER TABLE dokumen_views
                    DROP INDEX {$index['Key_name']}
                ");
                break;
            }
        }

        /**
         * ============================
         * 2. DROP created_at
         * ============================
         */
        $this->forge->dropColumn('dokumen_views', 'created_at');

        /**
         * ============================
         * 3. TAMBAH menu_type
         * ============================
         */
        $this->forge->addColumn('dokumen_views', [
            'menu_type' => [
                'type'       => 'ENUM',
                'constraint' => ['unit', 'public'],
                'after'      => 'user_id',
            ],
        ]);

        /**
         * ============================
         * 4. TAMBAH UNIQUE BARU
         * ============================
         */
        $this->db->query("
            ALTER TABLE dokumen_views
            ADD UNIQUE KEY dokumen_views_unique
            (dokumen_id, user_id, menu_type)
        ");
    }

    public function down()
    {
        /**
         * Rollback (opsional, jarang dipakai di production)
         */

        // Drop unique baru
        $this->db->query("
            ALTER TABLE dokumen_views
            DROP INDEX dokumen_views_unique
        ");

        // Drop menu_type
        $this->forge->dropColumn('dokumen_views', 'menu_type');

        // Tambah created_at kembali
        $this->forge->addColumn('dokumen_views', [
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        // Kembalikan unique lama
        $this->db->query("
            ALTER TABLE dokumen_views
            ADD UNIQUE KEY dokumen_views_dokumen_user_unique
            (dokumen_id, user_id)
        ");
    }
}
