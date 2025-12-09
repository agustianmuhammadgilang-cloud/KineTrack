<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TwSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();

        // Ambil semua tahun
        $tahun = $db->table('tahun_anggaran')->get()->getResultArray();

        foreach ($tahun as $t) {

            // Cek apakah tahun ini sudah punya TW
            $exists = $db->table('tw_settings')
                ->where('tahun_id', $t['id'])
                ->countAllResults();

            if ($exists == 4) {
                continue; // skip jika sudah lengkap
            }

            // Insert TW1–TW4
            for ($tw = 1; $tw <= 4; $tw++) {
                $db->table('tw_settings')->insert([
                    'tahun_id' => $t['id'],
                    'tw'       => $tw,
                    'is_open'  => 0
                ]);
            }
        }
    }
}
