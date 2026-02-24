<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AuditoriaSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'proposta_id'   => '1',
            'actor'         => 'Teste',
            'evento'        => 'CREATED',
            'payload'       => json_encode(['cliente' => 1]),
        ];

        $this->db->table('auditoria')->insert($data);
    }
}
