<?php

namespace App\Controllers;

use OpenApi\Attributes as OAT;

#[OAT\Info(title: 'API - Gestão de Propostas', version: 'v1.0')]
#[OAT\Server(url:"http://localhost:8080", description:"Servidor Local")]
#[OAT\Tag(name: 'Cliente')]
#[OAT\Tag(name: 'Proposta')]
#[OAT\Tag(name: 'Auditoria')]
class Home extends BaseController
{

    public function index(): string
    {
        $query   = $this->db->query('SELECT * FROM cliente');
        $results = $query->getResultArray();
        var_dump($results);
        die;
        return view('README.md');
    }
}
