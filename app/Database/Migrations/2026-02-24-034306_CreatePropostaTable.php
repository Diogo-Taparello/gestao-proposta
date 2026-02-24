<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePropostaTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => [ 'type' => 'INT', 'auto_increment' => true ],
            'cliente_id'    => [ 'type' => 'INT' ],
            'produto'       => [ 'type' => 'VARCHAR', 'constraint' => '100' ],
            'valor_mensal'  => [ 'type' => 'DECIMAL', 'constraint' => '10,2', 'null' => false, 'default' => 0.00 ],
            'status'        => [ 'type' => 'ENUM', 'constraint' => ['DRAFT','SUBMITTED','APPROVED','REJECTED','CANCELED'], 'default' => 'DRAFT' ],
            'origem'        => [ 'type' => 'ENUM', 'constraint' => ['APP', 'SITE', 'API'], 'default' => 'API' ],
            'versao'        => [ 'type' => 'INT' ],
            'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL',
            'updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
            'deleted_at'    => [ 'type' => 'TIMESTAMP', 'null' => true ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('cliente_id', 'cliente', 'id', 'CASCADE', 'CASCADE');
        
        $attributes = ['ENGINE' => 'InnoDB'];
        $this->forge->createTable('proposta', true, $attributes);
    }

    public function down()
    {
        $this->forge->dropTable('proposta');
    }
}
