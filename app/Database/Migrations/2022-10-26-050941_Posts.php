<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Posts extends Migration
{
    public function up()
    {
        $this->forge->addField([
          'post_id' => [
            'type'           => 'bigint',            
            'unsigned'       => true,
            'auto_increment' => true,
          ],
          'title' => [
            'type'  => 'varchar',
            'constraint'=> '100',
            'null'  => false
          ],
          'content' => [
            'type' => 'varchar',
            'constraint' => '512',
            'null' => false
          ],
          'author' => [
            'type' => 'varchar',
            'constraint' => 100
          ],
          //'created_at varchar(25) DEFAULT CURRENT_TIMESTAMP',
          // 'updated_at varchar(25) DEFAULT CURRENT_TIMESTAMP',
          // 'deleted_at varchar(25) DEFAULT NULL CURRENT_TIMESTAMP',
        ]);
        $this->forge->addKey('post_id');
        $this->forge->createTable('Posts');
    }

    public function down()
    {
        $this->forge->dropTable('Posts');
    }
}
