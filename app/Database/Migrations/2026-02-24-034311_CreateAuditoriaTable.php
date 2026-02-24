<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAuditoriaTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => [ 'type' => 'INT', 'auto_increment' => true ],
            'proposta_id'    => [ 'type' => 'INT' ],
            'actor'         => [ 'type' => 'VARCHAR', 'constraint' => '100' ],
            'evento'        => [ 'type' => 'ENUM', 'constraint' => ['CREATED','UPDATED_FIELDS','STATUS_CHANGED','DELETED_LOGICAL'], 'default' => 'CREATED'],
            'payload'       => [ 'type' => 'JSON' ],
            'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL',
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('proposta_id', 'proposta', 'id', 'CASCADE', 'CASCADE');
        
        $attributes = ['ENGINE' => 'InnoDB'];
        $this->forge->createTable('auditoria', true, $attributes);
    }

    public function down()
    {
        $this->forge->dropTable('auditoria');
    }
}
