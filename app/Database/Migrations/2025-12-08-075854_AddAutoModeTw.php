<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAutoModeTw extends Migration
{
   public function up()
{
    $this->forge->addColumn('tw_settings', [
        'auto_mode' => [
            'type' => 'TINYINT',
            'constraint' => 1,
            'default' => 1,
            'after' => 'is_open'
        ]
    ]);
}

public function down()
{
    $this->forge->dropColumn('tw_settings', 'auto_mode');
}
}
