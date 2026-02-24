<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PropostaSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'cliente_id'    => '1',
            'produto'       => 'Produto de Teste',
            'valor_mensal'  => '29.90',
            'status'        => 'APPROVED',
            'origem'        => 'SITE',
            'versao'        => '1'
        ];

        $this->db->table('proposta')->insert($data);
    }
}
