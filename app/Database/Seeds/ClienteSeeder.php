<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ClienteSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'nome' => 'Diogo Taparello',
            'email'    => 'diogoactaparello@gmail.com',
            'document'    => '02957483033',
        ];

        $this->db->table('cliente')->insert($data);
        
    }
}
