<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MainSeeder extends Seeder
{
    public function run()
    {
        $this->call('ClienteSeeder');
        $this->call('PropostaSeeder');
        $this->call('AuditoriaSeeder');
    }
}
