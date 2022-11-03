<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PostsTimestamp extends Migration
{
    public function up()
    {
        $this->forge->addColumn('Posts', [
          'created_at' => [
              'type'    => 'TIMESTAMP',
              'null'    => true,
              'default' => null,
          ],
          'updated_at' => [
              'type'    => 'TIMESTAMP',
              'null'    => true,
              'default' => null,
          ],
          'deleted_at' => [
              'type'    => 'TIMESTAMP',
              'null'    => true,
              'default' => null,
          ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('Posts', 'created_at');
        $this->forge->dropColumn('Posts', 'updated_at');
        $this->forge->dropColumn('Posts', 'deleted_at');
    }
}
