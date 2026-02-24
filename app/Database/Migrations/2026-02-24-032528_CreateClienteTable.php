<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateClienteTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => [ 'type' => 'INT', 'auto_increment' => true ],
            'nome'          => [ 'type' => 'VARCHAR', 'constraint' => '100' ],
            'email'         => [ 'type' => 'VARCHAR', 'constraint' => '100' ],
            'document'      => [ 'type' => 'VARCHAR', 'constraint' => '14' ],
            'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL',
            'updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey(['email'], false, true, 'email_unique');
        
        $attributes = ['ENGINE' => 'InnoDB'];
        $this->forge->createTable('cliente', true, $attributes);
    }

    public function down()
    {
        $this->forge->dropTable('cliente');
    }
}
